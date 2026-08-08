<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\User;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApprovalFarmerController extends Controller
{
    public function __construct() {
        $this->middleware('permission:farmer-approve-list-read', ['only' => ['index', 'show']]);
        $this->middleware('permission:farmer-approve-list-create|farmer-approve-list-update', ['only' => ['create', 'store']]);
        $this->middleware('permission:farmer-approve-list-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:farmer-approve-list-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data['farmers'] = Farmer::with('user.addressInfo.presentThana', 'user.addressInfo.presentUnion' )
        // ->join('users', 'users.id', 'farmers.user_id')
        // ->where('users.is_verified', true)
        // ->paginate(100);
        
         $query = Farmer::with([
            'user.addressInfo.presentDivision',
            'user.addressInfo.presentDistrict',
            'user.addressInfo.presentThana',
            'user.addressInfo.presentUnion'
        ])
        ->join('users', 'users.id', 'farmers.user_id')
        ->where('users.is_verified', true);
    
        // 🔍 Search (name, phone, NID, etc.)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                  ->orWhere('users.system_id', 'like', "%{$search}%")
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
        
        
        return view('backend.pages.farmer.approved_list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::find($request->user_id);
            $user->is_verified = $request->is_verified ? 1 : 0;
            $user->save();

            $data['status'] = true;
            $data['message'] = "Approved Successfully!";
            $data['redirect_url'] = route('approved-farmer.index');
            $data['user'] = $user;

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['user'] = User::find($id);
        return view('backend.pages.farmer.tabs.approval', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
