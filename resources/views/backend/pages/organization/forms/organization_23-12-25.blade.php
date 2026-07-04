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

    {{-- Category --}}
    <div class="form-group row">
        <label for="organization_category_id" class="col-sm-2 col-form-label">Category</label>
        <div class="col-sm-9">
            <select  class="form-control select2" name="organization_category_id" id="organization_category_id">
                <option value=""> Category</option>
                @if (count($categories))
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ isset($organization->organization_category_id) ? ($organization->organization_category_id == $category->id ? 'selected' : '') : '' }}>
                            {{ $category->en_name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div> 

    {{-- Subcategory --}}
    <div class="form-group row">
        <label for="organization_subcategory_id" class="col-sm-2 col-form-label">Sub Category</label>
        <div class="col-sm-9">
            <select  class="form-control select2" name="organization_subcategory_id"
                id="organization_subcategory_id">
                @if (isset($organization->organization_subcategory_id))
                    <option value="{{ $organization->organization_subcategory_id }}">
                        {{ $organization->subcategory->en_name }}</option>
                @endif
            </select>
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

    $(document).on('change', '#village_area_id', function(e){
        e.preventDefault();
        let _this_value = $(this).val();
        if(_this_value){
            $.ajax({
                type: "GET",
                url: "{{ url('get-houses-by-village-area') }}/"+_this_value,
                beforeSend: function() {
                    $('#house_id').prop("disabled", true);
                    console.log("Searcing Houses");
                },
                success: function(response) {
                    $('#house_id').html(response)
                    $('#house_id').prop("disabled", false);
                },
                error: function(xhr, status, error) {
                    var responseText = jQuery.parseJSON(xhr.responseText);
                    toastr.error(responseText.message);
                }
            });
        }
    })
</script>
    
@endpush
