<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;


class ModuleController extends Controller
{
    public function __construct() {
        $this->middleware('permission:module-read', ['only' => ['index', 'show']]);
        $this->middleware('permission:module-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:module-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:module-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $modules = Module::orderBy('id', 'desc')->paginate(20);
        return view('backend.pages.module.index', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:modules,name'
        ]);

        $module = Module::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        // Auto generate permissions
        $actions = ['read', 'create', 'update', 'delete'];

        foreach ($actions as $action) {
            Permission::create([
                'name' => $module->slug . '-' . $action,
                'guard_name' => 'web'
            ]);
        }

        return back()->with('success', 'Module & Permissions Created Successfully');
    }


    public function edit($id)
    {
        $module = Module::findOrFail($id);
        $modules = Module::orderBy('id', 'desc')->paginate(20);

        return view('backend.pages.module.index', compact('module', 'modules'));
    }

    public function update(Request $request, $id)
    {
        $module = Module::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:modules,name,' . $module->id,
        ]);

        $oldSlug = $module->slug;
        $newSlug = Str::slug($request->name);

        // Update module
        $module->update([
            'name' => $request->name,
            'slug' => $newSlug
        ]);

        // Update permissions (rename)
        $actions = ['read', 'create', 'update', 'delete'];

        foreach ($actions as $action) {
            $oldPerm = $oldSlug . '-' . $action;
            $newPerm = $newSlug . '-' . $action;

            $permission = Permission::where('name', $oldPerm)->first();
            if ($permission) {
                $permission->update(['name' => $newPerm]);
            }
        }

        return redirect()->route('module.index')->with('success', 'Module & Permissions Updated');
    }
    public function destroy($id)
    {
        $module = Module::findOrFail($id);

        $actions = ['read', 'create', 'update', 'delete'];

        foreach ($actions as $action) {
            Permission::where('name', $module->slug . '-' . $action)->delete();
        }

        $module->delete();

        return back()->with('success', 'Module & Permissions Deleted');
    }
}