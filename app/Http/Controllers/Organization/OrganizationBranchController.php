<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\BasicSettings\OrganizationCategory;
use App\Models\OrganizationOwnershipType;
use App\Models\OrganizationWorkArea;
use App\Models\Division;
use App\Models\District;
use App\Models\Thana;
use App\Models\Village;
use App\Models\Institute;
use App\Models\Organization\Organization;
use App\Models\Organization\OrganizationBranch;
use App\Models\Organization\OrganizationType;
use App\Models\Road;
use App\Models\UnionWard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrganizationBranchController extends Controller
{

   
    
    public function index()
    {
        $data['organizations'] = OrganizationBranch::with('organization','division','district')->latest()->get();
        return view('backend.pages.organization.branch.index', $data);
    }

    
    public function create()
    {
        $data['divisions'] = Division::where('status', true)->latest()->get();
        $data['districts'] = District::where('status', true)->latest()->get();
        $data['thanas'] = Thana::where('status', true)->latest()->get();
        $data['wards'] = UnionWard::where('status', true)->get();
        $data['roads'] = Road::where('institute_id', Auth::user()->institute_id)->get();
        $data['user'] = Auth::user();
        $data['organizations'] = Organization::where('status', true)->latest()->get();
        
        return view('backend.pages.organization.branch.create', $data);
    }

    public function store(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'name' => 'required|max:190',
            'bn_name' => 'nullable|max:190',
            'organization_id' => 'nullable|max:190',
            'status' => 'nullable|boolean'
        ]);

        if ($validate->fails()) {
            $data['status'] = false;
            $data['message'] = "Sorry! Invalid Entry.";
            $data['errors'] = $validate->errors();
            return response(json_encode($data, JSON_PRETTY_PRINT), 400)->header('Content-Type', 'application/json');
        }

        try {

            if ($request->id) {
                $organization = OrganizationBranch::where('id', $request->id)->update([
                    'name' => $request->name,
                    'bn_name' => $request->bn_name,
                    'organization_id' => $request->organization_id,                    
                    'division_id' => $request->division_id,
                    'district_id' => $request->district_id,
                    'thana_id' => $request->thana_id,
                    'union_id' => $request->union_id,
                    'address' => $request->address,
                    'priority' => $request->priority,
                    'status' => $request->status,                    
                    'remarks' => $request->remarks,
                ]);
            } else {
                $organization = OrganizationBranch::create([
                    'institute_id' => Auth::user()->institute_id,
                    'name' => $request->name,
                    'bn_name' => $request->bn_name,
                    'organization_id' => $request->organization_id,
                    'division_id' => $request->division_id,
                    'district_id' => $request->district_id,
                    'thana_id' => $request->thana_id,
                    'union_id' => $request->union_id,
                    'address' => $request->address,
                    'priority' => $request->priority,
                    'status' => $request->status,                    
                    'remarks' => $request->remarks,
                ]);
            }

           
            $data['status'] = true;
            $data['message'] = "Organization saved successfully!";
            $data['result'] = $organization;
            $data['code'] = 200;
            $data['redirect_url'] = route('organization-ownership.edit', $request->id ?? $organization->id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data['status'] = false;
            $data['message'] = "Something went wrong! Please try again...";
            $data['errors'] = $th;
            return response(json_encode($data, JSON_PRETTY_PRINT), 500)->header('Content-Type', 'application/json');
        }
    }

    public function show($id)
    {
        return view('backend.pages.organization.show');
    }

    public function edit($id)
    {
        $data['organization'] = OrganizationBranch::find($id);
        if($data['organization'] ){
            $data['areas'] = OrganizationWorkArea::where('organization_subcategory_id', $data['organization']->organization_subcategory_id)->where('status', true)->latest()->get();
            $data['types'] = OrganizationType::where('organization_category_id', $data['organization']->organization_category_id)->where('status', true)->latest()->get();
            $data['categories'] = OrganizationCategory::where('status', true)->latest()->get();
            $data['ownership_types'] = OrganizationOwnershipType::where('status', true)->latest()->get();
            $data['wards'] = UnionWard::where('status', true)->get();
            $data['roads'] = Road::where('institute_id', Auth::user()->institute_id)->get();
            // return response()->json($data, 200);

            $institute = Institute::find(Auth::user()->institute_id);
            if($institute)
            {
                $data['villages'] = Village::where('union_id', $institute->union_id )->get();
            }else {
                $data['villages'] = [];
            }

            return view('backend.pages.organization.edit', $data);
        } else {
            return "Not found";
        }
       
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $house = Organization::find($id);
        if($house){

            try {
                $house->delete();
                $data['status'] = true;
                $data['message'] = "Organization Deleted Successfully";
                return response()->json($data, 200);
            } catch (\Throwable $th) {
                $data['status'] = false;
                $data['message'] = "Failed to delete";
                $data['errors'] = $th;
                return response()->json($data, 500);
            }

        } else {
            $data['status'] = false;
            $data['message'] = "Noting found to delete";
            return response()->json($data, 404);
        }
    }

        public function getBranches($organization_id)
        {
            $branches = OrganizationBranch::where('organization_id', $organization_id)
                ->where('status', 1)
                ->select('id', 'bn_name')
                ->orderBy('bn_name', 'asc')
                ->get();

            return response()->json($branches);
        }
}
