<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:admin');
    }

    private function guardSuperadmin() {
        if (!is_superadmin() && (!auth()->check() || (auth()->user()->role_id != 6 && !view_permission('roles')))) {
            abort(403, 'Unauthorized action.');
        }
    }

    private function getGroupedPermissions() {
        $permissions = Permission::all();

        $sidebarMapping = [
            'Dashboard' => ['dashboard', 'home', 'stats'],
            'Access Management' => ['role', 'permission', 'user', 'module', 'roleuser', 'rolepermission', 'userpermission', 'userper', 'access', 'access-management', 'access_management'],
            'Farmers & Borrowers' => [
                'farmer', 'farmer-info', 'farmer-create', 'farmer-general-list', 'farmer-approve-list'
            ],
            'Loan Information' => [
                'loan', 'loan-info', 'loan-all-loans'
            ],
            'Apply For Loan' => [
                'loan-apply', 'loan-all-loan-apply'
            ],
            'Subsidy Info' => [
                'subsidy', 'subsidy-info', 'subsidy-create', 'subsidy-view'
            ],
            'Bank Info' => [
                'bank', 'bank-info', 'bank-create', 'bank-list', 'bank-selling', 'bank-employee'
            ],
            'Land Info' => [
                'land', 'land-info', 'land-create', 'land-view'
            ],
            'Reports' => [
                'report', 'reports', 'reports-general', 'reports-loan', 'reports-payment', 'reports-due', 'reports-subsidy'
            ],
            'Basic Settings' => [
                'division', 'district', 'thana', 'upazila', 'pourashava', 'city_corporation', 'city-corporation',
                'union', 'union_ward', 'post_office', 'post-office', 'village', 'village_area', 'ward', 'mouza',
                'account_type', 'country', 'religion', 'profession', 'family', 'disability',
                'basic-settings', 'basic_settings'
            ],
            'Institute Settings' => ['institute', 'institute_category', 'institute_type', 'organization', 'organization_people', 'organization-people'],
            'People Info' => ['people', 'applicant_list', 'reg_people_list', 'search_people', 'freedom_fighter', 'parent_info'],
            'Certificates & Documents' => [
                'certificate', 'age_certificate', 'character_certificate', 'childless_certificate', 'citizen_certificate',
                'disability_certificate', 'financial_instability_certificate', 'guardian_certificate',
                'landless_certificate', 'married_certificate', 'name_certificate', 'nid_correction_certificate',
                'orphan_certificate', 'permanent_citizen_certificate', 'remarried_certificate',
                'residential_certificate', 'unmarried_certificate', 'voter_area_certificate',
                'voter_list_certificate', 'yearly_income_certificate', 'trade_license', 'invoice', 'receipt'
            ],
            'Other Modules' => []
        ];

        $grouped = [];
        foreach ($sidebarMapping as $category => $modules) {
            $grouped[$category] = [];
        }
        $grouped['Other Modules'] = [];

        foreach ($permissions as $permission) {
            if (str_contains($permission->name, '.')) {
                $parts = explode('.', $permission->name);
                $moduleName = $parts[0];
            } elseif (str_contains($permission->name, '-')) {
                $parts = explode('-', $permission->name);
                array_pop($parts);
                $moduleName = implode('-', $parts);
                if (empty($moduleName)) {
                    $moduleName = $permission->name;
                }
            } else {
                $moduleName = 'others';
            }

            $foundCategory = 'Other Modules';
            foreach ($sidebarMapping as $category => $modules) {
                if (in_array($moduleName, $modules)) {
                    $foundCategory = $category;
                    break;
                }
            }

            if (!isset($grouped[$foundCategory][$moduleName])) {
                $grouped[$foundCategory][$moduleName] = collect();
            }
            $grouped[$foundCategory][$moduleName]->push($permission);
        }

        foreach ($grouped as $key => $val) {
            if (empty($val)) {
                unset($grouped[$key]);
            }
        }

        return collect($grouped);
    }

    public function index()
    {
        $this->guardSuperadmin();
        $roles = Role::with('permissions')->paginate(10);
        $sidebarGroups = $this->getGroupedPermissions();

        return view('backend.pages.role.index', compact('roles', 'sidebarGroups'))
            ->with(['title' => 'Role Management', 'page' => 'role']);
    }

    public function permissions($id)
    {
        $role = Role::findOrFail($id);
        $modules = Module::orderBy('name')->get();

        return view('backend.pages.role.permissions', compact('role', 'modules'));
    }

    public function updatePermissions(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $permissions = $request->permissions ?? [];
        $role->syncPermissions($permissions);
        session()->flash("success", "Information saved Successfully");
        return redirect(route('role.index'));
    }

    public function store(Request $request)
    {
        $this->guardSuperadmin();
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
        ]);
        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        session()->flash("success", "Role Created with Permissions Successfully");
        return redirect(route('role.index'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $this->guardSuperadmin();
        $role = Role::with('permissions')->findOrFail($id);
        $roles = Role::with('permissions')->paginate(10);
        $sidebarGroups = $this->getGroupedPermissions();

        return view('backend.pages.role.index', compact('role', 'roles', 'sidebarGroups'))
            ->with('title', 'Edit Role')
            ->with('page', 'role');
    }

    public function update(Request $request, $id)
    {
        $this->guardSuperadmin();
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $id,
        ]);
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        session()->flash("success", "Role Updated with Permissions Successfully");
        return redirect(route('role.index'));
    }

    public function destroy($id)
    {
        $this->guardSuperadmin();
        $role = Role::find($id);
        if ($role) {
            $role->delete();
            session()->flash("success", "Role Deleted Successfully");
        }
        return redirect(route('role.index'));
    }
}