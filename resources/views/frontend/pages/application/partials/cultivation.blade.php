<div class="panel-body">
    <div class="form-group row align-items-center">
        <label for="is_property" class="col-sm-3 col-form-label">
            Is Available Agricultural Card?
        </label>
        <div class="col-sm-9 px-2">
            <label for="property-no" class="mb-0">
                <input type="radio" checked value="0" id="property-no" name="is_agriculture_card">
                No
            </label>

            <label for="property-yes" class="mb-0">
                <input type="radio" value="1" id="property-yes" name="is_agriculture_card">
                Yes
            </label>
            <input type="text" id="agriculture_card_number" placeholder="Agriculture Card Number" style="width: 250px;" name="agriculture_card_number" class="form-control d-none">
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item</th>
                <th>Land Owner</th>
                <th>Quantity</th>
                <th>Address</th>
                <th>Description</th>
                <th>
                    <button type="button" class="btn btn-sm btn-success add-new-cultivation">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody id="cultivation-tbody">
            @include('backend.pages.farmer.tabs.cultivation_single', ['crops' => $crops, 'cultivation' => null])
        </tbody>
    </table>
</div>

@push('script')
    <script>
        $(document).on('click', '.add-new-cultivation', function(e) {
            e.preventDefault();
            let _this = $(this);
            let _this_html = _this.html();
            $.ajax({
                type: "GET",
                url: "{{ route('farmer.cultivation.add-new') }}",
                beforeSend: function() {
                    _this.prop("disabled", true);
                    _this.html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    _this.prop("disabled", false);
                    _this.html(_this_html);
                    $("#cultivation-tbody").append(response)
                }
            });
        })

        $(document).on('click', '.remove-cultivation-item', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        })


        $(document).on('change', 'input[type=radio][name=is_agriculture_card]', function(e){
            e.preventDefault();
            if (this.value == 1) {
                $('#agriculture_card_number').removeClass('d-none');
            }
            else {
                $('#agriculture_card_number').addClass('d-none');
            }
        })

    </script>
@endpush
