@extends('backend.master', ['mainMenu' => 'AccessManagment', 'subMenu' => 'user'])

@section('title', 'Register New Authorized Operator')

@push('style')
<style>
    .operator-card {
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        background: #ffffff;
    }
    .operator-card-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 1.25rem 1.5rem;
        border-top-left-radius: 12px !important;
        border-top-right-radius: 12px !important;
    }
    .operator-card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .operator-card-title i {
        color: #10b981;
    }
    .sidebar-identity-box {
        background: #ffffff;
        border-left: 1px solid #e2e8f0;
        padding-left: 20px;
        height: 100%;
    }
    .identity-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .identity-title i {
        font-size: 1.2rem;
    }
    .role-helper-text {
        font-size: 0.825rem;
        color: #64748b;
        margin-top: 6px;
        line-height: 1.4;
    }
    .status-label-group {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 15px;
    }
    .status-option {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }
    .status-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }
    .status-dot.active {
        background-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }
    .status-dot.pending {
        background-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
    }
    .status-text {
        font-weight: 600;
        font-size: 0.95rem;
    }
    .status-text.active {
        color: #047857;
    }
    .status-text.pending {
        color: #b45309;
    }
    .btn-finalize {
        background-color: #2563eb;
        color: white !important;
        border: none;
        border-radius: 8px;
        padding: 10px 24px;
        font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.15);
    }
    .btn-finalize:hover {
        background-color: #1d4ed8;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
    .btn-return {
        background-color: #f1f5f9;
        color: #475569 !important;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-return:hover {
        background-color: #e2e8f0;
    }
    .form-group label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-control {
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 10px 14px;
        height: auto;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }
    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }
    .divider-line {
        border-top: 1px solid #e2e8f0;
        margin: 2rem 0 1.5rem 0;
    }
</style>
@endpush

