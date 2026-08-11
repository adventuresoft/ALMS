<?php

namespace App\Http\Controllers;

use App\Models\BasicSettings\Country;
use App\Models\District;
use App\Models\Division;
use App\Models\Farmer;
use App\Models\Religion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class FarmerController extends Controller
{
    public function __construct() {
        $this->middleware('permission:farmer-general-list-read', ['only' => ['index', 'show']]);
        $this->middleware('permission:farmer-general-list-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:farmer-general-list-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:farmer-general-list-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authUser = Auth::user();
        if ($authUser && in_array($authUser->role_id, [13, 5])) {
            abort(403, 'Unauthorized access: Farmers cannot view the general farmer list.');
        }
        // $data['farmers'] = Farmer::with('user.addressInfo.presentThana', 'user.addressInfo.presentUnion' )
        // ->join('users', 'users.id', 'farmers.user_id')
        // ->where('users.is_verified', false)
        // ->paginate(100);
        // return view('backend.pages.farmer.index', $data);
        
        $query = Farmer::with([
            'user.addressInfo.presentDivision',
            'user.addressInfo.presentDistrict',
            'user.addressInfo.presentThana',
            'user.addressInfo.presentUnion'
        ])
        ->join('users', 'users.id', 'farmers.user_id')
        ->where('users.is_verified', false);
    
        // 🔍 Search (name, phone, NID, etc.)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                  ->orWhere('users.system_id', 'like', "%{$search}%")
                  ->orWhere('users.approved_id', 'like', "%{$search}%")
                  ->orWhere('users.nid', 'like', "%{$search}%");
            });
        }
        
         // 🏘️ Filter by Division
        if ($request->filled('division_id')) {
            $query->whereHas('user.addressInfo.presentDivision', function($q) use ($request) {
                $q->where('id', $request->division_id);
            });
        }
        
         // 🏘️ Filter by District
        if ($request->filled('district_id')) {
            $query->whereHas('user.addressInfo.presentDistrict', function($q) use ($request) {
                $q->where('id', $request->district_id);
            });
        }
    
        // 🏙️ Filter by Thana
        if ($request->filled('thana_id')) {
            $query->whereHas('user.addressInfo.presentThana', function($q) use ($request) {
                $q->where('id', $request->thana_id);
            });
        }
    
       
    
        // 📄 Pagination
        $farmers = $query->select('farmers.*', 'users.name', 'users.system_id')
                         ->orderBy('farmers.created_at', 'desc')
                         ->paginate(50)
                         ->withQueryString(); // keep search/filter in URL
        
        $data['farmers'] = $farmers;
        $data['divisions'] = Division::orderBy('name','asc')->get();
    
        return view('backend.pages.farmer.index', $data);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authUser = Auth::user();
        if ($authUser && in_array($authUser->role_id, [13, 5])) {
            abort(403, 'Unauthorized access: Farmers cannot create other farmer accounts.');
        }

        $data['districts'] = District::orderBy('name','asc')->get();
        $data['countries'] = Country::orderBy('name','asc')->get();
        return view('backend.pages.farmer.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $authUser = Auth::user();
        if ($authUser && in_array($authUser->role_id, [13, 5])) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access: Farmers cannot create other farmer accounts.',
                'code' => 403
            ], 403);
        }
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:190|regex:/^[a-zA-Z\s\.\-\(\)]+$/',
            'bn_name' => 'required|max:190|regex:/^[\x{0980}-\x{09FF}\s\.\-\(\)]+$/u',
            'date_of_birth' => 'nullable|max:190',
            'birth_place' => 'nullable|max:190',
            'gender' => 'nullable|max:190',
            'religion' => 'nullable|max:190',
            'blood_group' => 'nullable|max:190',
            'mobile' => 'required|digits:11|regex:/^[0-9]+$/',
            'email'            => 'nullable|max:190|email',
            'birth_certificate' => 'nullable|digits_between:10,17|regex:/^[0-9]+$/|unique:users,birth_certificate',
            'nid' => 'nullable|digits_between:10,17|regex:/^[0-9]+$/|unique:users,nid',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ], [
            'name.regex' => 'Name must contain only English characters.',
            'bn_name.regex' => 'Bangla Name must contain only Bangla characters.',
            'mobile.digits' => 'Mobile number must be exactly 11 digits.',
            'mobile.regex' => 'Mobile number must contain only English digits.',
            'birth_certificate.digits_between' => 'Birth Registration Number must be between 10 and 17 digits.',
            'birth_certificate.regex' => 'Birth Registration Number must contain only English digits.',
            'nid.digits_between' => 'NID Number must be between 10 and 17 digits.',
            'nid.regex' => 'NID Number must contain only English digits.',
        ]);

        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Sorry! Invalid Entry.";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
        }

        DB::beginTransaction();
        try {
            $user = new User();
            $user->role_id = 13; // 13 => Farmer
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->birth_certificate = $request->birth_certificate;
            $user->nid = $request->nid;
            $user->status = $request->status ?? true;
            $user->created_by = Auth::id();
            $user->password = Hash::make('123456');
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
                $farmer = new Farmer();
                $farmer->user_id = $user->id;
                $farmer->bn_name = $request->bn_name;
                $farmer->date_of_birth = $request->date_of_birth;
                $farmer->birth_place = $request->birth_place;
                $farmer->district_id = $request->district_id;
                $farmer->country_id = $request->country_id;
                $farmer->gender = $request->gender;
                $farmer->religion_id = $request->religion;
                $farmer->blood_group = $request->blood_group;
                if ($farmer->save()) {
                    $data['status'] = true;
                    $data['message'] = "Farmer saved successfully.";
                    $data['user'] = $user;
                    $data['farmer'] = $farmer;
                    $data['code'] = 200;
                    $data['redirect_url'] = route('farmer.family', $farmer->user_id);
                } else {
                    $data['status'] = false;
                    $data['message'] = "Farmer save failed! Please try again...";
                    $data['farmer'] = $farmer;
                    $data['code'] = 500;
                }
            }
            DB::commit();
            return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
        } catch (\Throwable $th) {
            DB::rollBack();
            $data['status'] = false;
            $data['errors'] = $th->getMessage();
            $data['message'] = "Something went wrong! Please try again or contact on support...";
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['user'] = User::with('farmer', 'familyInfo', 'addressInfo', 'classificationInfo', 'loanInfos.bank', 'cultivations')->where('id', $id)->first();
        // return response()->json($data, 200);
        return view('backend.pages.farmer.show', $data);
    }

    public function permission($id)
    {
        $data['user'] = User::with('farmer', 'familyInfo', 'addressInfo', 'classificationInfo', 'loanInfos.bank', 'cultivations')->where('id', $id)->first();
        return view('backend.pages.farmer.permission', $data);
    }


    public function showAll(Request $request)
    {
        $data['users'] = User::with('farmer', 'familyInfo', 'addressInfo', 'classificationInfo', 'loanInfos.bank', 'cultivations')
        ->where('role_id', 13)
        ->where('is_verified', $request->status ? 1 :0)
        ->paginate(100);
        return view('backend.pages.farmer.show_all', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $authUser = Auth::user();
        if (in_array($authUser->role_id, [13, 5]) && $authUser->id != $id) {
            abort(403, 'Unauthorized access: You can only edit your own profile.');
        }

        $data['districts'] = District::orderBy('name','asc')->get();
        $data['countries'] = Country::orderBy('name','asc')->get();
        $data['religions'] = Religion::orderBy('name','asc')->get();
        $user = User::with('farmer')->find($id);

        if ($user && !$user->farmer) {
            $farmer = Farmer::create([
                'user_id' => $user->id,
                'bn_name' => $user->name,
            ]);
            $user->load('farmer');
        }

        $data['user']     = $user;
        $data['mainMenu'] = 'Farmer';
        $data['subMenu']  = 'FarmerEdit';
        return view('backend.pages.farmer.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $userID)
    {
        $authUser = Auth::user();
        if (in_array($authUser->role_id, [13, 5]) && $authUser->id != $userID) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized access: You can only update your own profile.',
                'code' => 403
            ], 403);
        }
        $validate = Validator::make($request->all(), [
            'name'             => 'required|max:190|regex:/^[a-zA-Z\s\.\-\(\)]+$/',
            'bn_name'          => 'required|max:190|regex:/^[\x{0980}-\x{09FF}\s\.\-\(\)]+$/u',
            'date_of_birth'    => 'nullable|max:190',
            'birth_place'      => 'nullable|max:190',
            'gender'           => 'nullable|max:190',
            'religion'         => 'nullable|max:190',
            'blood_group'      => 'nullable|max:190',
            'mobile'           => 'required|digits:11|regex:/^[0-9]+$/',
            'email'            => 'nullable|max:190|email',
            'birth_certificate'=> 'nullable|digits_between:10,17|regex:/^[0-9]+$/|unique:users,birth_certificate,' . $userID . ',id',
            'nid'              => 'nullable|digits_between:10,17|regex:/^[0-9]+$/|unique:users,nid,' . $userID . ',id',
            'image'            => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ], [
            'name.regex' => 'Name must contain only English characters.',
            'bn_name.regex' => 'Bangla Name must contain only Bangla characters.',
            'mobile.digits' => 'Mobile number must be exactly 11 digits.',
            'mobile.regex' => 'Mobile number must contain only English digits.',
            'birth_certificate.digits_between' => 'Birth Registration Number must be between 10 and 17 digits.',
            'birth_certificate.regex' => 'Birth Registration Number must contain only English digits.',
            'nid.digits_between' => 'NID Number must be between 10 and 17 digits.',
            'nid.regex' => 'NID Number must contain only English digits.',
        ]);


        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Sorry! Invalid Entry.";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
        }
        // dd($request->all());
        DB::beginTransaction();
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
            $farmer = Farmer::firstOrNew(['user_id' => $userID]);
            $farmer->bn_name = $request->bn_name;
            $farmer->date_of_birth = $request->date_of_birth;
            $farmer->birth_place = $request->birth_place;
            $farmer->district_id = $request->district_id;
            $farmer->country_id = $request->country_id;
            $farmer->gender = $request->gender;
            $farmer->religion_id = $request->religion;
            $farmer->blood_group = $request->blood_group;
            if($farmer->save()){
                    $data['status'] = true;
                    $data['message'] = "Farmer updated successfully.";
                    $data['user'] = $user;
                    $data['farmer'] = $farmer;
                    $data['code'] = 200;
                    $data['redirect_url'] = route('farmer.family', $userID);
            }

            DB::commit();
            return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');

        } catch (\Throwable $th) {
            DB::rollBack();
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th->getMessage();
            return response( json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function changeStatus($id)
    {
        // Try to find the approval record
        $user = User::find($id);
        $user->status =$user->status == 1 ? 0 : 1;
        $user->save();
        return back()->with('success', 'Status changed successfully!');
    }
}
