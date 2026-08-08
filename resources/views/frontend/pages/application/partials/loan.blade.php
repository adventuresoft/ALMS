<div class="panel-body">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="min-width: 250px;">Bank</th>
                <th>Branch</th>
                <th>Types</th>
                <th>Amount</th>
                <th>Financial Year</th>
                <th>
                    <button type="button" class="btn btn-sm btn-success add-new-loan">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody id="loan-tbody">
            @include('backend.pages.farmer.tabs.loan_single', ['banks' => $banks ?? [], 'loan'=> null])
        </tbody>
    </table>
</div>

@push('script')
    <script>
        $(document).on('click', '.add-new-loan', function(e){
            e.preventDefault();
            let _this = $(this);
            let _this_html = _this.html();
            $.ajax({
                type: "GET",
                url: "{{ route('farmer.classification.add-new') }}",
                beforeSend: function() {
                    _this.prop("disabled", true);
                    _this.html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    _this.prop("disabled", false);
                    _this.html(_this_html);
                    $("#loan-tbody").append(response);
                }
            });
        });

        $(document).on('click', '.remove-loan', function(e){
            e.preventDefault();
            $(this).closest('tr').remove();
        });

        // Currency formatting for amount inputs (Bangladeshi format with .00)
        function formatCurrency(input) {
            let raw = input.val().replace(/[^0-9.]/g, '');
            let parts = raw.split('.');
            let intPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            let decPart = parts[1] !== undefined ? parts[1].substring(0, 2) : '';
            input.val(intPart + (decPart !== '' || raw.endsWith('.') ? '.' + decPart : ''));
        }

        function finalizeCurrency(input) {
            let raw = input.val().replace(/[^0-9.]/g, '');
            if (!raw) { input.val(''); return; }
            let num = parseFloat(raw);
            if (isNaN(num)) { input.val(''); return; }
            let formatted = num.toLocaleString('en-BD', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            input.val(formatted);
        }

        $(document).on('input', '.amount-input', function () {
            formatCurrency($(this));
        });

        $(document).on('blur', '.amount-input', function () {
            finalizeCurrency($(this));
        });

        $(document).ready(function() {
            $('.amount-input').each(function () {
                finalizeCurrency($(this));
            });
        });
    </script>
@endpush
