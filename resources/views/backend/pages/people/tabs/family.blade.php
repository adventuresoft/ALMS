@extends('backend.master', ['mainMenu' => 'People', 'subMenu' => 'Create'])
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
                        <li class="breadcrumb-item"><a href="{{ route('people.index') }}">People</a></li>
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
                            <h3 class="card-title">
                                @include('backend.pages.people.tabs.tab_header', ['user' => $user, 'active_tab' => 'family'])
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post" id="peopleFamilyForm">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$user->id}}">

                            <div class="card-body">

                                <div class="form-group row">
                                    <label for="fatherName" class="col-sm-2 col-form-label">Father's Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="father_name" value="{{$user->familyInfo->father_name ?? ''}}" class="form-control" id="fatherName" placeholder="Father's Name">
                                        <small class="text-danger error father_name_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fatherNID" class="col-sm-2 col-form-label">Father's NID</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="father_nid" class="form-control" id="fatherNID"  value="{{$user->familyInfo->father_nid ?? ''}}"  placeholder="Fatherss NID">
                                        <small class="text-danger error father_nid_error"></small>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="motherName" class="col-sm-2 col-form-label">
                                        Mother's Name
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="mother_name" id="motherName"  value="{{$user->familyInfo->mother_name ??''}}"  placeholder="Mother's Name">
                                        <small class="text-danger error mother_name_error"></small>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="motherNID" class="col-sm-2 col-form-label">
                                        Mother's NID
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="mother_nid" class="form-control" id="motherNID"  value="{{$user->familyInfo->mother_nid ?? ''}}" placeholder="Mother's NID">
                                        <small class="text-danger error mother_nid_error"></small>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="maritalStatus" class="col-sm-2 col-form-label">Marital Status</label>
                                    <div class="col-sm-10">
                                        <select name="marital_status" class="form-control" id="maritalStatus">

                                            @foreach (family_constant_option('marital_status') as $key => $marital_status)
                                                <option value="{{$key}}" {{$user->familyInfo ? (($user->familyInfo->marital_status == $key) ? 'selected' : '') : ''}}>{{$marital_status}}</option>
                                            @endforeach

                                        </select>

                                        <small class="text-danger error marital_status_error"></small>

                                    </div>
                                </div>

                            </div>
                          
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <a href="{{route('people.edit', $user->id)}}" class="btn btn-danger btn-block"> Personal</a>

                                    </div>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-success btn-block">Save & Next</button>
                                    </div>

                                    <div class="col-sm-3">
                                        <a href="{{route('people.address',$user->id)}}" class="btn btn-primary btn-block ">Address </a>
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
            $("#peopleFamilyForm").on('submit', function(e) {
                e.preventDefault();
                let thisForm = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('people.familyStore') }}",
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
        })

        $(document).on('change', '#maritalStatus', function(e){
            let maritalStaus = $(this).val();
            if (maritalStaus == 1) {
                $('.marital_status_content').addClass('d-none');
            } else{
                $('.marital_status_content').removeClass('d-none');
            }
        })

        $(document).on('change', '#haveChildren', function(e){
            e.preventDefault();
            if (this.checked) {
                $('.have_children_content').removeClass('d-none');
            } else {
                $('.have_children_content').addClass('d-none');
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
