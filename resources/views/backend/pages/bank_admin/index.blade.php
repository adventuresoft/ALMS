@extends('backend.master', ['mainMenu' => 'AccessManagment', 'subMenu' => 'bank_admin'])

@section('title', isset($singleBankAdmin) ? 'Edit Bank Admin' : 'Bank Admin Management')

@section('content')

<div class="" style="min-height: 1203.6px;">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Access Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Access Management</a></li>
                        <li class="breadcrumb-item active">Bank Admins</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            {{-- Include RBAC Header Navigation Tabs --}}
            @include('backend.pages.rbac._header')

            @include('includes.messages')

            <div class="row">
                <!-- Left Form -->
                <div class="col-md-5">
                    <div class="card card-primary">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">{{ isset($singleBankAdmin) ? 'Edit Bank Admin' : 'Create Bank Admin' }}</h3>
                        </div>

                        @if (isset($singleBankAdmin))
                            <!-- Edit Form -->
                            <form role="form" method="POST" action="{{ route('bank-admin.update', $singleBankAdmin->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Admin Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $singleBankAdmin->name) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $singleBankAdmin->email) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile">Mobile Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile', $singleBankAdmin->mobile) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="bank_id">Assigned Bank <span class="text-danger">*</span></label>
                                        <select class="form-control" id="edit_bank_id" name="bank_id" required>
                                            <option value="">-- Select Bank --</option>
                                            @foreach ($banks as $bank)
                                                <option value="{{ $bank->id }}" {{ old('bank_id', $singleBankAdmin->bankUser?->bank_id) == $bank->id ? 'selected' : '' }}>
                                                    {{ $bank->en_name }} ({{ $bank->bn_name }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="branch_id">Assigned Branch (Optional)</label>
                                        <select class="form-control" id="edit_branch_id" name="branch_id">
                                            <option value="">-- Select Branch --</option>
                                            @if(isset($branches))
                                                @foreach($branches as $branch)
                                                    <option value="{{ $branch->id }}" {{ old('branch_id', $singleBankAdmin->bankUser?->branch_id) == $branch->id ? 'selected' : '' }}>
                                                        {{ $branch->bn_name ?? $branch->en_name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">New Password (leave blank to keep current)</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="******">
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="******">
                                    </div>
                                </div>

                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update Admin</button>
                                    <a href="{{ route('bank-admin.index') }}" class="btn btn-dark ml-2"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </form>
                        @else
                            <!-- Create Form -->
                            <form role="form" method="POST" action="{{ route('bank-admin.store') }}">
                                @csrf

                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Admin Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="admin@bank.com" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="mobile">Mobile Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}" placeholder="01700000000" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="bank_id">Assign Bank <span class="text-danger">*</span></label>
                                        <select class="form-control" id="create_bank_id" name="bank_id" required>
                                            <option value="">-- Select Bank --</option>
                                            @foreach ($banks as $bank)
                                                <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                                    {{ $bank->en_name }} ({{ $bank->bn_name }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="branch_id">Assign Branch (Optional)</label>
                                        <select class="form-control" id="create_branch_id" name="branch_id">
                                            <option value="">-- Select Branch --</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="******" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="******" required>
                                    </div>
                                </div>

                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Create Bank Admin</button>
                                    <button type="reset" class="btn btn-warning ml-2"><i class="fa fa-undo-alt"></i> Reset</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Right Table -->
                <div class="col-md-7">
                    <div class="card card-info">
                        <div class="card-header bg-info">
                            <h3 class="card-title">Bank Admin List</h3>
                        </div>

                        <div class="card-body">
                            @if ($bankAdmins->count() == 0)
                                <div class="text-center btn-warning font-weight-bold pt-3 pb-3 h5">No Bank Admins Found</div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-dark text-center">
                                            <tr>
                                                <th>#</th>
                                                <th>System ID</th>
                                                <th>Name / Email</th>
                                                <th>Mobile</th>
                                                <th>Assigned Bank</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bankAdmins as $i => $admin)
                                                <tr class="text-center">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><span class="badge badge-secondary">{{ $admin->system_id }}</span></td>
                                                    <td class="text-left">
                                                        <strong>{{ $admin->name }}</strong><br>
                                                        <small class="text-muted">{{ $admin->email }}</small>
                                                    </td>
                                                    <td>{{ $admin->mobile }}</td>
                                                    <td>
                                                        <span class="badge badge-info">
                                                            {{ $admin->bankUser?->bank?->en_name ?? 'N/A' }}
                                                        </span>
                                                        @if($admin->bankUser?->branch)
                                                            <br><small class="text-muted">({{ $admin->bankUser->branch->bn_name ?? $admin->bankUser->branch->en_name }})</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('bank-admin.edit', $admin->id) }}" class="badge badge-primary p-2">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>

                                                        <a href="#" class="badge badge-danger p-2 ml-1"
                                                            onclick="if(confirm('Are you sure you want to delete this Bank Admin?')){
                                                                event.preventDefault();
                                                                document.getElementById('delete-admin-{{ $admin->id }}').submit();
                                                            }">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>

                                                        <form id="delete-admin-{{ $admin->id }}" action="{{ route('bank-admin.destroy', $admin->id) }}" method="POST" style="display:none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $bankAdmins->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function loadBranches(bankId, targetSelect) {
            if (!bankId) {
                targetSelect.html('<option value="">-- Select Branch --</option>');
                return;
            }
            $.ajax({
                url: "{{ route('loan.getBranches', '') }}/" + bankId,
                type: "GET",
                success: function(data) {
                    targetSelect.html('<option value="">-- Select Branch --</option>');
                    $.each(data, function(key, branch) {
                        targetSelect.append('<option value="' + branch.id + '">' + branch.bn_name + '</option>');
                    });
                }
            });
        }

        $('#create_bank_id').on('change', function() {
            loadBranches($(this).val(), $('#create_branch_id'));
        });

        $('#edit_bank_id').on('change', function() {
            loadBranches($(this).val(), $('#edit_branch_id'));
        });
    });
</script>

@endsection
