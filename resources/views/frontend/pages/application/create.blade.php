@extends('frontend.master')
@section('title', 'User Application')
@push('style')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .collapse .in{
            visibility: visible;
        }

         .collapse {
            visibility: visible !important;
        }
    </style>
@endpush
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="container p-2">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Application</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Application</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                            <div class=" mb-5">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="application_form">
                                        <form class="form-horizontal" id="applicationForm">

                                            <div class="panel-group">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">Personal Information</h4>
                                                    </div>
                                                    <section id="personal" class=" in">
                                                            @include('frontend.pages.application.partials.personal')
                                                    </section>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">Family Information</h4>
                                                    </div>
                                                    <section id="family" class="">
                                                            @include('frontend.pages.application.partials.family')
                                                    </section>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">Address</h4>
                                                    </div>
                                                    <section id="address" class="">
                                                            @include('frontend.pages.application.partials.address')
                                                    </section>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">Cultivation</h4>
                                                    </div>
                                                    <section id="cultivation" class="">
                                                            @include('frontend.pages.application.partials.cultivation')
                                                    </section>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">Land Information</h4>
                                                    </div>
                                                    <section id="land" class="">
                                                        @include('frontend.pages.application.partials.land')
                                                    </section>
                                                </div>
                                                <div class="panel panel-default">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">Initial Loan Info</h4>
                                                    </div>
                                                    <section id="loan" class="">
                                                        @include('frontend.pages.application.partials.loan')
                                                    </section>
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <a href="{{ url('/') }}" class="btn btn-secondary">Cancel</a>
                                                <button type="submit" class="btn btn-success">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->

                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection
