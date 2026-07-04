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
                                    <label for="present_area" class="col-sm-2 col-form-label">Address</label>
                                    <div class="col-sm-10">
                                        <textarea id="present_area" rows="2" class="form-control" name="present_area" placeholder="Full Address">{{$user->addressInfo->present_area ?? ''}}</textarea>
                                        <small class="text-danger error present_area_error"></small>
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
                                                <option {{isset($organization->status) && $organization->status == '1' ? 'selected' : ''}} value="1">Active</option>
                                                <option {{isset($organization->status) && $organization->status == '0' ? 'selected' : ''}} value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    </div>

                            </div>

  
</div>

@push('script')

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


        $(document).on('change', '#present_division_id', function(e){
                e.preventDefault();
                let district_id = $('#present_district_id')
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

        $(document).on('change', '#present_district_id', function(e){
            e.preventDefault();
            let district_id = $(this).val();
            let present_thana_id = $("#present_thana_id");

            if (district_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-thanas-by-district') }}/"+district_id,
                    beforeSend: function() {
                        present_thana_id.prop("disabled", true);
                        console.log("Searcing Thana");
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

        $(document).on('change', '#present_thana_id', function(e){
            e.preventDefault();
            let thana_id = $(this).val();
            let present_union_id = $('#present_union_id');
            if (thana_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('/get-unions-by-thana') }}/"+thana_id,
                    beforeSend: function() {
                        present_union_id.prop("disabled", true);
                        console.log("Searcing Unions");
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

        $(document).on('change', '#present_union_id', function(e){
            e.preventDefault();
            let present_union_id = $(this).val();
            let present_village_id = $('#present_village_id');
            if (present_union_id) {
                $.ajax({
                    type: "GET",

                    url: "{{ url('/get-villages-by-union') }}/"+present_union_id,
                    beforeSend: function() {
                        present_village_id.prop("disabled", true);
                        console.log("Searcing Villege");
                    },
                    success: function(response) {
                        present_village_id.html(response.villageOptions)
                        present_village_id.prop("disabled", false);
                        $("#present_road").html(response.roadOptions);
                    },
                    error: function(xhr, status, error) {
                        present_village_id.prop("disabled", true);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        toastr.error(responseText.message);
                    }
                });
            } else {
                present_village_id.prop("disabled", true);
            }

        })
</script>
    
@endpush
