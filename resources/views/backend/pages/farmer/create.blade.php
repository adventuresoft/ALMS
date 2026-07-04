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
                            @include('backend.pages.farmer.tabs.tab_header', ['user' => $user ?? false, 'active_tab' => 'personal'])
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" id="farmerPersonalForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name <span class="text-danger" title="Required" data-toggle="tooltip" >*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" required value="" class="form-control"
                                            name="name" id="name" placeholder="Name in English">
                                        <small class="error name-error text-danger"></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bn_name" class="col-sm-2 col-form-label">Name Bangla <span class="text-danger" title="Required" data-toggle="tooltip" >*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" required value="" class="form-control"
                                            name="bn_name" id="bn_name" placeholder="Name in Bengali">
                                        <small class="error bn_name-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email"  value="" name="email"
                                            placeholder="email@gmail.com" class="form-control" id="email">
                                        <small class="error email-error text-danger"></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="date_of_birth" class="col-sm-2 col-form-label">Date of Birth</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="dd-mm-yyyy" name="date_of_birth"
                                            class="form-control datepicker" id="date_of_birth">
                                        <small class="error date_of_birth-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                                    <div class="col-sm-9">
                                        <select name="gender" class="form-control" id="gender">
                                            <option value="">Select Gender</option>
                                            @if (count(people_constant_option('gender')))
                                                @foreach (people_constant_option('gender') as $key => $item)
                                                    <option value="{{ $key }}" >{{ $item }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="error gender-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="mobile" class="col-sm-2 col-form-label">Mobile No.</label>
                                    <div class="col-sm-9">
                                        <input type="tel" value="" name="mobile"
                                            placeholder="01111111111" class="form-control" id="mobile">
                                        <small class="error mobile-error text-danger"></small>
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="birth_certificate" class="col-sm-2 col-form-label">Birth Reg. No.</label>
                                    <div class="col-sm-9">
                                        <input type="text" value=""
                                            name="birth_certificate" placeholder="0000000000000" class="form-control"
                                            id="birth_certificate">
                                        <small class="error birth_certificate-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nid" class="col-sm-2 col-form-label">NID No. </label>
                                    <div class="col-sm-9">
                                        <input type="text" value="" name="nid"
                                            placeholder="000 000 0000" class="form-control" id="nid">
                                        <small class="error nid-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="image" class="col-sm-2 col-form-label">Photo </label>
                                    <div class="col-sm-9">
                                        <input type="file" name="image" class="image" id="image">
                                        <small class="error image-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="image" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <img class="img-fluid img-thumbnail" src="{{ asset('public/no-image-found.jpeg') }}" id="preview" alt="Preview" width="100" height="100">
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="form-group row">
                                    <a href="{{ route('farmer.index') }}" class="btn btn-default float-right">Cancel</a>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-info">Save & Next </button>
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
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->




@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $("#farmerPersonalForm").on('submit', function(e) {
                e.preventDefault();
                let thisForm = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('farmer.store') }}",
                    data: new FormData(this),
                    dataType: "json",
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        thisForm.find('.error').html('')
                        thisForm.find('button[type="submit"]').prop("disabled", true);
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
                            thisForm.find("." + key + "-error").text(val[0]);
                        });
                    }
                });
            })
        })
    </script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#image").change(function() {
            readURL(this);

        });
    </script>
@endpush