@push('script')
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script>
        // Bangla to English digit conversion mapping
        const banglaToEnglishMap = {
            '০': '0', '১': '1', '২': '2', '৩': '3', '৪': '4',
            '৫': '5', '৬': '6', '৭': '7', '৮': '8', '৯': '9'
        };

        function convertBanglaToEnglish(str) {
            return str.replace(/[০-৯]/g, d => banglaToEnglishMap[d]);
        }

        function filterNonDigits(str) {
            return str.replace(/[^0-9]/g, '');
        }

        // Realtime sanitization for digit-only fields
        $(document).on('input', '#mobile, #nid, #birth_certificate, #father_nid, #mother_nid', function() {
            let val = $(this).val();
            let converted = convertBanglaToEnglish(val);
            let digitsOnly = filterNonDigits(converted);
            $(this).val(digitsOnly);
        });

        $(document).ready(function() {
            // Set maxlengths to prevent overflow
            $('#mobile').attr('maxlength', 11);
            $('#nid, #birth_certificate, #father_nid, #mother_nid').attr('maxlength', 17);
        });

        // English-only input constraint for Name, Father Name, Mother Name
        $(document).on('keypress', '#name, #father_name, #mother_name', function(e) {
            const char = String.fromCharCode(e.which);
            const englishRegex = /^[a-zA-Z\s\.\-\(\)]+$/;
            if (!englishRegex.test(char)) {
                e.preventDefault();
            }
        });

        $(document).on('input', '#name, #father_name, #mother_name', function() {
            let val = $(this).val();
            let cleaned = val.replace(/[^a-zA-Z\s\.\-\(\)]/g, '');
            if (val !== cleaned) {
                $(this).val(cleaned);
            }
        });

        // Bangla-only input constraint for Name In Bangla, Father/Mother Bangla Names
        $(document).on('keypress', '#bn_name, #father_name_bn, #mother_name_bn', function(e) {
            const char = String.fromCharCode(e.which);
            const isBangla = /^[\u0980-\u09FF\s\.\-\(\)]+$/.test(char);
            if (!isBangla) {
                e.preventDefault();
            }
        });

        $(document).on('input', '#bn_name, #father_name_bn, #mother_name_bn', function() {
            let val = $(this).val();
            let cleaned = val.replace(/[^\u0980-\u09FF\s\.\-\(\)]/g, '');
            if (val !== cleaned) {
                $(this).val(cleaned);
            }
        });

        $(document).on('submit', "#applicationForm", function(e) {
            e.preventDefault();
            let thisForm = $(this);
            
            // Clear previous error texts
            thisForm.find(".error").text("");

            // Client-side validations
            let mobile = $('#mobile').val();
            if (mobile && mobile.length !== 11) {
                $('#mobile').focus();
                toastr.error("Mobile number must be exactly 11 digits.");
                thisForm.find(".mobile-error").text("Mobile number must be exactly 11 digits.");
                return false;
            }

            let nid = $('#nid').val();
            if (nid && (nid.length < 10 || nid.length > 17)) {
                $('#nid').focus();
                toastr.error("NID number must be between 10 and 17 digits.");
                thisForm.find(".nid-error").text("NID number must be between 10 and 17 digits.");
                return false;
            }

            let birthCert = $('#birth_certificate').val();
            if (birthCert && (birthCert.length < 10 || birthCert.length > 17)) {
                $('#birth_certificate').focus();
                toastr.error("Birth Registration number must be between 10 and 17 digits.");
                thisForm.find(".birth_certificate-error").text("Birth Registration number must be between 10 and 17 digits.");
                return false;
            }

            let fatherNid = $('#father_nid').val();
            if (fatherNid && (fatherNid.length < 10 || fatherNid.length > 17)) {
                $('#father_nid').focus();
                toastr.error("Father's NID number must be between 10 and 17 digits.");
                thisForm.find(".father_nid-error").text("Father's NID number must be between 10 and 17 digits.");
                return false;
            }

            let motherNid = $('#mother_nid').val();
            if (motherNid && (motherNid.length < 10 || motherNid.length > 17)) {
                $('#mother_nid').focus();
                toastr.error("Mother's NID number must be between 10 and 17 digits.");
                thisForm.find(".mother_nid-error").text("Mother's NID number must be between 10 and 17 digits.");
                return false;
            }

            let _this_text = thisForm.find('button[type="submit"]').text();
            $.ajax({
                type: "POST",
                url: "{{ url('api/application-store') }}",
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    thisForm.find('button[type="submit"]').prop("disabled", true);
                    thisForm.find('button[type="submit"]').text("Loading...");
                },
                success: function(response) {
                    thisForm.find('button[type="submit"]').prop("disabled", false);
                    thisForm.find('button[type="submit"]').text(_this_text);
                    toastr.success(response.message);
                    setTimeout(() => {
                        location.href = response.redirect_url;
                    }, 3000);
                },
                error: function(xhr, status, error) {
                    thisForm.find('button[type="submit"]').prop("disabled", false);
                    thisForm.find('button[type="submit"]').text(_this_text);

                    var responseText = jQuery.parseJSON(xhr.responseText);
                    toastr.error(responseText.message);

                    $.each(responseText.errors, function(key, val) {
                        thisForm.find("." + key + "-error").text(val[0]);
                    });
                }

            });
        })

        $(document).on('change', '#same_as_present_address', function(e) {
            e.preventDefault();
            if ($(this).is(':checked')) {
                $("#same-as-permanent-address-section").hide();
            } else {
                $("#same-as-permanent-address-section").show();
            }

        })

        $(document).on('change',
            "#permanent_division, #permanent_district, #permanent_thana, #present_division, #present_district, #present_thana",
            function(e) {
                e.preventDefault();
                let _this = $(this);
                let _this_attr = _this.attr('name');
                let _this_prefix = _this_attr.split("_")[0];
                let id = _this_prefix;
                let ward = $("#" + _this_prefix + "_ward").val();
                let village = $("#" + _this_prefix + "_village").val();

                if (_this_attr === 'present_division' || _this_attr === 'permanent_division') {
                    findDistrict(_this.val(), id);
                } else if (_this_attr === 'present_district' || _this_attr === 'permanent_district') {
                    findThana(_this.val(), id);
                } else if (_this_attr === 'present_thana' || _this_attr === 'permanent_thana') {
                    findUnion(_this.val(), id);
                }


            })

        function findHouses(village = 1, ward = 1, id = "permanent") {
            let default_option = "<option value=''>Select " + id.replace(/^./, str => str.toUpperCase()) + " House</option>"
            if (village && ward && id) {
                $.ajax({
                    type: "get",
                    url: "{{ url('/house-options') }}/" + ward,
                    data: {
                        'id': id,
                        "village": village
                    },
                    success: function(response) {
                        $('#' + id + "_house").html(response);
                    }
                });
            } else {
                $('#' + id + '_house').html(default_option);
            }
        }

        function findDistrict(division = 0, id = "present") {
            findThana(0, id);
            let default_option = "<option value=''>Select " + id.replace(/^./, str => str.toUpperCase()) +
                " District</option>"
            if (division) {
                $.ajax({
                    type: "get",
                    url: "{{ url('/get-districts-by-division') }}/" + division,
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        $('#' + id + "_district").html(response);
                    }
                });
            } else {
                $('#' + id + '_district').html(default_option);
            }
        }

        function findThana(district = 0, id = "present") {
            findUnion(0, id);

            let default_option = "<option value=''>Select " + id.replace(/^./, str => str.toUpperCase()) + " Thana</option>"
            if (district) {
                $.ajax({
                    type: "get",
                    url: "{{ url('/get-thanas-by-district') }}/" + district,
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        $('#' + id + "_thana").html(response);
                    }
                });
            } else {
                $('#' + id + '_thana').html(default_option);
            }
        }

        function findUnion(thana = 0, id = "present") {
            findVillage(0, id);
            let default_option = "<option value=''>Select " + id.replace(/^./, str => str.toUpperCase()) + " Union</option>"
            if (thana) {
                $.ajax({
                    type: "get",
                    url: "{{ url('/get-unions-by-thana') }}/" + thana,
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        $('#' + id + "_union").html(response);
                    }
                });
            } else {
                $('#' + id + '_union').html(default_option);
            }
        }

        function findVillage(union = 0, id = "present") {
            let default_option = "<option value=''>Select " + id.replace(/^./, str => str.toUpperCase()) +
                " Village</option>"
            let default_road_option = "<option value=''>Select " + id.replace(/^./, str => str.toUpperCase()) +
                " Road</option>"

            let _this_village = $('#' + id + "_village");
            let _this_road = $('#' + id + "_road");
            if (union) {
                $.ajax({
                    type: "get",
                    url: "{{ url('/get-villages-by-union') }}/" + union,
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        _this_village.html(response.villageOptions);
                        _this_road.html(response.roadOptions);
                    }
                });
            } else {
                _this_village.html(default_option);
                _this_road.html(default_road_option);
            }
        }
    </script>
@endpush
