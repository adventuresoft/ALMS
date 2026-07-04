@extends('backend.master', ['mainMenu' => 'People', 'subMenu' =>'Create'])
@section('title', 'People Create')
@section('content')
   <!-- Content Header (Page header) -->
   <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>People Information</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('people.index')}}">People</a></li>
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
                            @include('backend.pages.people.tabs.tab_header', ['user' => $user, 'active_tab' => 'personal'])
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->

                        <form class="form-horizontal" id="peoplePersonalForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Name <span class="text-danger" title="Required" data-toggle="tooltip" >*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" required value="{{ $user->name ?? '' }}" class="form-control"
                                            name="name" id="name" placeholder="Name English">
                                        <small class="error name-error text-danger"></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bn_name" class="col-sm-2 col-form-label">Name Bangla <span class="text-danger" title="Required" data-toggle="tooltip" >*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" required value="{{ $user->people->bn_name ?? '' }}" class="form-control"
                                            name="bn_name" id="bn_name" placeholder="Name Bangla">
                                        <small class="error bn_name-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email <span class="text-danger" title="Required" data-toggle="tooltip" >*</span></label>
                                    <div class="col-sm-9">
                                        <input type="email" required value="{{ $user->email ?? '' }}" name="email"
                                            placeholder="Email" class="form-control" id="email">
                                        <small class="error email-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="date_of_birth" class="col-sm-2 col-form-label">Date of Birth</label>
                                    <div class="col-sm-9">
                                        <input type="date" value="{{ $user->people->date_of_birth ?? '' }}" name="date_of_birth"
                                            class="form-control" id="date_of_birth">
                                        <small class="error date_of_birth-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="birth_place" class="col-sm-2 col-form-label">Birth Place</label>
                                    <div class="col-sm-9">
                                        <select name="birth_place"  class="form-control" id="birth_place">
                                                <option value="">Select Birth Place</option>
                                            @if (count(people_constant_option('birth_place')))
                                                @foreach (people_constant_option('birth_place') as $key => $item)
                                                    <option value="{{ $key }}" {{isset($user->people->birth_place) ? (($user->people->birth_place == $key) ? 'selected' : '') : ''}}>{{ $item }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="error birth_place-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row districts {{isset($user->people->birth_place) ? (($user->people->birth_place == 1) ? '' : 'd-none') : 'd-none'}} ">
                                    <label for="district_id" class="col-sm-2 col-form-label">District</label>
                                    <div class="col-sm-9">
                                        <select name="district_id" class="form-control" id="district_id">
                                            @if (count($districts))
                                                @foreach ($districts as $district)
                                                    <option value="{{ $district->id }}" {{isset($user->people->district_id) ? (($user->people->district_id == $district->id) ? 'selected' : '') : ''}}>{{ $district->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="error district_id-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row countries {{isset($user->people->birth_place) ? (($user->people->birth_place == 2) ? '' : 'd-none') : 'd-none'}} ">
                                    <label for="country_id" class="col-sm-2 col-form-label">Country</label>
                                    <div class="col-sm-9">
                                        <select name="country_id" class="form-control" id="country_id">
                                            @if (count($countries))
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}" {{isset($user->people->country_id) ? (($user->people->country_id == $country->id) ? 'selected' : '') : ''}}>{{ $country->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="error country_id-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                                    <div class="col-sm-9">
                                        <select name="gender" class="form-control" id="gender">
                                            <option value="">Select Gender</option>
                                            @if (count(people_constant_option('gender')))
                                                @foreach (people_constant_option('gender') as $key => $item)
                                                    <option value="{{ $key }}" {{isset($user->people->gender) ? (($user->people->gender == $key) ? 'selected' : '') : ''}}>{{ $item }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="error gender-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="religion" class="col-sm-2 col-form-label">Religion</label>
                                    <div class="col-sm-9">
                                        <select name="religion" class="form-control" id="religion">
                                            <option value="">Select Religion</option>
                                            @if (count($religions))
                                                @foreach ($religions as $religion)
                                                    <option value="{{ $religion->id }}" {{isset($user->people->religion_id) ? (($user->people->religion_id == $religion->id) ? 'selected' : '') : ''}} >{{ $religion->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="error religion-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="blood_group" class="col-sm-2 col-form-label">Blood Group</label>
                                    <div class="col-sm-9">
                                        <select name="blood_group" class="form-control" id="blood_group">
                                            <option value="">Select Blood Group</option>
                                            @if (count(people_constant_option('blood_group')))
                                                @foreach (people_constant_option('blood_group') as $key => $item)
                                                    <option value="{{ $key }}" {{isset($user->people->blood_group) ? (($user->people->blood_group == $key) ? 'selected' : '') : ''}} >{{ $item }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="error blood_group-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="mobile" class="col-sm-2 col-form-label">Mobile No.</label>
                                    <div class="col-sm-9">
                                        <input type="tel" value="{{ $user->mobile ?? '' }}" name="mobile"
                                            placeholder="Mobile" class="form-control" id="mobile">
                                        <small class="error mobile-error text-danger"></small>
                                    </div>
                                </div>

                               

                                <div class="form-group row">
                                    <label for="birth_certificate" class="col-sm-2 col-form-label">Birth Reg. No.</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $user->birth_certificate ?? '' }}"
                                            name="birth_certificate" placeholder="Birth Reg. No." class="form-control"
                                            id="birth_certificate">
                                        <small class="error birth_certificate-error text-danger"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nid" class="col-sm-2 col-form-label">NID No. </label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $user->nid ?? '' }}" name="nid"
                                            placeholder="NID No." class="form-control" id="nid">
                                        <span class="error nid-error text-danger"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="image" class="col-sm-2 col-form-label">Photo </label>
                                    <div class="col-sm-9">
                                        <input type="file" name="image" class="image" id="image">
                                        <span class="error image-error text-danger"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="image" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <img class="img-fluid img-thumbnail" src="{{ $user->image ? asset($user->image) : asset('public/no-image-found.jpeg') }}" id="preview" alt="Preview" width="100" height="100">
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="form-group row">
                                    <a href="{{ route('people.index') }}" class="btn btn-default float-right">Cancel</a>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-info">Update & Next </button>
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
            $("#peoplePersonalForm").on('submit', function(e) {
                e.preventDefault();
                let thisForm = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('people.update', $user->id) }}",
                    data: new FormData(this),
                    dataType: "json",
                    contentType:false,
                    cache:false,
                    processData:false,
                    beforeSend: function() {
                        thisForm.find('button[type="submit"]').prop("disabled",true);
                        $('.error').text('')
                    },
                    success: function (response) {
                        thisForm.find('button[type="submit"]').prop("disabled",false);
                        toastr.success(response.message);
                         setTimeout(function() {
                             location.href = response.redirect_url;
                         }, 2000)
                    },
                    error: function(xhr, status, error) {
                        thisForm.find('button[type="submit"]').prop("disabled",false);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                        $.each(responseText.errors, function(key, val) {
                            thisForm.find("." + key + "-error").text(val[0]);
                        });
                    }
                });
            })
        })

        $(document).on('change', '#birth_place', function(e){
            e.preventDefault();
            let birth_place = $(this).val();
            if( birth_place == 1){
                $('.districts').removeClass('d-none');
                $('.countries').addClass('d-none');
            } else if (birth_place == 2) {
                $('.countries').removeClass('d-none');
                $('.districts').addClass('d-none');
            } else {
                $('.districts').addClass('d-none');
                $('.countries').addClass('d-none');
            }
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
