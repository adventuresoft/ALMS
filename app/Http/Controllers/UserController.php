<?php

namespace App\Http\Controllers;

use App\Models\BasicSettings\Country;
use App\Models\BasicSettings\Village;
use App\Models\District;
use App\Models\Farmer;
use App\Models\Religion;
use App\Models\User;
use App\Models\People\AddressInfo;
use App\Models\VillageArea;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // ---- Filters (GET) ----
        $search   = trim((string) $request->get('q', ''));
        $gender   = $request->get('gender'); // farmer.gender (via user relationship)
        $status   = $request->get('status'); // users.status (1/0)
        $dateFrom = $request->get('date_from'); // users.created_at
        $dateTo   = $request->get('date_to');   // users.created_at
        $perPage  = (int) $request->get('per_page', 100);
        if ($perPage <= 0) $perPage = 100;
        if ($perPage > 500) $perPage = 500;

        // ---- Base query scoped tenant-wise ----
        $query = User::query()
            ->with('role', 'addressInfo.presentUnion', 'addressInfo.presentThana', 'farmer')
            ->orderBy('id', 'desc');

        if (!is_superadmin()) {
            $query->where('institute_id', Auth::user()->institute_id);
        }

        // ---- Apply filtering ----
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('system_id', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($gender !== null && $gender !== '') {
            $query->whereHas('farmer', function ($q) use ($gender) {
                $q->where('gender', $gender);
            });
        }

        if ($status !== null && $status !== '') {
            $query->where('status', (int) $status);
        }

        if (!empty($dateFrom)) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if (!empty($dateTo)) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // ---- Counts scoped tenant-wise ----
        $baseCountQuery = User::query();
        if (!is_superadmin()) {
            $baseCountQuery->where('institute_id', Auth::user()->institute_id);
        }

        $totalAll = (clone $baseCountQuery)->count();
        $filteredCount = (clone $query)->count();

        $activeCount = (clone $query)
            ->where('status', 1)
            ->count();

        $inactiveCount = (clone $query)
            ->where('status', 0)
            ->count();

        // ---- Pagination ----
        $users = $query->paginate($perPage)->appends($request->query());

        // Fetch assignable roles
        $roleQuery = Role::query();
        if (!is_superadmin()) {
            $roleQuery->whereNotIn('id', [1, 2, 3, 4, 14, 15]);
        }
        $roles = $roleQuery->orderBy('name', 'asc')->get();

        $data = [
            'users'          => $users,
            'roles'          => $roles,
            'page'           => 'user',
            'genderOptions'  => people_constant_option('gender'),

            // filters (for sticky form values)
            'filters'        => [
                'q'         => $search,
                'gender'    => $gender,
                'status'    => $status,
                'date_from' => $dateFrom,
                'date_to'   => $dateTo,
                'per_page'  => $perPage,
            ],

            // counts
            'totalAll'       => $totalAll,
            'filteredCount'  => $filteredCount,
            'activeCount'    => $activeCount,
            'inactiveCount'  => $inactiveCount,
        ];

        return view('backend.pages.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $institute = Auth::user()->institute;
        $areas = collect();
        if ($institute && $institute->union_id) {
            $areas = VillageArea::where('union_id', $institute->union_id)->orderBy('en_name', 'asc')->get();
        } else {
            $areas = VillageArea::orderBy('en_name', 'asc')->get();
        }

        // Fetch assignable roles
        $roleQuery = Role::query();
        if (!is_superadmin()) {
            $roleQuery->whereNotIn('id', [1, 2, 3, 4, 14, 15]);
        }
        $roles = $roleQuery->orderBy('name', 'asc')->get();

        $data = [
            'areas' => $areas,
            'roles' => $roles,
        ];

        return view('backend.pages.user.create', $data);
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
            'name'          => 'required|max:190',
            'email'         => 'required|max:190|email|unique:users,email',
            'mobile'        => 'required|max:190|unique:users,mobile',
            'assigned_area' => 'required|exists:village_areas,id',
            'password'      => 'required|min:6|confirmed',
            'role_id'       => 'required|exists:roles,id',
            'status'        => 'required|in:0,1',
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
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->password = Hash::make($request->password);
            $user->role_id = $request->role_id;
            $user->institute_id = Auth::user()->institute_id;
            $user->status = $request->status;
            $user->is_verified = ($request->status == 1) ? 1 : 0;
            $user->created_by = Auth::id();

            if ($user->save()) {
                // Assign role using Spatie Laravel-Permission
                $role = Role::find($request->role_id);
                $user->assignRole($role->name);

                // Save Area basis in AddressInfo
                $area = VillageArea::find($request->assigned_area);
                if ($area) {
                    $address = new AddressInfo();
                    $address->user_id = $user->id;
                    
                    // Present Address
                    $address->present_division_id = $area->division_id;
                    $address->present_district_id = $area->district_id;
                    $address->present_thana_id = $area->thana_id;
                    $address->present_union_id = $area->union_id;
                    $address->present_village_id = $area->village_id;
                    $address->present_village_area_id = $area->id;
                    $address->present_area = $area->en_name;
                    $address->present_area_bn = $area->bn_name;

                    // Permanent Address (match present area as default)
                    $address->permanent_division_id = $area->division_id;
                    $address->permanent_district_id = $area->district_id;
                    $address->permanent_thana_id = $area->thana_id;
                    $address->permanent_union_id = $area->union_id;
                    $address->permanent_village_id = $area->village_id;
                    $address->permanent_village_area_id = $area->id;
                    $address->permanent_area = $area->en_name;
                    $address->permanent_area_bn = $area->bn_name;

                    $address->save();
                }

                $data['status'] = true;
                $data['message'] = "Authorized Operator registered successfully.";
                $data['user'] = $user;
                $data['code'] = 200;
                $data['redirect_url'] = route('user.index');
            } else {
                $data['status'] = false;
                $data['message'] = "Operator registration failed! Please try again...";
                $data['code'] = 500;
            }

            DB::commit();
            return response(json_encode($data, JSON_PRETTY_PRINT), 200)->header('Content-Type', 'application/json');
        } catch (\Throwable $th) {
            DB::rollBack();
            $data['status'] = false;
            $data['errors'] = $th->getMessage();
            $data['message'] = "Something went wrong! Please try again or contact support...";
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
        $data['districts'] = District::orderBy('name','asc')->get();
        $data['countries'] = Country::orderBy('name','asc')->get();
        $data['religions'] = Religion::orderBy('name','asc')->get();
        $data['user'] = User::find($id);
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
        $validate = Validator::make($request->all(), [
            'name'             => 'required|max:190',
            'bn_name'          => 'required|max:190',
            'date_of_birth'    => 'nullable|max:190',
            'birth_place'      => 'nullable|max:190',
            'gender'           => 'nullable|max:190',
            'religion'         => 'nullable|max:190',
            'blood_group'      => 'nullable|max:190',
            'mobile'           => 'nullable|max:190',
            'email'            => 'nullable|max:190|email',
            'birth_certificate'=> 'nullable|max:190|unique:users,birth_certificate,' . $userID . ',id',
            'nid'              => 'nullable|max:190|unique:users,nid,' . $userID . ',id',
            'image'            => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
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

    /**
     * Assign role to user from User Directory table.
     */
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);

        DB::table('model_has_roles')->where('model_id', $user->id)->delete();
        $user->assignRole($role->name);

        $user->update([
            'role_id' => $request->role_id
        ]);

        session()->flash("success", "Role '" . $role->name . "' assigned successfully to " . ($user->name ?? 'User'));
        return redirect()->back();
    }
}
