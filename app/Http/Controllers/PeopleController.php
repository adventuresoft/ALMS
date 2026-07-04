<?php

namespace App\Http\Controllers;

use App\Models\BasicSettings\AccountType;
use App\Models\BasicSettings\Bank;
use App\Models\BasicSettings\Country;
use App\Models\BasicSettings\FamilyCategory;
use App\Models\BasicSettings\FamilyType;
use App\Models\People\EducationalInfo;
use App\Models\People\FinancialInfo;
use App\Models\People\DisabilityInfo;
use App\Models\People\PropertyInfo;
use App\Models\People\FreedomFighterInfo;


use App\Models\People\FamilyInfo;
use App\Models\People\AddressInfo;
use App\Models\People\ProfessionalInfo;
use App\Models\BasicSettings\Profession;
use App\Models\BasicSettings\Village;
use App\Models\District;
use App\Models\Division;
use App\Models\House;
use App\Models\Mouza;
use App\Models\VillageArea;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\People;
use App\Models\Religion;
use App\Models\Road;
use App\Models\Thana;
use App\Models\UnionWard;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PeopleController extends Controller
{

    public function __construct()
    {
        // $this->middleware('unionAdmin')->except('index', 'show', 'searchUser', 'searchLoanUser', 'searchPaymentUser');
    }


    public function searchUser($system_id)
    {
        $user = User::with( 'people', 'familyInfo', 'loanInfos.branch.bank')->where('system_id', $system_id)->first();

        if($user) {
            $data['status'] = true;
            $data['message'] = "People information loaded.";
            $data['user'] = $user;
            return response()->json($data, 200);
        }else {
            $data['status'] = false;
            $data['message'] = "People not found.";
            $data['user'] = $user;
            return response()->json($data, 500);
        }
    }

    public function searchLoanUser($system_id)
    {
        $data['user'] = User::with( 'farmer', 'familyInfo', 'loanInfos.branch.bank')->where('system_id', $system_id)->first();
        return view('backend.pages.loan.history', $data);
    }

    public function searchPaymentUser($system_id)
    {
        $data['user'] = User::with( 'farmer', 'familyInfo', 'loanInfos.branch.bank', 'loanInfos.payments')->where('system_id', $system_id)->first();
        return view('backend.pages.loan.payment_history', $data);
    }








    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->institute_id) {
            $data['users'] = People::with('user')->latest()->get();
        } else {
            $data['users'] = People::with('user')->latest()->get();
        }
        return view('backend.pages.people.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        $data['religions'] = Religion::where('status', true)->get();
        $data['districts'] =  District::where('status', true)->orderBy('name')->get();
        $data['countries'] =  Country::orderBy('name')->get();
        return view('backend.pages.people.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:190',
            'bn_name' => 'required|max:190',
            'date_of_birth' => 'nullable|max:190',
            'birth_place' => 'nullable|max:190',
            'gender' => 'nullable|max:190',
            'religion' => 'nullable|max:190',
            'blood_group' => 'nullable|max:190',
            'mobile' => 'nullable|max:190',
            'email' => 'required|max:190',
            'birth_certificate' => 'nullable|max:190',
            'nid' => 'nullable|max:190',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Sorry! Invalid Entry.";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
        }

        $result = DB::transaction(function () use ($request) {
            try {
                $user = new User();
                $user->role_id = 5; // 5 => User Role
                // $user->institute_id = Auth::user()->institute_id ?? '';

                $user->name = $request->name;
                $user->email = $request->email;
                $user->mobile = $request->mobile;
                $user->birth_certificate = $request->birth_certificate;
                $user->nid = $request->nid;
                $user->status = $request->status ?? true;
                $user->created_by = Auth::id();
                $user->password = Hash::make('12345678');
                $image = $request->file('image');
                if ($image) {
                    $image_name = $request->name.'-'.rand(1111,9999);
                    $ext = strtolower($image->getClientOriginalExtension());
                    $image_full_name = $image_name . "." . $ext;
                    $upload_path = 'uploads/users/';
                    $image_url = $upload_path . $image_full_name;
                    $success = $image->move($upload_path, $image_full_name);
                    if ($success) {
                        $user->image = $image_url;
                    }
                }
                if ($user->save()) {
                    $people = new People();
                    $people->user_id = $user->id;
                    $people->bn_name = $request->bn_name;
                    $people->date_of_birth = $request->date_of_birth;
                    $people->birth_place = $request->birth_place;
                    $people->district_id = $request->district_id;
                    $people->country_id = $request->country_id;
                    $people->gender = $request->gender;
                    $people->religion_id = $request->religion;
                    $people->blood_group = $request->blood_group;
                    if ($people->save()) {
                        $data['status'] = true;
                        $data['message'] = "People saved successfully.";
                        $data['user'] = $user;
                        $data['people'] = $people;
                        $data['code'] = 200;
                        $data['redirect_url'] = route('people.address', $people->user_id);
                        return $data;
                    } else {
                        $data['status'] = false;
                        $data['message'] = "People save failed! Please try again...";
                        $data['people'] = $people;
                        $data['code'] = 500;
                        return $data;
                    }
                }
            } catch (\Throwable $th) {

                    Log::error('People store failed', [
        'error_message' => $th->getMessage(),
        'file' => $th->getFile(),
        'line' => $th->getLine(),
        'trace' => $th->getTraceAsString(),
        'request_data' => $request->all(), // optional — include input for debugging
        'user_id' => Auth::id(), // optional — who caused it
    ]);

                $data['status'] = false;
                $data['code'] = 500;
                $data['errors'] = $th;
                $data['message'] = "Something went wrong! Please try again or contact on support...";
                return $data;
            }
        });
        return response(json_encode($result, JSON_PRETTY_PRINT), $result['code'])->header('Content-Type', 'application/json');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['religions'] = Religion::where('status', true)->get();
        $data['districts'] =  District::where('status', true)->orderBy('name')->get();
        $data['countries'] =  Country::orderBy('name')->get();
        $data['religions'] = Religion::where('status', true)->get();
        $data['familyTypes'] = FamilyType::where('status', true)->get();
        $data['familyCategories'] = FamilyCategory::where('status', true)->get();
        $data['user'] = $user = User::with('familyInfo', 'educationInfos', 'financialInfos', 'propertyInfos', 'disabilityInfo', 'freedomFighterInfo')
        ->with( 'institute')
        ->with(array('addressInfo' => function($address){
            $address->with('presentUnion', 'permanentHouse', 'presentHouse', 'presentRoad', 'permanentRoad',  'presentVillage', 'presentDistrict', 'presentThana');
        }))
        ->with(array('professionalInfos' => function($q1){
            $q1->with(array('subcategory' => function($q2){
                $q2->with(array('category' => function($q3){
                    $q3->with(array('type'=> function($q4){
                        $q4->with('profession');
                    }));
                }));
            }));
        }))
        ->find($id);


        $data['religions'] = Religion::where('status', true)->get();
        $data['villages'] = [];
        $data['wards'] = [];
        $data['permanent_houses'] = [];
        if(isset($user->institute->institute_type_id) && $user->institute->institute_type_id == 1) {
            $data['villages'] = Village::where('union_id', $user->institute->union_id)->get();
            $data['wards'] = UnionWard::where('status', true)->get();
            $data['roads'] = Road::where('institute_id',  $user->institute->id)->latest()->get();
        } else if (isset($user->institute->institute_type_id) && $user->institute->institute_type_id == 2) {

        } else if (isset($user->institute->institute_type_id) && $user->institute->institute_type_id == 3) {

        }
        $data['divisions'] = Division::where('status', true)->get();

        if($user->addressInfo){
            if($user->addressInfo->permanent_ward_id){
                $data['permanent_houses'] = House::where('institute_id',  $user->institute->id)
                ->where('union_ward_id', $user->addressInfo->permanent_ward_id)
                ->latest()
                ->get();
            }
        }
        $data['professions'] = Profession::where('status', true)->get();

        $data['account_types'] = AccountType::where('status', true)->latest()->get();
        $data['banks'] = Bank::where('status', true)->latest()->get();

        $data['landThanas'] = $user->propertyInfos ? ($user->propertyInfos->land_district_id ?  Thana::where('district_id', $user->propertyInfos->land_district_id )->get() : []  ) : [];
        $data['landMouzas'] = $user->propertyInfos ? ($user->propertyInfos->land_thana_id ?  Mouza::where('thana_id', $user->propertyInfos->land_thana_id )->get() : []  ) : [];

        $data['flatThanas'] = $user->propertyInfos ? ($user->propertyInfos->flat_district_id ?  Thana::where('district_id', $user->propertyInfos->flat_district_id )->get() : []  ) : [];
        $data['flatMouzas'] = $user->propertyInfos ? ($user->propertyInfos->flat_thana_id ?  Mouza::where('thana_id', $user->propertyInfos->flat_thana_id )->get() : []  ) : [];



        return view('backend.pages.people.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['religions'] = Religion::where('status', true)->get();
        $data['districts'] =  District::where('status', true)->orderBy('name')->get();
        $data['countries'] =  Country::orderBy('name')->get();

        $data['user'] =  User::with('people')->find($id);



        return view('backend.pages.people.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userID)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:190',
            'bn_name' => 'required|max:190',
            'date_of_birth' => 'nullable|max:190',
            'birth_place' => 'nullable|max:190',
            'gender' => 'nullable|max:190',
            'religion' => 'nullable|max:190',
            'blood_group' => 'nullable|max:190',
            'mobile' => 'nullable|max:190',
            'email' => 'required|max:190|email',
            'birth_certificate' => 'nullable|max:190',
            'nid' => 'nullable|max:190',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Sorry! Invalid Entry.";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
        }

        $result = DB::transaction(function () use ($request, $userID) {
                $user = User::find($userID);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->mobile = $request->mobile;
                $user->birth_certificate = $request->birth_certificate;
                $user->nid = $request->nid;
                $user->status = $request->status ?? true;
                $user->updated_by = Auth::id();

                $image = $request->file('image');
                if ($image) {
                    if ($user->image) {unlink($user->image);}
                    $image_name = $user->username;
                    $ext = strtolower($image->getClientOriginalExtension());
                    $image_full_name = $image_name . "." . $ext;
                    $upload_path = 'uploads/users/';
                    $image_url = $upload_path . $image_full_name;
                    $success = $image->move($upload_path, $image_full_name);
                    if ($success) { $user->image = $image_url; }
                }


                try {
                    $user->save();
                    $people = People::firstOrNew(['user_id' => $userID]);
                    $people->bn_name = $request->bn_name;
                    $people->date_of_birth = $request->date_of_birth;
                    $people->birth_place = $request->birth_place;
                    $people->district_id = $request->district_id;
                    $people->country_id = $request->country_id;
                    $people->gender = $request->gender;
                    $people->religion_id = $request->religion;
                    $people->blood_group = $request->blood_group;

                    try {
                        $people->save();
                        $data['status'] = true;
                        $data['message'] = "People updated successfully.";
                        $data['user'] = $user;
                        $data['people'] = $people;
                        $data['code'] = 200;
                        $data['redirect_url'] = route('people.family', $userID);
                        return $data;
                    } catch (\Throwable $th) {
                        $data['status'] = false;
                        $data['message'] = "Something went wrong! Please try again...";
                        $data['code'] = 500;
                        $data['errors'] = $th;
                        return $data;
                    }
                } catch (\Throwable $th) {
                    $data['status'] = false;
                    $data['message'] = "Something went wrong! Please try again...";
                    $data['code'] = 500;
                    $data['errors'] = $th;
                    return $data;
                }

        });

        return response(json_encode($result, JSON_PRETTY_PRINT), $result['code'])->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\People  $people
     * @return \Illuminate\Http\Response
     */
    public function destroy(People $people)
    {
        //
    }

    // family start 

     public function family($id)
    {
        $data['user'] = User::with('familyInfo')->find($id);


        return view('backend.pages.people.tabs.family', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function familyStore(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'father_name' => 'nullable|max:190',
            'father_nid' => 'nullable|max:190',
            'mother_name' => 'nullable|max:190',            
            'mother_nid' => 'nullable|max:190',
            'marital_status' => 'nullable|max:190'
        ]);

        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Sorry! Invalid Entry.";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
        }

        DB::beginTransaction();
        try {

            $peopleFamily = FamilyInfo::updateOrCreate([
                'user_id' => $request->user_id
            ], [
                'father_name' => $request->father_name,
                'father_nid' => $request->father_nid,
                'mother_name' => $request->mother_name,
                'mother_nid' => $request->mother_nid,
                'marital_status' => $request->marital_status,
            ]);

            DB::commit();
            $data['status'] = true;
            $data['message'] = "Family submitted successfully!";
            $data['result'] = $peopleFamily;
            $data['redirect_url'] = route('people.address', $request->user_id);
            return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
        } catch (\Throwable $th) {
            DB::rollBack();
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th->getMessage();
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }

     public function address($id)
    {
        $user = User::with( 'institute')
        ->with(array('addressInfo' => function($address){
            $address->with('presentUnion', 'permanentHouse', 'presentHouse', 'presentRoad', 'permanentRoad',  'presentVillage', 'presentDistrict', 'presentThana');
        }))
        ->find($id);
        $data['user'] = $user;
        $data['religions'] = Religion::where('status', true)->get();
        $data['villages'] = [];
        $data['permanentVillageAreas'] = [];
        $data['presentVillageAreas'] = [];
        $data['wards'] = [];
        $data['permanent_houses'] = [];
       
            $data['villages'] = Village::where('status',true)->get();
            $data['wards'] = UnionWard::where('status', true)->get();
            $data['roads'] = Road::latest()->get();
      
        $data['divisions'] = Division::where('status', true)->get();

        if($user->addressInfo){
            if($user->addressInfo->permanent_ward_id){
                $data['permanent_houses'] = House::where('union_ward_id', $user->addressInfo->permanent_ward_id)
                ->latest()
                ->get();
            }
            $data['permanentVillageAreas'] = VillageArea::where('village_id',$user->addressInfo->permanent_village_id)->get();
            $data['presentVillageAreas'] = VillageArea::where('village_id',$user->addressInfo->present_village_id)->get();

        }

        // return response()->json($data, 200);

        return view('backend.pages.people.tabs.address', $data);
    }

    public function addressStore(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'permanent_division_id' => 'nullable',
                'permanent_district_id' => 'nullable',
                'permanent_thana_id' => 'nullable',
                'permanent_union_id' => 'nullable',
                'permanent_ward_id' => 'nullable',
                'permanent_village_id' => 'nullable',
                'permanent_road' => 'nullable',
                'permanent_house' => 'nullable',
                'permanent_flat' => 'nullable',
                'present_division_id' => 'nullable',
                'present_district_id' => 'nullable',
                'present_thana_id' => 'nullable',
                'present_union_id' => 'nullable',
                'present_ward_id' => 'nullable',
                'present_village_id' => 'nullable',
                'present_road' => 'nullable',
                'present_house' => 'nullable',
                'present_flat' => 'nullable',
                'present_start_date' => 'nullable',
            ]);

            if ($validate->fails()) {
                $data['status'] = false;
                $data['message'] = "Sorry! Invalid Entry.";
                $data['errors'] = $validate->errors();
                return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
            }

            $result = DB::transaction(function () use ($request) {

                $peopleFamily = AddressInfo::updateOrCreate([
                    'user_id' => $request->user_id
                ], [
                    'permanent_division_id' => $request->permanent_division_id,
                    'permanent_district_id' => $request->permanent_district_id,
                    'permanent_thana_id' => $request->permanent_thana_id,
                    'permanent_union_id' => $request->permanent_union_id,
                    'permanent_ward_id' => $request->permanent_ward_id,
                    'permanent_village_id' => $request->permanent_village_id,
                    'permanent_village_area_id' => $request->permanent_village_area_id,
                    'permanent_road' => $request->permanent_road,
                    'permanent_house' => $request->permanent_house,
                    'permanent_flat' => $request->permanent_flat,
                    'permanent_area' => $request->permanent_area,
                    'permanent_area_bn' => $request->permanent_area_bn,
                    'present_division_id' => $request->present_division_id,
                    'present_district_id' => $request->present_district_id,
                    'present_thana_id' => $request->present_thana_id,
                    'present_union_id' => $request->present_union_id,
                    'present_ward_id' => $request->present_ward_id,
                    'present_village_id' => $request->present_village_id,
                    'present_village_area_id' => $request->present_village_area_id,

                    'present_road' => $request->present_road,
                    'present_house' => $request->present_house,
                    'present_area' => $request->present_area,
                    'present_area_bn' => $request->present_area_bn,
                    'present_flat' => $request->present_flat,
                    'present_start_date' => $request->present_start_date,
                ]);



                if ($peopleFamily) {
                    $data['status'] = true;
                    $data['message'] = "Address submitted successfully!";
                    $data['result'] = $peopleFamily;
                    $data['code'] = 200;
                    $data['redirect_url'] = route('people.index');
                    return $data;
                } else {
                    $data['status'] = false;
                    $data['message'] = "Family comment save failed!";
                    $data['code'] = 500;
                    return $data;
                }
            });

            return response(json_encode($result, JSON_PRETTY_PRINT), $result['code'])->header('Content-Type', 'application/json');
        } catch (\Throwable $th) {

              Log::error('People store failed', [
        'error_message' => $th->getMessage(),
        'file' => $th->getFile(),
        'line' => $th->getLine(),
        'trace' => $th->getTraceAsString(),
        'request_data' => $request->all(), // optional — include input for debugging
        'user_id' => Auth::id(), // optional — who caused it
    ]);

            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th;
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }
    public function education($id)
    {
        $data['user'] = User::with('educationInfos')->find($id);
        $data['religions'] = Religion::where('status', true)->get();
        return view('backend.pages.people.tabs.educational', $data);
    }
    public function educationStore(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            $user_id = $request->user_id;
            $degree_id = $request->degree_id;
            $group_id = $request->group_id;
            $grade_id = $request->grade_id;
            $board_id = $request->board_id;
            $institute = $request->institute;

            $degree_idU = $request->degree_idU;
            $group_idU = $request->group_idU;
            $grade_idU = $request->grade_idU;
            $board_idU = $request->board_idU;
            $instituteU = $request->instituteU;

            try {
                if (!empty($degree_id)) {
                    foreach ($degree_id as $key => $degree) {
                        $education = new EducationalInfo();
                        $education->degree_id = $degree;
                        $education->group_id = $group_id[$key];
                        $education->grade_id = $grade_id[$key];
                        $education->board_id = $board_id[$key];
                        $education->institute = $institute[$key];
                        $education->user_id = $user_id;
                        $education->save();
                    }
                }

                if (!empty($degree_idU)) {
                    foreach ($degree_idU as $index => $deg) {
                        $education = EducationalInfo::find($index);
                        $education->degree_id = $deg;
                        $education->group_id = $group_idU[$index];
                        $education->grade_id = $grade_idU[$index];
                        $education->board_id = $board_idU[$index];
                        $education->institute = $instituteU[$index];
                        $education->save();
                    }
                }

                $data['status'] = true;
                $data['message'] = "Education submitted successfully!";
                $data['redirect_url'] = route('people.professional', $request->user_id);
                $data['code'] = 200;
                return $data;
            } catch (\Throwable $th) {
                $data['status'] = true;
                $data['message'] = "Education submitted successfully!";
                $data['code'] = 200;
                $data['errors'] = $th;
                return $data;
            }



        });

        return response(json_encode($result, JSON_PRETTY_PRINT), $result['code'])->header('Content-Type', 'application/json');
        
    }
    public function professional($id)
    {
        $data['user'] = User::with(array('professionalInfos' => function($q1){
            $q1->with(array('subcategory' => function($q2){
                $q2->with(array('category' => function($q3){
                    $q3->with(array('type'=> function($q4){
                        $q4->with('profession');
                    }));
                }));
            }));
        }))->find($id);
        $data['professions'] = Profession::where('status', true)->get();
        // return response()->json($data,  200);
        return view('backend.pages.people.tabs.professional', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function professionalStore(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            $user_id = $request->user_id;

            $profession = $request->profession_subcategory;
            $profession_start = $request->profession_start;
            $profession_end = $request->profession_end;
            $organization = $request->organization;
            $designation = $request->designation;
            $address = $request->address;

            $professionU = $request->profession_subcategoryU;
            $profession_startU = $request->profession_startU;
            $profession_endU = $request->profession_endU;
            $organizationU = $request->organizationU;
            $designationU = $request->designationU;
            $addressU = $request->addressU;

            try {

                if (!empty($profession)) {
                    foreach ($profession as $key => $pro) {
                        $prof = new ProfessionalInfo();
                        $prof->profession_subcategory_id = $pro;
                        $prof->profession_start = $profession_start[$key];
                        $prof->profession_end = $profession_end[$key];
                        $prof->organization = $organization[$key];
                        $prof->designation = $designation[$key];
                        $prof->address = $address[$key];
                        $prof->user_id = $user_id;
                        $prof->save();
                    }
                }

                if (!empty($professionU)) {
                    foreach ($professionU as $key => $pr) {
                        $profs = ProfessionalInfo::find($key);
                        $profs->profession_subcategory_id = $pr;
                        $profs->profession_start = $profession_startU[$key];
                        $profs->profession_end = $profession_endU[$key];
                        $profs->organization = $organizationU[$key];
                        $profs->designation = $designationU[$key];
                        $profs->address = $addressU[$key];
                        $profs->save();
                    }
                }

                $data['status'] = true;
                $data['message'] = "Profession submitted successfully!";
                $data['code'] = 200;
                $data['redirect_url'] = route('people.financial', $request->user_id);
                return $data;

            } catch (\Throwable $th) {
                  Log::error('People store failed', [
        'error_message' => $th->getMessage(),
        'file' => $th->getFile(),
        'line' => $th->getLine(),
        'trace' => $th->getTraceAsString(),
        'request_data' => $request->all(), // optional — include input for debugging
        'user_id' => Auth::id(), // optional — who caused it
    ]);

                $data['status'] = false;
                $data['code'] = 500;
                $data['message'] = "Something went wrong! Please try again...";
                $data['errors'] = $th;
                return $data;

            }




        });

        return response(json_encode($result, JSON_PRETTY_PRINT), $result['code'])->header('Content-Type', 'application/json');

    }
    public function financial($id)
    {
        $data['user'] = User::with('financialInfos')->find($id);
        $data['account_types'] = AccountType::where('status', true)->latest()->get();
        $data['banks'] = Bank::where('status', true)->latest()->get();
        return view('backend.pages.people.tabs.financial', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function financialStore(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            $user_id = $request->user_id;
            $account_no = $request->account_no;
            $account_type = $request->account_type_id;
            $bank_id = $request->bank_id;
            $account_balance = $request->account_balance;

            $account_noU = $request->account_noU;
            $account_typeU = $request->account_typeU;
            $bank_idU = $request->bank_idU;
            $account_balanceU = $request->account_balanceU;

                try {
            if (!empty($account_no)) {
                foreach ($account_no as $key => $acc_no) {
                    $financialInfo = new FinancialInfo();
                    $financialInfo->account_no = $acc_no;
                    $financialInfo->account_type_id = $account_type[$key];
                    $financialInfo->bank_id = $bank_id[$key];
                    $financialInfo->account_balance = $account_balance[$key];
                    $financialInfo->user_id = $user_id;
                    $financialInfo->save();
                }
            }

            if (!empty($account_noU)) {
                foreach ($account_noU as $index => $acc) {
                    $financialInfo = FinancialInfo::find($index);
                    $financialInfo->account_no = $acc;
                    $financialInfo->account_type_id = $account_typeU[$index];
                    $financialInfo->bank_id = $bank_idU[$index];
                    $financialInfo->account_balance = $account_balanceU[$index];
                    $financialInfo->save();
                }
            }

                $data['status'] = true;
                $data['message'] = "Financial data submitted successfully!";
                $data['code'] = 200;
                $data['redirect_url'] = route('people.property', $request->user_id);
                return $data;
                } catch (\Throwable $th) {
                    $data['code'] = 500;
                    $data['status'] = false;
                    $data['message'] = "Something went wrong! Please try again...";
                    $data['errors'] = $th;
                    return $data;
                }






        });

        return response(json_encode($result, JSON_PRETTY_PRINT), $result['code'])->header('Content-Type', 'application/json');

    }

    public function property($id)
    {
        $user = User::with('propertyInfos')->find($id);
        $data['districts'] = District::latest()->get();
        $data['user']  = $user;

        $data['landThanas'] = $user->propertyInfos ? ($user->propertyInfos->land_district_id ?  Thana::where('district_id', $user->propertyInfos->land_district_id )->get() : []  ) : [];
        $data['landMouzas'] = $user->propertyInfos ? ($user->propertyInfos->land_thana_id ?  Mouza::where('thana_id', $user->propertyInfos->land_thana_id )->get() : []  ) : [];

        $data['flatThanas'] = $user->propertyInfos ? ($user->propertyInfos->flat_district_id ?  Thana::where('district_id', $user->propertyInfos->flat_district_id )->get() : []  ) : [];
        $data['flatMouzas'] = $user->propertyInfos ? ($user->propertyInfos->flat_thana_id ?  Mouza::where('thana_id', $user->propertyInfos->flat_thana_id )->get() : []  ) : [];

        return view('backend.pages.people.tabs.property', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function propertyStore(Request $request)
    {
        // try {
        $validate = Validator::make($request->all(), [
            'user_id' => 'nullable',
            'cash_amount' => 'integer|nullable',
            'tin_number' => 'nullable',
            'house' => 'nullable',
            'house_type' => 'nullable',
            'house_area' => 'nullable',
            'house_land_quantity' => 'nullable',
            'house_price' => 'nullable',
            'house_ownership_status' => 'nullable',
            'house_address' => 'nullable',
            'land' => 'nullable',
            'land_district_id' => 'nullable',
            'land_thana_id' => 'nullable',
            'land_mouza_id' => 'nullable',
            'land_khatian_id' => 'nullable',
            'land_dag_no' => 'nullable',
            'land_bs' => 'nullable',
            'land_rs' => 'nullable',
            'land_sa' => 'nullable',

            'land_cs' => 'nullable',
            'land_quantity' => 'nullable',
            'land_type' => 'nullable',
            'land_ownership_status' => 'nullable',
            'flat' => 'nullable',
            'flat_district_id' => 'nullable',
            'flat_thana_id' => 'nullable',
            'flat_mouza_id' => 'nullable',
            'flat_area' => 'nullable',
            'flat_road' => 'nullable',
            'flat_house_no' => 'nullable',
            'flat_quantity' => 'nullable',
            'flat_price' => 'nullable',
            'flat_ownership_status' => 'nullable',

            'diamond' => 'nullable',
            'diamond_type' => 'nullable',
            'diamond_quantity' => 'nullable',
            'diamond_price' => 'nullable',
            'diamond_ownership_status' => 'nullable',
            'gold' => 'nullable',
            'gold_type' => 'nullable',
            'gold_quantity' => 'nullable',
            'gold_price' => 'nullable',
            'gold_ownership_status' => 'nullable',

            'silver' => 'nullable',
            'silver_type' => 'nullable',
            'silver_quantity' => 'nullable',
            'silver_price' => 'nullable',
            'silver_ownership_status' => 'nullable'
        ]);

        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Sorry! Invalid Entry.";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
        }

        $result = DB::transaction(function () use ($request) {

            $peopleFamily = PropertyInfo::updateOrCreate([
                'user_id' => $request->user_id
            ], [
                'is_property' => $request->is_property,
                'cash_amount' => $request->cash_amount ?? 0.00,
                'tin_number' => $request->tin_number,
                'house' => $request->house ?? 0,
                'house_type' => $request->house_type,
                'house_area' => $request->house_area,
                'house_land_quantity' => $request->house_land_quantity,
                'house_price' => $request->house_price ?? 0.00,
                'house_ownership_status' => $request->house_ownership_status,
                'house_address' => $request->house_address,
                'land' => $request->land ?? 0,
                'land_district_id' => $request->land_district_id,
                'land_thana_id' => $request->land_thana_id,
                'land_mouza_id' => $request->land_mouza_id,
                'land_khatian_id' => $request->land_khatian_id,
                'land_dag_no' => $request->land_dag_no,
                'land_bs' => $request->land_bs,
                'land_rs' => $request->land_rs,
                'land_sa' => $request->land_sa,
                'land_cs' => $request->land_cs,


                'land_quantity' => $request->land_quantity,
                'land_type' => $request->land_type,
                'land_ownership_status' => $request->land_ownership_status,
                'land_type' => $request->land_type,
                'land_ownership_status' => $request->land_ownership_status,
                'flat' => $request->flat ?? 0,
                'flat_district_id' => $request->flat_district_id,
                'flat_thana_id' => $request->flat_thana_id,
                'flat_mouza_id' => $request->flat_mouza_id,
                'flat_area' => $request->flat_area,
                'flat_road' => $request->flat_road,
                'flat_house_no' => $request->flat_house_no,
                'flat_quantity' => $request->flat_quantity,
                'flat_price' => $request->flat_price ?? 0.00,
                'flat_ownership_status' => $request->flat_ownership_status,
                'diamond' => $request->diamond ?? 0,
                'diamond_type' => $request->diamond_type,
                'diamond_quantity' => $request->diamond_quantity,
                'diamond_price' => $request->diamond_price ?? 0.00,
                'diamond_ownership_status' => $request->diamond_ownership_status,

                'gold' => $request->gold ?? 0,
                'gold_type' => $request->gold_type,
                'gold_quantity' => $request->gold_quantity,
                'gold_price' => $request->gold_price ?? 0.00,
                'gold_ownership_status' => $request->gold_ownership_status,
                'silver' => $request->silver ?? 0,
                'silver_type' => $request->silver_type,
                'silver_quantity' => $request->silver_quantity,
                'silver_price' => $request->silver_price ?? 0.00,
                'silver_ownership_status' => $request->silver_ownership_status
            ]);



            if ($peopleFamily) {
                $data['status'] = true;
                $data['message'] = "Property submitted successfully!";
                $data['result'] = $peopleFamily;
                $data['code'] = 200;
                $data['redirect_url'] = route('people.disability', $request->user_id);
                return $data;
            } else {
                $data['status'] = false;
                $data['message'] = "Property save failed!";
                $data['code'] = 500;
                return $data;
            }
        });

        return response(json_encode($result, JSON_PRETTY_PRINT), $result['code'])->header('Content-Type', 'application/json');
        // } catch (\Throwable $th) {
        //     $data['status'] = false;
        //     $data['message'] = "Something went wrong! Please try again...";
        //     $data['errors'] = $th;
        //     return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        // }
    }

    public function disability($id)
    {
        $data['user'] = User::with('disabilityInfo')->find($id);
        return view('backend.pages.people.tabs.disability', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function disabilityStore(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'is_disability' => 'required',
            'disability_name_id' => 'nullable',
            'disability_category_id' => 'nullable',
            'disability_type_id' => 'nullable',
            'start_date' => 'nullable',
            'treatment_status_id' => 'nullable',
            'disability_doctor' => 'nullable',

        ]);

        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Sorry! Invalid Entry.";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
        }

        $query = DB::transaction(function () use ($request) {

            try {
                DisabilityInfo::updateOrCreate([
                    'user_id' => $request->user_id
                ], [
                    'is_disability' => $request->is_disability ?? false,
                    'disability_name_id' => $request->is_disability ? $request->disability_name_id : null,
                    'disability_category_id' => $request->is_disability ? $request->disability_category_id : null,
                    'disability_type_id' => $request->is_disability ? $request->disability_type_id  : null,
                    'start_date' =>  $request->is_disability ? (($request->disability_type_id !=1) ? $request->start_date : null )  : null,
                    'treatment_status_id' => $request->is_disability ? $request->treatment_status_id : null,
                    'disability_doctor' => $request->is_disability ? (($request->treatment_status_id !=1) ? $request->disability_doctor : null )   : null,
                ]);

                $data['status'] = true;
                $data['message'] = "Disability information submitted successfully!";
                $data['code'] = 200;
                $data['redirect_url'] = route('people.freedom', $request->user_id);
                return $data;
            } catch (\Throwable $th) {
                $data['status'] = false;
                $data['message'] = "Disability information save failed!";
                $data['errors'] = $th;
                $data['code'] = 500;
                return $data;
            }
        });

        return response(json_encode($query, JSON_PRETTY_PRINT), $query['code'])->header('Content-Type', 'application/json');       
    }

    public function freedom($id)
    {
        $data['user'] = User::with('freedomFighterInfo')->find($id);
        $data['religions'] = Religion::where('status', true)->get();
        return view('backend.pages.people.tabs.freedom', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function freedomStore(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'is_freedom_fighter' => 'required',
            'type_id' => 'nullable',
            'area_id' => 'nullable',
            'designation_id' => 'nullable',
            'freedom_fighter_id' => 'nullable',
            'commander_name' => 'nullable',

        ]);

        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Sorry! Invalid Entry.";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
        }

        $result = DB::transaction(function () use ($request) {

            try {
                FreedomFighterInfo::updateOrCreate([
                    'user_id' => $request->user_id
                ], [
                    'is_freedom_fighter' => $request->is_freedom_fighter ?? false,
                    'type_id' => $request->is_freedom_fighter ? $request->type_id : null,
                    'area_id' => $request->is_freedom_fighter ? $request->area_id : null,
                    'designation_id' => $request->is_freedom_fighter ? $request->designation_id : null,
                    'freedom_fighter_id' => $request->is_freedom_fighter ? $request->freedom_fighter_id : null,
                    'commander_name' => $request->is_freedom_fighter ? $request->commander_name : null
                ]);

                $data['status'] = true;
                $data['message'] = "Freedom fighter information submitted successfully!";
                $data['code'] = 200;
                $data['redirect_url'] = route('people.index');
                return $data;
            } catch (\Throwable $th) {
                  Log::error('People store failed', [
                    'error_message' => $th->getMessage(),
                    'file' => $th->getFile(),
                    'line' => $th->getLine(),
                    'trace' => $th->getTraceAsString(),
                    'request_data' => $request->all(), // optional — include input for debugging
                    'user_id' => Auth::id(), // optional — who caused it
                ]);
                $data['status'] = false;
                $data['message'] = "Freedom Fighter Information Save Failed!";
                $data['code'] = 500;
                $data['errors'] = $th;
                return $data;
            }
        });

        return response(json_encode($result, JSON_PRETTY_PRINT), $result['code'])->header('Content-Type', 'application/json');

    }
}
