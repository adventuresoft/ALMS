@extends('backend.master', ['mainMenu' => 'User', 'subMenu' => 'ChangePassword'])

@section('title', 'Change Password')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>পাসওয়ার্ড পরিবর্তন / Change Password</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-outline card-success shadow-sm" style="border-radius: 12px; overflow: hidden; border-top: 4px solid #006a4e;">
                        <div class="card-header bg-white py-3">
                            <h3 class="card-title font-weight-bold text-dark mb-0">
                                <i class="fas fa-lock text-success mr-2"></i> আপনার পাসওয়ার্ড আপডেট করুন
                            </h3>
                        </div>

                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf

                            <div class="card-body p-4">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="form-group mb-3">
                                    <label for="current_password" class="font-weight-bold">বর্তমান পাসওয়ার্ড / Current Password <span class="text-danger">*</span></label>
                                    <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="বর্তমান পাসওয়ার্ড প্রবেশ করুন" required style="border-radius: 6px; padding: 10px;">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password" class="font-weight-bold">নতুন পাসওয়ার্ড / New Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="অন্তত ৬ অক্ষরের নতুন পাসওয়ার্ড দিন" required style="border-radius: 6px; padding: 10px;">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-4">
                                    <label for="password_confirmation" class="font-weight-bold">নতুন পাসওয়ার্ড নিশ্চিত করুন / Confirm New Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="পুনরায় নতুন পাসওয়ার্ড লিখুন" required style="border-radius: 6px; padding: 10px;">
                                </div>
                            </div>

                            <div class="card-footer bg-light text-right p-3">
                                <button type="reset" class="btn btn-secondary px-3" style="border-radius: 6px;">রিসেট</button>
                                <button type="submit" class="btn text-white px-4 font-weight-bold ml-2" style="background-color: #006a4e; border-radius: 6px;">
                                    <i class="fas fa-save mr-1"></i> আপডেট করুন
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
