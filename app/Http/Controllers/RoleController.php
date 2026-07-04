<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // $this->middleware('auth:admin');
    }

    public function index()
    {
        $roles = Role::paginate(10);

        return view('backend.pages.role.index', compact('roles'))
            ->with(['title' => 'Role', 'page' => 'role']);
    }


    public function permissions($id)
    {
        $role = Role::findOrFail($id);
        $modules = Module::orderBy('name')->get();

        return view('backend.pages.role.permissions', compact('role', 'modules'));
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


    public function updatePermissions(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // Get all selected permissions from form
        $permissions = $request->permissions ?? [];

        // Sync permissions
        $role->syncPermissions($permissions);
        session()->flash("success", "Information saved Successfully");
        return redirect(route('role.index'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        Role::create(['name' => $request->name]);
        session()->flash("success", "Information saved Successfully");
        return redirect(route('role.index'));
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
    // public function edit($id)
    // {
    //     $role = Role::find($id);
    //     $roles = Role::paginate(10);
    //     return view('backend.pages.role.index', compact('role', 'roles'))->with('title', 'Edit Role Type')->with('page', 'role');
    // }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $roles = Role::paginate(10);

        // Load modules + permissions for matrix
        $modules = Module::orderBy('name')->get();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('backend.pages.role.index', compact('role', 'roles', 'modules', 'rolePermissions'))
            ->with('title', 'Edit Role')
            ->with('page', 'role');
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
        $this->validate($request, [
            'name' => 'required',
        ]);
        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        session()->flash("success", "Information saved Successfully");
        return redirect(route('role.index'));
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