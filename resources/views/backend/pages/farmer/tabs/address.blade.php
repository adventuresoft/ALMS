@extends('backend.master', ['mainMenu' => 'Farmer', 'subMenu' => 'FarmerCreate'])
@section('title', 'Farmer Create')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Farmer Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('farmer.index') }}">Farmer</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="card card-info">
                        <div class="card-header">
                            @include('backend.pages.farmer.tabs.tab_header', [
                                'user' => $user,
                                'active_tab' => 'address',
                            ])
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" id="farmerAddressForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div class="card-header">
                                <h6 class="card-title">Present Address </h6>
                            </div>

                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="present_division_id" class="col-sm-2 col-form-label">Division</label>
                                    <div class="col-sm-10">
                                        <select name="present_division_id" class="form-control select2 select2bs4"
                                            id="present_division_id">
                                            <option value="">Select Division</option>
                                            @if ($divisions)
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->id }}"
                                                        {{ $user->addressInfo ? ($user->addressInfo->present_division_id == $division->id ? 'selected' : '') : '' }}>
                                                        {{ $division->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="text-danger error present_division_id_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="present_district_id" class="col-sm-2 col-form-label">District</label>
                                    <div class="col-sm-10">
                                        <select name="present_district_id" class="form-control select2 select2bs4"
                                            id="present_district_id">
                                            <option value="{{ $user->addressInfo->present_district_id ?? '' }}">
                                                {{ $user->addressInfo->presentDistrict->name ?? 'Select District' }}
                                            </option>

                                        </select>

                                        <small class="text-danger error present_district_id_error"></small>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="present_thana_id" class="col-sm-2 col-form-label">Thana</label>
                                    <div class="col-sm-10">
                                        <select name="present_thana_id" class="form-control select2 select2bs4"
                                            id="present_thana_id">
                                            <option value="{{ $user->addressInfo->present_thana_id ?? '' }}">
                                                {{ $user->addressInfo->presentThana->name ?? 'Select Thana' }}</option>
                                        </select>
                                        <small class="text-danger error present_thana_id_error"></small>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="present_union_id" class="col-sm-2 col-form-label">Union</label>
                                    <div class="col-sm-10">
                                        <select name="present_union_id" class="form-control select2 select2bs4"
                                            id="present_union_id">
                                            <option value="{{ $user->addressInfo->present_union_id ?? '' }}">
                                                {{ $user->addressInfo->presentUnion->name ?? 'Select Union' }} </option>
                                        </select>
                                        <small class="text-danger error present_union_id_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="present_area" class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10">
                                        <textarea id="present_area" rows="2" class="form-control" name="present_area" placeholder="Full Address">{{$user->addressInfo->present_area ?? ''}}</textarea>
                                        <small class="text-danger error present_area_error"></small>
                                    </div>
                                </div>
                            </div>



                            <div class="card-header">
                                <h6 class="card-title">Permanent Address <br><label for="same_as_present"><input type="checkbox" value="1" {{(isset($user->addressInfo->present_area) && $user->addressInfo->present_area ==  $user->addressInfo->permanent_area)  ? 'checked' : ''}} id="same_as_present" name="same_as_present"> Same as present?</label></h6>
                            </div>

                            <div class="card-body same-address {{(isset($user->addressInfo->present_area) &&  $user->addressInfo->present_area ==  $user->addressInfo->permanent_area)  ? 'd-none' : ''}} ">
                                <div class="form-group row">
                                    <label for="permanent_division_id" class="col-sm-2 col-form-label">Division</label>
                                    <div class="col-sm-10">
                                        <select name="permanent_division_id" class="form-control select2 select2bs4"
                                            id="permanent_division_id">
                                            <option value="">Select Division</option>
                                            @if ($divisions)
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->id }}"
                                                        {{ $user->addressInfo ? ($user->addressInfo->permanent_division_id == $division->id ? 'selected' : '') : '' }}>
                                                        {{ $division->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="text-danger error permanent_division_id_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="permanent_district_id" class="col-sm-2 col-form-label">District</label>
                                    <div class="col-sm-10">
                                        <select name="permanent_district_id" class="form-control select2 select2bs4"
                                            id="permanent_district_id">
                                            <option value="{{ $user->addressInfo->permanent_district_id ?? '' }}">
                                                {{ $user->addressInfo->permanentDistrict->name ?? 'Select District' }}
                                            </option>

                                        </select>

                                        <small class="text-danger error permanent_district_id_error"></small>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="permanent_thana_id" class="col-sm-2 col-form-label">Thana</label>
                                    <div class="col-sm-10">
                                        <select name="permanent_thana_id" class="form-control select2 select2bs4"
                                            id="permanent_thana_id">
                                            <option value="{{ $user->addressInfo->permanent_thana_id ?? '' }}">
                                                {{ $user->addressInfo->permanentThana->name ?? 'Select Thana' }}</option>
                                        </select>
                                        <small class="text-danger error permanent_thana_id_error"></small>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="permanent_union_id" class="col-sm-2 col-form-label">Union</label>
                                    <div class="col-sm-10">
                                        <select name="permanent_union_id" class="form-control select2 select2bs4"
                                            id="permanent_union_id">
                                            <option value="{{ $user->addressInfo->permanent_union_id ?? '' }}">
                                                {{ $user->addressInfo->permanentUnion->name ?? 'Select Union' }} </option>
                                        </select>
                                        <small class="text-danger error permanent_union_id_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="permanent_area" class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10">
                                        <textarea id="permanent_area" rows="2" class="form-control" name="permanent_area" placeholder="Full Address">{{$user->addressInfo->permanent_area ?? ''}}</textarea>
                                        <small class="text-danger error permanent_area_error"></small>
                                    </div>
                                </div>
                            </div>

                                <div class="card-footer">
                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <a href="{{ route('farmer.family', $user->id) }}"
                                                class="btn btn-danger btn-block">Family</a>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="submit" class="btn btn-success btn-block">Save</button>
                                        </div>
                                        <div class="col-sm-3">
                                            <a href="{{ route('farmer.cultivation', $user->id) }}" class="btn btn-primary btn-block ">Cultivation</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-footer -->
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row (main row) -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $("#farmerAddressForm").on('submit', function(e) {
                e.preventDefault();
                let thisForm = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('farmer.addressStore') }}",
                    data: new FormData(this),
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        thisForm.find('button[type="submit"]').prop("disabled", true);
                        $('.error').text('');
                    },
                    success: function(response) {
                        thisForm.find('button[type="submit"]').prop("disabled", false);
                        toastr.success(response.message);
                        setTimeout(function() {
                            location.href = response.redirect_url;
                        }, 2000)
                    },
                    error: function(xhr, status, error) {
                        thisForm.find('button[type="submit"]').prop("disabled", false);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                        $.each(responseText.errors, function(key, val) {
                            thisForm.find("." + key + "_error").text(val[0]);
                        });
                    }
                });
            })

            $(document).on('change', '#same_as_present', function(e){
                e.preventDefault();
                let _this = $(this);
                if (_this.prop('checked')) {
                    $('.same-address').removeClass('d-none').addClass('d-none');
                } else {
                    $('.same-address').removeClass('d-none');
                }
            })

        })
    </script>

    <script>
        $(document).on('change', '#present_division_id', function(e) {
            e.preventDefault();
            let district_id = $('#present_district_id')
            let division_id = $(this).val();
            if (division_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-districts-by-division') }}/" + division_id,
                    beforeSend: function() {
                        district_id.prop("disabled", true);
                        console.log("Searching Districts");
                    },
                    success: function(response) {
                        district_id.html(response)
                        district_id.prop("disabled", false);
                    },
                    error: function(xhr, status, error) {
                        district_id.prop("disabled", true);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                    }

                });
            } else {
                district_id.prop("disabled", true);
            }
        })

        $(document).on('change', '#present_district_id', function(e) {
            e.preventDefault();
            let district_id = $(this).val();
            let present_thana_id = $("#present_thana_id");

            if (district_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-thanas-by-district') }}/" + district_id,
                    beforeSend: function() {
                        present_thana_id.prop("disabled", true);
                        console.log("Searching Thana");
                    },
                    success: function(response) {
                        present_thana_id.html(response)
                        present_thana_id.prop("disabled", false);
                    },
                    error: function(xhr, status, error) {
                        present_thana_id.prop("disabled", true);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                    }

                });
            } else {
                present_thana_id.prop("disabled", true);
            }

        })

        $(document).on('change', '#present_thana_id', function(e) {
            e.preventDefault();
            let thana_id = $(this).val();
            let present_union_id = $('#present_union_id');
            if (thana_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-unions-by-thana') }}/" + thana_id,
                    beforeSend: function() {
                        present_union_id.prop("disabled", true);
                        console.log("Searching Unions");
                    },
                    success: function(response) {
                        present_union_id.html(response)
                        present_union_id.prop("disabled", false);
                    },
                    error: function(xhr, status, error) {
                        present_union_id.prop("disabled", true);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                    }
                });
            } else {
                present_union_id.prop("disabled", true);
            }
        })
    </script>

    <script>
        $(document).on('change', '#permanent_division_id', function(e) {
            e.preventDefault();
            let district_id = $('#permanent_district_id')
            let division_id = $(this).val();
            if (division_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-districts-by-division') }}/" + division_id,
                    beforeSend: function() {
                        district_id.prop("disabled", true);
                        console.log("Searching Districts");
                    },
                    success: function(response) {
                        district_id.html(response)
                        district_id.prop("disabled", false);
                    },
                    error: function(xhr, status, error) {
                        district_id.prop("disabled", true);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                    }

                });
            } else {
                district_id.prop("disabled", true);
            }
        })

        $(document).on('change', '#permanent_district_id', function(e) {
            e.preventDefault();
            let district_id = $(this).val();
            let permanent_thana_id = $("#permanent_thana_id");

            if (district_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-thanas-by-district') }}/" + district_id,
                    beforeSend: function() {
                        permanent_thana_id.prop("disabled", true);
                        console.log("Searching Thana");
                    },
                    success: function(response) {
                        permanent_thana_id.html(response)
                        permanent_thana_id.prop("disabled", false);
                    },
                    error: function(xhr, status, error) {
                        permanent_thana_id.prop("disabled", true);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                    }

                });
            } else {
                permanent_thana_id.prop("disabled", true);
            }

        })

        $(document).on('change', '#permanent_thana_id', function(e) {
            e.preventDefault();
            let thana_id = $(this).val();
            let permanent_union_id = $('#permanent_union_id');
            if (thana_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-unions-by-thana') }}/" + thana_id,
                    beforeSend: function() {
                        permanent_union_id.prop("disabled", true);
                        console.log("Searching Unions");
                    },
                    success: function(response) {
                        permanent_union_id.html(response)
                        permanent_union_id.prop("disabled", false);
                    },
                    error: function(xhr, status, error) {
                        permanent_union_id.prop("disabled", true);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                    }
                });
            } else {
                permanent_union_id.prop("disabled", true);
            }
        })
    </script>
@endpush
