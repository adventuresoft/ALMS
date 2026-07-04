@extends('backend.master', ['mainMenu' => 'User', 'subMenu' => 'User'])

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
                                <a href="{{ route('user.create') }}" class="btn btn-dark">
                                    <i class="fas fa-plus"></i> Add New User
                                </a>
                                <a href="{{ route('farmer-show-all') }}" class="btn btn-sm btn-primary">
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
                                @if ($farmers && count($farmers))
                                    @foreach ($farmers as $key => $farmer)
                                        <tr>
                                            <td>{{ $farmers->firstItem() + $key }}</td>
                                            <td>
                                                {{ $farmer->user->system_id ?? '' }}
                                                <br>{{ $farmer->user->name ?? '' }}
                                            </td>
                                            <td>
                                                @php
                                                    $mobile = $farmer->user->mobile ? ('<a href="tel:'.$farmer->user->mobile.'">'.$farmer->user->mobile.'</a>') : '';
                                                    $email  = $farmer->user->email ? ('<br><a href="mailto:'.$farmer->user->email.'">'.$farmer->user->email.'</a>') : '';
                                                @endphp
                                                {!! $mobile !!}
                                                {!! $email !!}
                                            </td>
                                            <td>
                                                <span class="badge badge-info"> <i class="fas fa-user"></i> {{ $farmer->user->role->name ?? '' }}</span>
                                                <br>
                                                <span class="badge badge-secondary"> <i class="fas fa-venus-mars"></i> {{ $genderOptions[$farmer->gender] ?? '' }}</span>
                                            </td>
                                            <td>
                                                @php $img = $farmer->user->image ?? null; @endphp
                                                <img height="50" src="{{ $img ? asset($img) : asset('backend/dist/img/avatar.png') }}" alt="avatar">
                                            </td>
                                            <td>
                                                @if(($farmer->user->status ?? 0) == 1)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-pill-group d-inline-flex">
                                                    <a href="{{ route('user.credentials.edit', $farmer->user->id) }}"
                                                       class="btn btn-sm btn-secondary"
                                                       title="Reset Email & Password"
                                                       data-toggle="tooltip">
                                                        <i class="fa fa-key"></i>
                                                    </a>

                                                    <a href="{{ route('farmers.changeStatus', $farmer->user->id) }}"
                                                       class="btn btn-sm btn-success"
                                                       title="Change Status"
                                                       data-toggle="tooltip">
                                                        <i class="fa fa-circle"></i>
                                                    </a>
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

                        {{-- PAGINATION --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted">
                                @if($farmers && $farmers->total() > 0)
                                    Showing {{ $farmers->firstItem() }} to {{ $farmers->lastItem() }} of {{ $farmers->total() }} entries
                                @endif
                            </div>
                            <div>
                                {{ $farmers->links() }}
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <!-- /.row -->
    </div>
</section>
@endsection

@push('script')
<script>
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
