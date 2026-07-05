@extends('backend.master', ['mainMenu' => 'AccessManagment', 'subMenu' => 'user'])

@section('title', $title ?? 'Reset User Credentials')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title ?? 'Reset User Credentials' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
                        <li class="breadcrumb-item active">Reset Credentials</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-8 offset-md-2">

                    @include('includes.messages')

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Reset Email & Password</h3>
                        </div>

                        <form action="{{ route('user.credentials.update', $user->id) }}" method="POST" class="form-horizontal">
                            @csrf

                            <div class="card-body">

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Email <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <hr>

                                <div class="form-group row">
                                    <label for="password" class="col-sm-3 col-form-label">
                                        New Password
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Leave blank if you don't want to change">
                                        @error('password')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Minimum 6 characters. If you keep this empty, password will not be changed.
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-sm-3 col-form-label">
                                        Confirm Password
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control"
                                            placeholder="Re-type new password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Notify user</label>
                                    <div class="col-sm-9">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="send_email" id="send_email" value="1">
                                            <label class="form-check-label" for="send_email">
                                                Send new password to this email
                                            </label>
                                        </div>
                                        <small class="form-text text-muted">
                                            Only works if you set a new password above and mail is configured.
                                        </small>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer d-flex justify-content-between">
                                <a href="{{ route('user.index') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-save"></i> Update Credentials
                                </button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection
