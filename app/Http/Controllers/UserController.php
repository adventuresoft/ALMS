<?php

namespace App\Http\Controllers;

use App\Models\BasicSettings\Country;
use App\Models\District;
use App\Models\Farmer;
use App\Models\Religion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $data['farmers'] = Farmer::with('user.addressInfo.presentThana', 'user.addressInfo.presentUnion' )
    //     ->join('users', 'users.id', 'farmers.user_id')
    //     ->where('users.is_verified', false)
    //     ->orderBy('users.id', 'desc')
    //     ->paginate(100);
    //     $data['page']='user';
    //     return view('backend.pages.user.index', $data);
    // }
    
    
     public function index(Request $request)
    {
        // ---- Filters (GET) ----
        $search   = trim((string) $request->get('q', ''));
        $gender   = $request->get('gender'); // farmer.gender
        $status   = $request->get('status'); // users.status (1/0)
        $dateFrom = $request->get('date_from'); // users.created_at
        $dateTo   = $request->get('date_to');   // users.created_at
        $perPage  = (int) $request->get('per_page', 100);
        if ($perPage <= 0) $perPage = 100;
        if ($perPage > 500) $perPage = 500;

        // ---- Base query (same conditions as your current index) ----
        $query = Farmer::query()
            ->select('farmers.*')
            ->with('user.addressInfo.presentThana', 'user.addressInfo.presentUnion')
            ->join('users', 'users.id', '=', 'farmers.user_id')
            ->where('users.is_verified', false)
            ->orderBy('users.id', 'desc');

        // ---- Apply filtering ----
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                    ->orWhere('users.system_id', 'like', "%{$search}%")
                    ->orWhere('users.mobile', 'like', "%{$search}%")
                    ->orWhere('users.email', 'like', "%{$search}%");
            });
        }

        if ($gender !== null && $gender !== '') {
            $query->where('farmers.gender', $gender);
        }

        if ($status !== null && $status !== '') {
            $query->where('users.status', (int) $status);
        }

        if (!empty($dateFrom)) {
            $query->whereDate('users.created_at', '>=', $dateFrom);
        }

        if (!empty($dateTo)) {
            $query->whereDate('users.created_at', '<=', $dateTo);
        }

        // ---- Counts ----
        // Total (without filters, only base condition)
        $totalAll = Farmer::query()
            ->join('users', 'users.id', '=', 'farmers.user_id')
            ->where('users.is_verified', false)
            ->count();

        // Filtered counts (based on current query)
        $filteredCount = (clone $query)->count();

        $activeCount = (clone $query)
            ->where('users.status', 1)
            ->count();

        $inactiveCount = (clone $query)
            ->where('users.status', 0)
            ->count();

        // ---- Pagination ----
        $farmers = $query->paginate($perPage)->appends($request->query());

        $data = [
            'farmers'        => $farmers,
            'page'           => 'user',

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
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:190',
            'bn_name' => 'required|max:190',
            'date_of_birth' => 'nullable|max:190',
            'birth_place' => 'nullable|max:190',
            'gender' => 'nullable|max:190',
            'religion' => 'nullable|max:190',
            'blood_group' => 'nullable|max:190',
            'mobile' => 'nullable|max:190',
            'email'            => 'nullable|max:190|email',
            'birth_certificate' => 'nullable|max:190|unique:users,birth_certificate',
            'nid' => 'nullable|max:190|unique:users,nid',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
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
}
