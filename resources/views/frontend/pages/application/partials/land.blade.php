<div class="panel-body">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SL</th>
                <th>Land Type</th>
                <th>Division</th>
                <th>District</th>
                <th>Thana</th>
                <th>Mouza</th>
                <th>Dag No.</th>
                <th>Khatiyan No</th>
                <th>Quantity</th>
                <th>
                    <button type="button" class="btn btn-sm btn-success add-new-land">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody id="land-tbody">
            @include('backend.pages.farmer.tabs.land_single', ['land' => null])
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8" class="text-right">Total Land Quantity:</td>
                <td class="total-land-quantity text-right"></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>

@push('script')
    <script>
        $(document).on('click', '.add-new-land', function(e){
                e.preventDefault();
                let _this = $(this);
                let _this_html = _this.html();
                $.ajax({
                    type: "GET",
                    url: "{{ route('farmer.land.add-new') }}",
                    beforeSend: function() {
                        _this.prop("disabled", true);
                        _this.html('<i class="fa fa-spinner fa-spin"></i>');
                    },
                    success: function(response) {
                        _this.prop("disabled", false);
                        _this.html(_this_html);
                        $("#land-tbody").append(response)
                        updateSerial()
                    }
                });
            })

        $(document).on('click', '.remove-land-item', function(e){
                e.preventDefault();
                $(this).closest('tr').remove();
                updateSerial()
                updateTotalLandQuantity();
            })

        $(document).on('change', '.land-quantity', function(e) {
            e.preventDefault();
            updateTotalLandQuantity();
        })

        function updateSerial() {
            $(".land-sl").each((index, elem) => {
                $(elem).text(index + 1);
            });
        }

        function updateTotalLandQuantity() {
            let total_land_quantity = 0.00;
            $(".land-quantity").each((index, elem) => {
                let _this_quantity = $(elem).val();
                let quantity = parseFloat(_this_quantity)
                if (_this_quantity && quantity && !isNaN(quantity)) {
                    total_land_quantity = total_land_quantity + quantity;
                }
            });

            $(".total-land-quantity").text(total_land_quantity.toFixed(2));
        }
    </script>
@endpush
