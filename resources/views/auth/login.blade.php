
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
@section('content')
    <div style="position: fixed; top: 24px; left: 24px; z-index: 50;">
      <a href="{{ url('/') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: #4b5563; font-weight: bold; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s;">
        <span style="display: flex; height: 40px; width: 40px; align-items: center; justify-content: center; border-radius: 50%; border: 1px solid #d1d5db; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.08); color: #006a4e;">
          <i class="fas fa-arrow-left"></i>
        </span>
        <span style="color: #374151;">ফিরে যান</span>
      </a>
    </div>

    <section>
        <div style="min-height: 100vh; width: 100%; display: flex; justify-content: center; align-items: center; background-color: #f3f4f6; padding: 20px 15px; margin: 0;">
            
            <div class="d-flex shadow-lg rounded overflow-hidden" style="max-width: 740px; width: 100%; background: white; min-height: 420px; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); border-radius: 12px !important;">
                
                <!-- Left Side -->
                <div class="d-none d-md-flex flex-column justify-content-between" style="background: linear-gradient(135deg, #006a4e 0%, #004d39 100%); color: white; width: 42%; padding: 28px 24px;">
                    <div>
                        <h2 style="font-size: 26px; font-weight: 900; margin-bottom: 2px; text-transform: uppercase; letter-spacing: 1px;">ALMS</h2>
                        <h3 style="font-size: 15px; font-weight: 700; color: #a7f3d0; margin-bottom: 12px;">সিস্টেম পোর্টাল</h3>
                        <div style="width: 35px; height: 3px; background-color: white; border-radius: 2px; margin-bottom: 18px;"></div>
                        
                        <div style="font-size: 12px; line-height: 1.5; color: rgba(255,255,255,0.9);">
                            <p style="margin-bottom: 12px; display: flex; align-items: flex-start; gap: 8px;">
                                <i class="fas fa-shield-alt" style="color: #a7f3d0; margin-top: 3px; font-size: 13px;"></i>
                                <span>কৃষি ঋণ মনিটরিং ও ব্যবস্থাপনা কার্যক্রম পরিচালনা করুন।</span>
                            </p>
                            <p style="margin-bottom: 12px; display: flex; align-items: flex-start; gap: 8px;">
                                <i class="fas fa-chart-line" style="color: #a7f3d0; margin-top: 3px; font-size: 13px;"></i>
                                <span>রিয়েল-টাইম রিপোর্ট এবং তথ্য বিশ্লেষণ করুন।</span>
                            </p>
                            <p style="margin-bottom: 0; display: flex; align-items: flex-start; gap: 8px;">
                                <i class="fas fa-users-cog" style="color: #a7f3d0; margin-top: 3px; font-size: 13px;"></i>
                                <span>কৃষক সেবা ও ইউজার ম্যানেজমেন্ট নিশ্চিত করুন।</span>
                            </p>
                        </div>
                    </div>
                    
                    <div class="text-center mt-3 pt-2" style="border-top: 1px solid rgba(255,255,255,0.15);">
                        <p style="font-size: 9px; font-weight: bold; letter-spacing: 2px; margin-bottom: 6px; color: rgba(255,255,255,0.7); text-transform: uppercase;">POWERED BY</p>
                        <img src="{{ asset('frontend/img/company-logo.png') }}" alt="Adventure Soft" style="height: 32px; width: auto; max-width: 120px; filter: brightness(0) invert(1); opacity: 0.9;">
                    </div>
                </div>

                <!-- Right Side -->
                <div class="d-flex flex-column justify-content-center" style="width: 58%; padding: 28px 40px;">
                    <div class="text-center mb-3">
                        <img height="50" width="50" src="{{ asset('public/backend/img/certificate/govt-bd-logo.png') }}" alt="govt-logo" style="height: 50px; width: auto;">
                        <h6 style="color: #006a4e; font-weight: bold; margin-top: 10px; margin-bottom: 2px; font-size: 14px;">Agri Loan Monitoring System</h6>
                        <h5 style="color: #1e3a8a; font-weight: bold; font-size: 16px; margin-top: 2px; margin-bottom: 5px;">{{ $panelName }}</h5>
                        <p class="mb-0 mt-1"><strong class="text-success" style="font-size: 12px;">{{ Session::get('success') }}</strong> <strong class="text-danger" style="font-size: 12px;">{{ Session::get('error') }}</strong></p>
                    </div>

                    <form id="loginForm" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label style="font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px;">User ID / Approved ID</label>
                            <div class="input-group">
                                <input type="text" name="email" id="email" placeholder="Approved ID (9 Digit) / System ID / Email" class="form-control" style="font-size: 13.5px; padding: 8px 10px; height: auto; border: 1px solid #d1d5db; border-radius: 4px;" />
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label style="font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px;">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" placeholder="Password (Default: 123456)" class="form-control" style="font-size: 13.5px; padding: 8px 10px; height: auto; border: 1px solid #d1d5db; border-right: none; border-radius: 4px 0 0 4px;" />
                                <div class="input-group-append password-show-hide pointer" style="cursor: pointer;">
                                    <span class="input-group-text" style="background: white; border: 1px solid #d1d5db; border-left: none; border-radius: 0 4px 4px 0; color: #6b7280; padding: 8px 12px;">
                                        <i class="fa fa-eye-slash" id="eyeIcon"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-block mt-3" type="submit" style="background-color: #006a4e; color: white; font-weight: bold; padding: 9px; font-size: 14px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,106,78,0.2);">Login</button>

                        <div class="text-center mt-3" style="font-size: 12px; color: #6b7280;">
                            <a href="#" data-toggle="modal" data-target="#forgotPasswordModal" style="color: #006a4e; text-decoration: none; font-weight: bold;"><i class="fas fa-key mr-1"></i> Forgot / Reset Password?</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

    <!-- Forgot / Reset Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
                <div class="modal-header text-white" style="background: linear-gradient(135deg, #006a4e 0%, #004d39 100%);">
                    <h5 class="modal-title font-weight-bold" id="forgotPasswordModalLabel" style="font-size: 16px;">
                        <i class="fas fa-lock-open mr-2"></i> পাসওয়ার্ড রিসেট / Reset Password
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="forgotPasswordForm" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <p class="text-muted mb-3" style="font-size: 13px;">
                            আপনার <strong>অনুমোদিত আইডি (Approved ID)</strong>, সিস্টেম আইডি, এনআইডি বা মোবাইল নম্বর লিখুন। পাসওয়ার্ড রিসেট করলে ডিফল্ট পাসওয়ার্ড <code>123456</code> সেট করা হবে।
                        </p>
                        <div class="form-group mb-0">
                            <label style="font-size: 13px; font-weight: 600; color: #374151;">User Identity / ID</label>
                            <input type="text" name="user_identity" class="form-control" placeholder="Approved ID / System ID / NID / Mobile" required style="font-size: 14px; padding: 10px; border-radius: 6px;">
                        </div>
                    </div>
                    <div class="modal-footer bg-light px-4 py-3">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius: 6px;">বাতিল</button>
                        <button type="submit" class="btn text-white btn-sm font-weight-bold px-4" style="background-color: #006a4e; border-radius: 6px;">
                            <i class="fas fa-redo mr-1"></i> রিসেট করুন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

        });

        // Forgot Password AJAX Form
        $("#forgotPasswordForm").on('submit', function(e) {
            e.preventDefault();
            let thisForm = $(this);
            let btn = thisForm.find('button[type="submit"]');

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                url: "{{ route('password.resetRequest') }}",
                data: thisForm.serialize(),
                dataType: "json",
                beforeSend: function() {
                    btn.prop("disabled", true);
                },
                success: function(response) {
                    btn.prop("disabled", false);
                    toastr.success(response.message);
                    $("#forgotPasswordModal").modal('hide');
                    thisForm[0].reset();
                },
                error: function(xhr) {
                    btn.prop("disabled", false);
                    var responseText = jQuery.parseJSON(xhr.responseText);
                    toastr.error(responseText.message || 'Something went wrong!');
                }
            });
        });

        let defaultPasswordType = false;
        $(document).on('click', '.password-show-hide', function(e) {
            e.preventDefault();
            let _this = $(this);
            defaultPasswordType = !defaultPasswordType;

            if (defaultPasswordType) {
                _this.find("i").removeClass('fa-eye-slash').addClass('fa-eye');
                $("#password").attr("type", "text");
            } else {
                _this.find("i").removeClass('fa-eye').addClass('fa-eye-slash');
                $("#password").attr("type", "password");
            }

        });
    });
</script>

@endpush
