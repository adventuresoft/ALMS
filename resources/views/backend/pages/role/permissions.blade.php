@extends('backend.master', ['mainMenu' => 'AccessManagement', 'subMenu' => 'role'])

@section('content')
    <div class="" style="min-height: 1203.6px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Role</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Role</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="card">
                    <div class="card-header bg-info">
                        <h3 class="card-title">Permission Matrix for Role: <b>{{ $role->name }}</b></h3>
                    </div>

                    <form action="{{ route('role.permissions.update', $role->id) }}" method="POST">
                        @csrf

                        <div class="card-body">

                            <table class="table table-bordered table-striped">
                                <thead class="text-center bg-dark text-white">
                                    <tr>
                                        <th>Module</th>
                                        <th>Read</th>
                                        <th>Create</th>
                                        <th>Update</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($modules as $module)
                                        <tr class="text-center">
                                            <td class="text-left font-weight-bold">{{ $module->name }}</td>

                                            @php
                                                $actions = ['read', 'create', 'update', 'delete'];
                                            @endphp

                                            @foreach ($actions as $action)
                                                @php
                                                    $permName = $module->slug . '-' . $action;
                                                @endphp

                                                <td>
                                                    <input type="checkbox" name="permissions[]" value="{{ $permName }}"
                                                        {{ $role->hasPermissionTo($permName) ? 'checked' : '' }}>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>

                        <div class="card-footer text-center">
                            <button class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                            <a href="{{ route('role.index') }}" class="btn btn-dark ml-2"><i class="fa fa-arrow-left"></i>
                                Back</a>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection
