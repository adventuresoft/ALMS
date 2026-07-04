
@extends('backend.layouts.login', ['title' => 'লগইন'])
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"  />
    <style>
        .bottom-div img {
            max-width: 200px;
        }
    </style>
@endpush
@php
    $role = request()->query('role');
    $panelName = 'Admin Login Panel';
    if ($role === 'krishok') {
        $panelName = 'Krishok Login Panel';
    } elseif ($role === 'admin') {
        $panelName = 'Admin Login Panel';
    } elseif ($role === 'banker') {
        $panelName = 'Banker Login Panel';
    }
@endphp
    <section>
        <div style="height: 100vh; display: flex; justify-content: center; align-items: center; background-color: #f3f4f6;">
            
            <div class="d-flex shadow-lg rounded overflow-hidden" style="max-width: 850px; width: 100%; background: white; min-height: 500px;">
                
                <!-- Left Side -->
                <div class="d-none d-md-flex flex-column justify-content-between" style="background-color: #006a4e; color: white; width: 45%; padding: 50px 40px;">
                    <div>
                        <h4 class="mb-1" style="font-weight: 300;">Welcome to</h4>
                        <h1 class="mb-2" style="font-weight: 800; font-size: 40px; letter-spacing: 1px;">ALMS</h1>
                        <div style="width: 40px; height: 3px; background-color: white; margin-bottom: 20px;"></div>
                        <h6 style="color: #a7f3d0; font-size: 15px; font-weight: 500;">General Section, Dhaka</h6>
                    </div>
                    
                    <div>
                        <p style="font-size: 11px; font-weight: bold; letter-spacing: 1px; margin-bottom: 5px; color: #a7f3d0;">POWERED BY</p>
                        <img src="{{ asset('public/frontend/img/company-logo.png') }}" alt="Adventure Soft" style="width: 140px; filter: brightness(0) invert(1);">
                    </div>
                </div>

                <!-- Right Side -->
                <div class="d-flex flex-column justify-content-center" style="width: 55%; padding: 40px 60px;">
                    <div class="text-center mb-4">
                        <img height="65" width="65" src="{{ asset('frontend/img/govt-logo.png') }}" alt="govt-logo">
                        <h6 style="color: #006a4e; font-weight: bold; margin-top: 15px; font-size: 15px;">Agri Loan Monitoring System</h6>
                        <h5 style="color: #1e3a8a; font-weight: bold; font-size: 18px; margin-top: 5px;">{{ $panelName }}</h5>
                        <p class="mb-0 mt-2"><strong class="text-success" style="font-size: 13px;">{{ Session::get('success') }}</strong> <strong class="text-danger" style="font-size: 13px;">{{ Session::get('error') }}</strong></p>
                    </div>

                    <form id="loginForm" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label style="font-size: 13px; font-weight: 600; color: #374151;">User ID</label>
                            <div class="input-group">
                                <input type="text" name="email" id="email" placeholder="User ID / Email" class="form-control" style="font-size: 14px; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px;" />
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label style="font-size: 13px; font-weight: 600; color: #374151;">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" placeholder="Password" class="form-control" style="font-size: 14px; padding: 10px; border: 1px solid #d1d5db; border-right: none; border-radius: 4px 0 0 4px;" />
                                <div class="input-group-append password-show-hide pointer" style="cursor: pointer;">
                                    <span class="input-group-text" style="background: white; border: 1px solid #d1d5db; border-left: none; border-radius: 0 4px 4px 0; color: #6b7280;">
                                        <i class="fa fa-eye-slash" id="eyeIcon"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-block" type="submit" style="background-color: #006a4e; color: white; font-weight: bold; padding: 10px; border-radius: 4px;">Login</button>

                        <div class="text-center mt-4" style="font-size: 13px; color: #6b7280;">
                            <a href="#" style="color: #6b7280; text-decoration: none;">Forgot password?</a> &nbsp;|&nbsp; 
                            <a href="#" style="color: #6b7280; text-decoration: none;">Privacy policy</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>


  <!-- jQuery -->
<script src="{{ asset('public/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Toastr -->
<script src="{{ asset('public/plugins/toastr/toastr.min.js') }}"></script>

@endsection

@push('script')

  <!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

  <script>
    $(document).ready(function() {
        $("#loginForm").on('submit', function(e) {
            e.preventDefault();
            let thisForm = $(this);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                url: "{{ route('login.check') }}",
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    thisForm.find(".loading-button").removeClass('d-none');
                    thisForm.find('button[type="submit"]').prop("disabled", true);
                    thisForm.find('.login-box-msg').removeClass('text-danger text-success')
                        .text('');

                },
                success: function(response) {
                    toastr.success(response.message);
                    thisForm.find('.login-box-msg').removeClass('text-danger text-success')
                        .addClass('text-success').text(response.message);
                    setTimeout(function() {
                      location.href = "{{ route('dashboard') }}";
                    }, 2000)

                },
                error: function(xhr, status, error) {
                    thisForm.find(".loading-button").addClass('d-none');
                    thisForm.find('button[type="submit"]').prop("disabled", false);
                    var responseText = jQuery.parseJSON(xhr.responseText);
                    toastr.error(responseText.message);
                    thisForm.find('.login-box-msg').removeClass('text-danger text-success')
                        .addClass('text-danger').text(responseText.message);


                    $.each(responseText.errors, function(key, val) {
                        thisForm.find(".error-" + key).text(val[0]);
                    });
                }

            });

        })

        let defaultPasswordType = false;
        $(document).on('click', '.password-show-hide', function(e) {
            e.preventDefault();
            let _this = $(this);
            defaultPasswordType = !defaultPasswordType;

            if (defaultPasswordType) {
                _this.find("i").removeClass('fa-lock').addClass('fa-unlock');
                $("#password").attr("type", "text");
            } else {
                _this.find("i").removeClass('fa-unlock').addClass('fa-lock');
                $("#password").attr("type", "password");
            }

        })
    })
</script>

@endpush
