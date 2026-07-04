@extends('backend.master', ['mainMenu' => 'Organization', 'subMenu' =>'OrganizationBranchList'])
@push('style')
@endpush
@section('title', 'Organization Create')
@section('content')
   <!-- Content Header (Page header) -->
   <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Department Branch Create</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('organization-branch.index')}}">Branch</a></li>
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
                            <h3 class="card-title">Department Information</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form class="form-horizontal" id="organizationForm" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" value="">

                          <div class="card-body">
    {{-- Name --}}
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">Name</label>
        <div class="col-sm-9">
            <input type="text" required name="name" value="{{ $organization->name ?? '' }}" placeholder="Department Name"
                class="form-control" id="name">
        </div>
    </div>

    {{-- Bangla Name --}}
    <div class="form-group row">
        <label for="bn_name" class="col-sm-2 col-form-label">Name (Bangla)</label>
        <div class="col-sm-9">
            <input type="text" name="bn_name" value="{{ $organization->bn_name ?? '' }}"
                placeholder="Department Name Bangla" class="form-control" id="bn_name">
        </div>
    </div>
                          <div class="form-group row">
                                    <label for="organization_id" class="col-sm-2 col-form-label">Organization</label>
                                    <div class="col-sm-10">
                                        <select name="organization_id" class="form-control select2 select2bs4"
                                            id="organization_id">
                                            <option value="">Select Organization</option>
                                            @if ($organizations)
                                                @foreach ($organizations as $organization)
                                                    <option value="{{ $organization->id }}">
                                                        {{ $organization->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="text-danger error organization_id_error"></small>
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="division_id" class="col-sm-2 col-form-label">Division</label>
                                    <div class="col-sm-10">
                                        <select name="division_id" class="form-control select2 select2bs4"
                                            id="division_id">
                                            <option value="">Select Division</option>
                                            @if ($divisions)
                                                @foreach ($divisions as $division)
                                                    <option value="{{ $division->id }}">
                                                        {{ $division->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small class="text-danger error division_id_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="district_id" class="col-sm-2 col-form-label">District</label>
                                    <div class="col-sm-10">
                                        <select name="district_id" class="form-control select2 select2bs4"
                                            id="district_id">
                                            <option value="">
                                                Select District
                                            </option>

                                        </select>

                                        <small class="text-danger error district_id_error"></small>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="thana_id" class="col-sm-2 col-form-label">Thana</label>
                                    <div class="col-sm-10">
                                        <select name="thana_id" class="form-control select2 select2bs4"
                                            id="thana_id">
                                            <option value="">
                                                Select Thana
                                            </option>
                                        </select>
                                        <small class="text-danger error thana_id_error"></small>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="union_id" class="col-sm-2 col-form-label">Union</label>
                                    <div class="col-sm-10">
                                        <select name="union_id" class="form-control select2 select2bs4"
                                            id="union_id">
                                            <option value="">
                                                Select Union
                                            </option>
                                        </select>
                                        <small class="text-danger error union_id_error"></small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address" class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10">
                                        <textarea id="address" rows="2" class="form-control" name="address" placeholder="Full Address"></textarea>
                                        <small class="text-danger error address_error"></small>
                                    </div>
                                </div>


                               
                                <div class="form-group row">
                                    <label for="priority" class="col-sm-2 col-form-label">Priority</label>
                                    <div class="col-sm-10">
                                        <input type="number" name="priority" value="{{ $organization->priority ?? '' }}"
                                            placeholder="Priority" class="form-control" id="priority">
                                        <small class="text-danger error priority_error"></small>
                                    </div>
                                </div>
                                    <div class="form-group row">
                                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-md-10">
                                        <div class="form-group">
                                            <select class="form-control" id="status" name="status">
                                                <option value="">Select Status</option>
                                                <option {{$organization->status == '1' ? 'selected' : ''}} value="1">Active</option>
                                                <option {{$organization->status == '0' ? 'selected' : ''}} value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    </div>

                            </div>

                          </div>


                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="form-group row">
                                    <a href="{{route('organization-branch.index')}}" class="btn btn-default float-right">Cancel</a>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-info">Submit</button>
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
             $(".select2").select2();
            $("#organizationForm").on('submit', function(e) {
                e.preventDefault();
                let thisForm = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{route('organization-branch.store')}}",
                    data: new FormData(this),
                    dataType: "json",
                    contentType:false,
                    cache:false,
                    processData:false,
                    beforeSend: function() {
                        thisForm.find('button[type="submit"]').prop("disabled",true);
                    },
                    success: function (response) {
                        thisForm.find('button[type="submit"]').prop("disabled",false);
                        toastr.success(response.message);
                        setTimeout(() => {
                            location.href= response.redirect_url;
                        }, 2000);
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
    </script>

    
<script>
    $(document).on('change', '#organization_ownership_type_id', function(e){
        e.preventDefault();
        if($(this).val() == 2 ){
            $('.number_of_owner').removeClass('d-none');
        }else {
            $('.number_of_owner').removeClass('d-none').addClass('d-none');
        }
    })

    $(document).on('change', '#organization_category_id', function(e){
      e.preventDefault();
      let _this_value = $(this).val();
      if(_this_value){
          $.ajax({
              type: "GET",
              url: "{{ url('organization-subcategory-options') }}/"+_this_value,
              beforeSend: function() {
                  $('#organization_subcategory_id').prop("disabled", true);
                  console.log("Searcing organization category");
              },
              success: function(response) {
                  $('#organization_subcategory_id').html(response)
                  $('#organization_subcategory_id').prop("disabled", false);
              },
              error: function(xhr, status, error) {
                  var responseText = jQuery.parseJSON(xhr.responseText);
                  toastr.error(responseText.message);
              }

          });
          $.ajax({
            type: "GET",
            url: "{{ url('organization-type-options') }}/"+_this_value,
            beforeSend: function() {
                $('#organization_type_id').prop("disabled", true);
                console.log("Searcing organization type");
            },
            success: function(response) {
                $('#organization_type_id').html(response)
                $('#organization_type_id').prop("disabled", false);
            },
            error: function(xhr, status, error) {
                $('#organization_type_id').prop("disabled", false);
                var responseText = jQuery.parseJSON(xhr.responseText);
                toastr.error(responseText.message);
            }
          });
      }
    })
    
    $(document).on('change', '#organization_subcategory_id', function(e){
        e.preventDefault();
        let _this_value = $(this).val();
        if(_this_value){
            $.ajax({
                type: "GET",
                url: "{{ url('organization-work-area-options') }}/"+_this_value,
                beforeSend: function() {
                    $('#organization_work_area_id').prop("disabled", true);
                    console.log("Searcing Work Area");
                },
                success: function(response) {
                    $('#organization_work_area_id').html(response)
                    $('#organization_work_area_id').prop("disabled", false);
                },
                error: function(xhr, status, error) {
                    var responseText = jQuery.parseJSON(xhr.responseText);
                    toastr.error(responseText.message);
                }

            });
        }
    })

    $(document).on('change', '#village_id', function(e){
        e.preventDefault();
        let _this_value = $(this).val();
        if(_this_value){
            $.ajax({
                type: "GET",
                url: "{{ url('get-areas-by-village') }}/"+_this_value,
                beforeSend: function() {
                    $('#village_area_id').prop("disabled", true);
                    console.log("Searcing Village Area");
                },
                success: function(response) {
                    $('#village_area_id').html(response)
                    $('#village_area_id').prop("disabled", false);
                },
                error: function(xhr, status, error) {
                    var responseText = jQuery.parseJSON(xhr.responseText);
                    toastr.error(responseText.message);
                }

            });
        }
    })


        $(document).on('change', '#division_id', function(e){
                e.preventDefault();
                let district_id = $('#district_id')
                let division_id = $(this).val();
                if (division_id) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('/get-districts-by-division') }}/"+division_id,
                        beforeSend: function() {
                            district_id.prop("disabled", true);
                            console.log("Searcing Districts");
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

        $(document).on('change', '#district_id', function(e){
            e.preventDefault();
            let district_id = $(this).val();
            let thana_id = $("#thana_id");

            if (district_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-thanas-by-district') }}/"+district_id,
                    beforeSend: function() {
                        thana_id.prop("disabled", true);
                        console.log("Searcing Thana");
                    },
                    success: function(response) {
                        thana_id.html(response)
                        thana_id.prop("disabled", false);
                    },
                    error: function(xhr, status, error) {
                        thana_id.prop("disabled", true);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                    }

                });
            } else {
                thana_id.prop("disabled", true);
            }
            
        })

        $(document).on('change', '#thana_id', function(e){
            e.preventDefault();
            let thana_id = $(this).val();
            let union_id = $('#union_id');
            if (thana_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-unions-by-thana') }}/"+thana_id,
                    beforeSend: function() {
                        union_id.prop("disabled", true);
                        console.log("Searcing Unions");
                    },
                    success: function(response) {
                        union_id.html(response)
                        union_id.prop("disabled", false);
                    },
                    error: function(xhr, status, error) {
                        union_id.prop("disabled", true);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                    }
                });
            } else {
                union_id.prop("disabled", true);
            }
        })

        $(document).on('change', '#union_id', function(e){
            e.preventDefault();
            let union_id = $(this).val();
            let village_id = $('#village_id');
            if (union_id) {
                $.ajax({
                    type: "GET",

                    url: "{{ url('/get-villages-by-union') }}/"+union_id,
                    beforeSend: function() {
                        village_id.prop("disabled", true);
                        console.log("Searcing Villege");
                    },
                    success: function(response) {
                        village_id.html(response.villageOptions)
                        village_id.prop("disabled", false);
                        $("#road").html(response.roadOptions);
                    },
                    error: function(xhr, status, error) {
                        village_id.prop("disabled", true);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                    }
                });
            } else {
                village_id.prop("disabled", true);
            }

        })
</script>
    

@endpush