@section('content')
<section class="content pt-4">
    <div class="container-fluid">
        @include('backend.pages.rbac._header')

        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card operator-card">
                    <div class="operator-card-header">
                        <h3 class="operator-card-title">
                            <i class="fas fa-user-plus"></i> Register New Authorized Operator
                        </h3>
                    </div>

                    <form id="operatorRegistrationForm" method="POST">
                        @csrf
                        <div class="card-body p-4">
                            <div class="row">
                                {{-- Left Column: Form Fields --}}
                                <div class="col-lg-8 pr-lg-4">
                                    <div class="row">
                                        <div class="form-group col-md-6 mb-3">
                                            <label for="name">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" required class="form-control" placeholder="Enter Full Name">
                                            <small class="error name-error text-danger mt-1 d-block"></small>
                                        </div>

                                        <div class="form-group col-md-6 mb-3">
                                            <label for="email">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" name="email" id="email" required class="form-control" placeholder="email@example.com">
                                            <small class="error email-error text-danger mt-1 d-block"></small>
                                        </div>

                                        <div class="form-group col-md-6 mb-3">
                                            <label for="mobile">Contact Number <span class="text-danger">*</span></label>
                                            <input type="text" name="mobile" id="mobile" required class="form-control" placeholder="e.g. 01700000000">
                                            <small class="error mobile-error text-danger mt-1 d-block"></small>
                                        </div>

                                        <div class="form-group col-md-6 mb-3">
                                            <label for="assigned_area">Assigned Area <span class="text-danger">*</span></label>
                                            <select name="assigned_area" id="assigned_area" required class="form-control select2">
                                                <option value="">-- Select Area --</option>
                                                <option value="All">All System Areas (Full Access)</option>
                                                <optgroup label="Districts">
                                                    @foreach($districts as $d)
                                                        <option value="District:{{ $d->id }}">{{ $d->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Thanas">
                                                    @foreach($thanas as $t)
                                                        <option value="Thana:{{ $t->id }}">{{ $t->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Unions">
                                                    @foreach($unions as $union)
                                                        <option value="Union:{{ $union->id }}">{{ $union->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Pourashavas">
                                                    @foreach($pourashavas as $p)
                                                        <option value="Pourashava:{{ $p->id }}">{{ $p->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="City Corporations">
                                                    @foreach($city_corps as $c)
                                                        <option value="City Corp:{{ $c->id }}">{{ $c->name }}</option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Village Areas">
                                                    @if(isset($areas) && count($areas))
                                                        @foreach($areas as $area)
                                                            @php
                                                                $locationText = [];
                                                                if($area->village) $locationText[] = $area->village->en_name;
                                                                if($area->union) $locationText[] = $area->union->name;
                                                                if($area->thana) $locationText[] = $area->thana->name;
                                                                if($area->district) $locationText[] = $area->district->name;
                                                            @endphp
                                                            <option value="VillageArea:{{ $area->id }}">{{ $area->en_name }} - {{ $area->bn_name }} ({{ implode(', ', $locationText) }})</option>
                                                        @endforeach
                                                    @endif
                                                </optgroup>
                                            </select>
                                            <small class="error assigned_area-error text-danger mt-1 d-block"></small>
                                        </div>

                                        <div class="form-group col-md-6 mb-3">
                                            <label for="password">Access Password <span class="text-danger">*</span></label>
                                            <input type="password" name="password" id="password" required class="form-control" placeholder="Minimum 6 characters">
                                            <small class="error password-error text-danger mt-1 d-block"></small>
                                        </div>

                                        <div class="form-group col-md-6 mb-3">
                                            <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" required class="form-control" placeholder="Repeat password">
                                            <small class="error password_confirmation-error text-danger mt-1 d-block"></small>
                                        </div>
                                    </div>
                                </div>

                                {{-- Right Column: Security Identity and Role --}}
                                <div class="col-lg-4">
                                    <div class="sidebar-identity-box">
                                        <h4 class="identity-title">
                                            <i class="fas fa-shield-alt"></i> Security Identity
                                        </h4>

                                        <div class="form-group mb-4">
                                            <label for="role_id">Primary Security Role <span class="text-danger">*</span></label>
                                            <select name="role_id" id="role_id" required class="form-control">
                                                <option value="">Select a Role</option>
                                                @if(isset($roles) && count($roles))
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <small class="error role_id-error text-danger mt-1 d-block"></small>
                                            <p class="role-helper-text">
                                                Users inherit all capabilities assigned to their chosen role. Direct overrides are disabled for simplicity.
                                            </p>
                                        </div>

                                        <div class="form-group">
                                            <label class="d-block mb-2">Account Status</label>
                                            <div class="status-label-group">
                                                <label class="status-option mb-0">
                                                    <input type="radio" name="status" value="1" checked class="mr-2">
                                                    <span class="status-dot active"></span>
                                                    <span class="status-text active">Verified / Active</span>
                                                </label>
                                                <label class="status-option mb-0">
                                                    <input type="radio" name="status" value="0" class="mr-2">
                                                    <span class="status-dot pending"></span>
                                                    <span class="status-text pending">Pending Review</span>
                                                </label>
                                            </div>
                                            <small class="error status-error text-danger mt-1 d-block"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="divider-line"></div>

                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-finalize">
                                        <i class="fas fa-check-circle mr-1"></i> Finalize Registration
                                    </button>
                                    <a href="{{ route('user.index') }}" class="btn btn-return ml-2">
                                        <i class="fas fa-arrow-left mr-1"></i> Return to Directory
                                    </a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        $("#operatorRegistrationForm").on('submit', function(e) {
            e.preventDefault();
            let thisForm = $(this);
            $.ajax({
                type: "POST",
                url: "{{ route('user.store') }}",
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    thisForm.find('.error').html('');
                    thisForm.find('button[type="submit"]').prop("disabled", true);
                },
                success: function(response) {
                    thisForm.find('button[type="submit"]').prop("disabled", false);
                    toastr.success(response.message);
                    setTimeout(function() {
                        location.href = response.redirect_url;
                    }, 2000);
                },
                error: function(xhr, status, error) {
                    thisForm.find('button[type="submit"]').prop("disabled", false);
                    var responseText = jQuery.parseJSON(xhr.responseText);
                    toastr.error(responseText.message);
                    if(responseText.errors) {
                        $.each(responseText.errors, function(key, val) {
                            thisForm.find("." + key + "-error").text(val[0]);
                        });
                    }
                }
            });
        });
        if($(".select2").length) {
            $(".select2").select2({
                placeholder: "-- Select Area --",
                allowClear: true,
                width: '100%'
            });
        }
    });
</script>
@endpush