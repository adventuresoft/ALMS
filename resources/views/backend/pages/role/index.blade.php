@extends('backend.master', ['mainMenu' => 'AccessManagment', 'subMenu' => 'role'])
@section('content')
    <div class="" style="min-height: 1203.6px;">

        <!-- Content Header -->
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
            </div>
        </section>

        <!-- Page Body -->

        <section class="content">
            <div class="container-fluid">
                @include('includes.messages')

                <div class="row">

                    {{-- LEFT SIDE FORM --}}
                    <div class="col-md-5">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{ isset($role) ? 'Edit Role' : 'Add Role' }}</h3>
                            </div>

                            {{-- CREATE --}}
                            @if (!isset($role))
                                <form role="form" method="POST" action="{{ route('role.store') }}">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Role</label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                required>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                        <button type="reset" class="btn btn-warning ml-2">
                                            <i class="fa fa-undo-alt"></i> Reset
                                        </button>
                                    </div>
                                </form>

                                {{-- EDIT --}}
                            @else
                                <form role="form" method="POST" action="{{ route('role.update', $role->id) }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="name">Role</label>
                                            <input type="text" name="name" value="{{ $role->name }}"
                                                class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="card-footer text-center">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Update
                                        </button>

                                        <a href="{{ route('role.index') }}" class="btn btn-dark ml-2">
                                            <i class="fa fa-arrow-left"></i> Back
                                        </a>

                                        {{-- Button for Permission Matrix --}}
                                        <a href="{{ route('role.permissions', $role->id) }}" class="btn btn-info ml-2">
                                            <i class="fa fa-lock"></i> Permission Matrix
                                        </a>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- RIGHT SIDE LIST --}}
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h3 class="card-title">Role List</h3>
                            </div>

                            <div class="card-body">
                                @if ($roles->count() == 0)
                                    <div class="text-center btn-warning font-weight-bold pt-3 pb-3 h2">No Data Found</div>
                                @else
                                    <table class="table table-bordered table-striped">
                                        <thead class="text-center thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($roles as $key => $value)
                                                <tr class="text-center">
                                                    <td>{{ $roles->firstItem() + $key }}</td>
                                                    <td>{{ $value->name }}</td>
                                                    <td>
                                                        <a href="{{ route('role.edit', $value->id) }}"
                                                            class="badge badge-primary">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>

                                                        <a href="{{ route('role.permissions', $value->id) }}"
                                                            class="badge badge-info">
                                                            <i class="fa fa-lock"></i> Permissions
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-center">
                                        {{ $roles->links() }}
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </section>

    </div>
@endsection
