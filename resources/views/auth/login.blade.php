
@extends('backend.layouts.login', ['title' => 'লগইন'])
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"  />
    <style>
        .bottom-div img {
            max-width: 200px;
        }
    </style>
@endpush
@section('content')
     <section>
        <div style="height: 100vh; display: flex; justify-content: center; align-items: center;">
            <div class="d-md-flex">
                <div class="d-md-flex justify-content-between align-items-start flex-column "
                    style="background: #bbe5d1; padding: 10px 80px;">
                    <div class="top-div mx-auto text-left mt-5">
                        <h6 class="fw-normal mb-1" style="letter-spacing: 1px;">Welcome to</h6>
                        <h3 class="mb-1" style="color: #253f99">ALMS</h3>
                        <h6 class="text-danger">General Section, Dhaka</h6>
                    </div>
                    <div class="bottom-div mx-auto text-center mb-5">
                        <h5>Powered by:</h5>
                        <img src="{{ asset('public/frontend/img/company-logo.png') }}" alt="adventure-soft.jpg">
                    </div>
                </div>
                <div class="d-flex align-items-center" style="background: #e2eef7; padding: 5px 20px;">
                    <div class="card-body p-3 text-black">
                        <form  id="loginForm" method="post">
                            @csrf
                            <div class="text-center">

                                <img height="80" width="80" src="{{ asset('frontend/img/govt-logo.png') }}"
                                    alt="govt-logo.png">
                                <h6 class="fw-normal my-1" style="letter-spacing: 1px; color:#12a14d">Agri Loan Monitoring System</h6>
                                <h5 class="my-0" style="color: #253f99">Admin Login Panel</h5>
                                <p class="mb-2"><strong class="text-success">{{ Session::get('success') }}</strong> <strong
                                        class="text-danger">{{ Session::get('error') }}</strong></p>
                            </div>

                            <div class="form-outline mb-1">
                                <label class="form-label font-weight-bold font-italic mb-0" for="email">User
                                    ID</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fa fa-user"></i></div>
                                    </div>
                                    <input type="text" name="email" id="email" placeholder="User ID"
                                        class="form-control" />
                                </div>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label font-weight-bold font-italic mb-0" for="password">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend" style="cursor: pointer">
                                        <div class="input-group-text password-show-hide pointer btn"><i class="fa fa-lock"></i></div>
                                    </div>
                                    <input type="password" name="password" id="password" placeholder="Password" class="form-control" />
                                </div>
                            </div>

                            <div class=" mb-2">
                                <button class="btn btn-dark btn-block" type="submit">Login</button>
                            </div>

                            <p class="mb-1" style="color: #393f81;">
                                <a class="small text-muted" style="color: #393f81;"
                                    href="#">Forgot
                                    password?</a>
                            </p>
                            <a href="#!" class="small text-muted">Terms of use.</a>
                            <a href="#!" class="small text-muted">Privacy policy</a>
                        </form>
                    </div>
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
