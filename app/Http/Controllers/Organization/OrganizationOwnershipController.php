<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationOwnership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationOwnershipController extends Controller
{
    public function __construct()
    {
        $this->middleware('unionAdmin')->except('index', 'show');
    }

    public function ownershipForm()
    {
        $data['ownership'] = null;
        return view('backend.pages.organization.forms.ownership', $data);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validate = Validator::make($request->all(), [
            'organization_id' => 'nullable|max:190',
            'system_id' => 'nullable|max:190',
            'quantity' => 'required|max:190'
        ]);

        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Sorry! Invalid Entry.";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
        }

        $ids = $request->id;
        $system_ids = $request->system_id;
        $quantities = $request->quantity;
        $user_names = $request->user_name;
        $is_trade_licenses = $request->is_trade_license;
        $user_ids = $request->user_id;

        if(!empty($system_ids)){

            try {
                foreach ($system_ids as $key => $system_id) {
                    if($ids[$key]){
                        $ownership = OrganizationOwnership::find($ids[$key]);
                    }else {
                        $ownership = new OrganizationOwnership();
                    }
    
                    $ownership->organization_id  = $request->organization_id;
                    $ownership->system_id  = $system_id;
                    $ownership->user_id = $user_ids[$key];
                    $ownership->quantity  = $quantities[$key];
                    $ownership->user_name  = $user_names[$key];
                    $ownership->is_trade_license = $is_trade_licenses[$key] ??  false;
                    $ownership->save();
                }
    
                $data['status'] = true;
                $data['message'] = "Ownership saved successfully!";
                return response()->json($data, 200);
            } catch (\Throwable $th) {
                $data['status'] = true;
                $data['message'] = "Ownership save failed!";
                $data['errors'] = $th;
                return response()->json($data, 500);
            }

            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organization\OrganizationOwnership  $organizationOwnership
     * @return \Illuminate\Http\Response
     */
    public function show(OrganizationOwnership $organizationOwnership)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Organization\OrganizationOwnership  $organizationOwnership
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $organization= Organization::with('ownership')->find($id);
        if($organization) {
            $data['organization'] = $organization;
            return view('backend.pages.organization.tabs.ownership', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organization\OrganizationOwnership  $organizationOwnership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrganizationOwnership $organizationOwnership)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organization\OrganizationOwnership  $organizationOwnership
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ownership = OrganizationOwnership::find($id);
        if($ownership){
            try {
                $ownership->delete();
                $data['status'] = true;
                $data['message'] = "Ownership deleted successfully";
                return response()->json($data, 200);
            } catch (\Throwable $th) {
                $data['status'] = false;
                $data['message'] = "Nothing found to delete!";
                $data['errors'] = $th;
                return response()->json($data, 500);
            }
        } else {
            $data['status'] = false;
            $data['message'] = "Nothing found to delete!";
            return response()->json($data, 404);
        }
    }
}
