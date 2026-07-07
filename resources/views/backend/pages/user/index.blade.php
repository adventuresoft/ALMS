@extends('backend.master', ['mainMenu' => 'AccessManagment', 'subMenu' => 'user'])

@push('style')
<style>
    #farmer_table_wrapper .dataTables_filter { float: right; }
    #farmer_table_wrapper .dataTables_paginate { float: right; }

    .filter-card {
        background: #f8fafc;
        border: 1px solid rgba(0,0,0,.06);
        border-radius: 10px;
        padding: 14px;
        margin-bottom: 15px;
    }
    .stat-chip {
        background: #fff;
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 12px;
        padding: 10px 12px;
        height: 100%;
    }
    .stat-chip .label { font-size: 12px; color: #6c757d; margin-bottom: 2px; }
    .stat-chip .value { font-size: 18px; font-weight: 700; margin: 0; }
    .btn-pill-group .btn { border-radius: 999px !important; }
    .btn-pill-group .btn + .btn { margin-left: 6px; }
    .table td, .table th { vertical-align: middle; }
</style>
@endpush

@section('title', 'User View')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>User Information</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
                    <li class="breadcrumb-item active">View</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        @include('backend.pages.rbac._header')

        {{-- Messages --}}
        @if(count($errors) > 0)
            @foreach($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
        @endif
        @if(session()->has('success'))
            <p class="alert alert-success">{{ session('success') }}</p>
        @endif
        @if(session()->has('error'))
            <p class="alert alert-danger">{{ session('error') }}</p>
        @endif
        @if(session()->has('warning'))
            <p class="alert alert-warning">{{ session('warning') }}</p>
        @endif

        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">

                <div class="card card-info">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h3 class="card-title mb-0">User List</h3>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('farmer.create') }}" class="btn btn-dark">
                                    <i class="fas fa-plus"></i> Add New Farmer
                                </a>
                                <a href="{{ route('user.create') }}" class="btn btn-primary ml-2">
                                    <i class="fas fa-user-plus"></i> Register Authorized Operator
                                </a>
                                <a href="{{ route('farmer-show-all') }}" class="btn btn-sm btn-secondary ml-2">
                                    <i class="fa fa-print"></i> Print
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        {{-- COUNTS --}}
                        <div class="row mb-3">
                            <div class="col-md-3 col-6 mb-2">
                                <div class="stat-chip">
                                    <div class="label">Total (All)</div>
                                    <p class="value">{{ $totalAll ?? 0 }}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="stat-chip">
                                    <div class="label">Matched (Filtered)</div>
                                    <p class="value">{{ $filteredCount ?? 0 }}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="stat-chip">
                                    <div class="label">Active (Filtered)</div>
                                    <p class="value">{{ $activeCount ?? 0 }}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="stat-chip">
                                    <div class="label">Inactive (Filtered)</div>
                                    <p class="value">{{ $inactiveCount ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- FILTER BOX --}}
                        @php
                            $f = $filters ?? [];
                            $genderOptions = people_constant_option('gender'); // your helper
                        @endphp

                        <div class="filter-card">
                            <form method="GET" action="{{ route('user.index') }}">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        <label class="mb-1">Search</label>
                                        <input type="text" name="q" value="{{ $f['q'] ?? '' }}"
                                               class="form-control"
                                               placeholder="Name / ID / Mobile / Email">
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        <label class="mb-1">Gender</label>
                                        <select name="gender" class="form-control">
                                            <option value="">All</option>
                                            @foreach($genderOptions as $k => $v)
                                                <option value="{{ $k }}" {{ (string)($f['gender'] ?? '') === (string)$k ? 'selected' : '' }}>
                                                    {{ $v }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        <label class="mb-1">Status</label>
                                        <select name="status" class="form-control">
                                            <option value="">All</option>
                                            <option value="1" {{ (string)($f['status'] ?? '') === '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ (string)($f['status'] ?? '') === '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        <label class="mb-1">From Date</label>
                                        <input type="date" name="date_from" value="{{ $f['date_from'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        <label class="mb-1">To Date</label>
                                        <input type="date" name="date_to" value="{{ $f['date_to'] ?? '' }}" class="form-control">
                                    </div>

                                    <div class="col-md-1 mb-2">
                                        <label class="mb-1">Per Page</label>
                                        <select name="per_page" class="form-control">
                                            @foreach([50,100,200,300,500] as $pp)
                                                <option value="{{ $pp }}" {{ (int)($f['per_page'] ?? 100) === $pp ? 'selected' : '' }}>
                                                    {{ $pp }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-success px-4">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                    <a href="{{ route('user.index') }}" class="btn btn-secondary px-4 ml-2">
                                        <i class="fa fa-undo"></i> Reset
                                    </a>
                                </div>
                            </form>
                        </div>

                        {{-- TABLE --}}
                        <div class="table-responsive">
                            <table id="farmer_table" class="table table-bordered table-striped">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>SL</th>
                                    <th>User ID & Name</th>
                                    <th>Mobile & Email</th>
                                    <th>User Type</th>
                                    <th>Photo</th>
                                    <th>Status</th>
                                    <th style="width: 14%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($users && count($users))
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td>{{ $users->firstItem() + $key }}</td>
                                            <td>
                                                {{ $user->system_id ?? '' }}
                                                <br>{{ $user->name ?? '' }}
                                            </td>
                                            <td>
                                                @php
                                                    $mobile = $user->mobile ? ('<a href="tel:'.$user->mobile.'">'.$user->mobile.'</a>') : '';
                                                    $email  = $user->email ? ('<br><a href="mailto:'.$user->email.'">'.$user->email.'</a>') : '';
                                                @endphp
                                                {!! $mobile !!}
                                                {!! $email !!}
                                            </td>
                                            <td>
                                                <span class="badge badge-info"> <i class="fas fa-user"></i> {{ $user->role->name ?? '' }}</span>
                                                @if($user->farmer)
                                                    <br>
                                                    <span class="badge badge-secondary"> <i class="fas fa-venus-mars"></i> {{ $genderOptions[$user->farmer->gender] ?? '' }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php $img = $user->image ?? null; @endphp
                                                <img height="50" src="{{ $img ? asset($img) : asset('backend/dist/img/avatar.png') }}" alt="avatar">
                                            </td>
                                            <td>
                                                @if(($user->status ?? 0) == 1)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-pill-group d-inline-flex">
                                                    @can('credentials-update')
<a href="{{ route('user.credentials.edit', $user->id) }}"
                                                       class="btn btn-sm btn-secondary"
                                                       title="Reset Email & Password"
                                                       data-toggle="tooltip">
                                                        <i class="fa fa-key"></i>
                                                    </a>
@endcan

                                                    <a href="{{ route('farmers.changeStatus', $user->id) }}"
                                                       class="btn btn-sm btn-success"
                                                       title="Change Status"
                                                       data-toggle="tooltip">
                                                        <i class="fa fa-circle"></i>
                                                    </a>

                                                    <button type="button"
                                                            class="btn btn-sm btn-info"
                                                            title="Assign Role"
                                                            data-toggle="tooltip"
                                                            onclick="openAssignRoleModal({{ $user->id }}, '{{ addslashes($user->name ?? '') }}', {{ $user->role_id ?? 'null' }})">
                                                        <i class="fas fa-user-shield"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            No data found for your filter.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        </div>

                        {{-- PAGINATION --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                @if($users && $users->total() > 0)
                                    Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries
                                @endif
                            </div>
                            <div>
                                {{ $users->links() }}
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- /.row -->
    </div>

    <!-- Assign Role Modal -->
    <div class="modal fade" id="assignRoleModal" tabindex="-1" role="dialog" aria-labelledby="assignRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title font-weight-bold" id="assignRoleModalLabel"><i class="fas fa-user-shield text-info mr-2"></i>Assign Role to User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('user.assignRole') }}">
                    @csrf
                    <input type="hidden" name="user_id" id="modal_assign_user_id" value="">
                    <div class="modal-body p-4">
                        <div class="form-group">
                            <label class="font-weight-bold text-dark">User Name</label>
                            <input type="text" id="modal_assign_user_name" class="form-control bg-light" readonly>
                        </div>
                        <div class="form-group mt-3">
                            <label for="modal_assign_role_id" class="font-weight-bold text-dark">Select Role <span class="text-danger">*</span></label>
                            <select name="role_id" id="modal_assign_role_id" class="form-control" required>
                                <option value="">-- Select Role --</option>
                                @if(isset($roles) && count($roles))
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info"><i class="fas fa-save mr-1"></i>Save Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
    function openAssignRoleModal(userId, userName, roleId) {
        $('#modal_assign_user_id').val(userId);
        $('#modal_assign_user_name').val(userName);
        if (roleId && roleId !== null && roleId !== 'null') {
            $('#modal_assign_role_id').val(roleId);
        } else {
            $('#modal_assign_role_id').val('');
        }
        $('#assignRoleModal').modal('show');
    }

    $(document).ready(function() {
        // Keep DataTable for styling/responsive only (no built-in search/paging)
        $("#farmer_table").DataTable({
            "paging": false,
            "searching": false,
            "info": false
        });

        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush
