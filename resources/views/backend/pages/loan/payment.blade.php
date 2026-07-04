@extends('backend.master', ['mainMenu' => 'Loan', 'subMenu' => 'LoanPayment'])
@push('style')
<style>
    .table td{
        vertical-align: middle;
    }
    .invalid-input{
        border: 1px solid red;
    }
</style>
@endpush
@section('title', 'Loan Payment')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Loan Payment</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('loan-info.index') }}">Loan</a></li>
                        <li class="breadcrumb-item active">Generate</li>
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
                    <form action="" id="paymentGenerateForm" method="post">
                        @csrf
                        <div class="card card-info">
                            <div class="p-3 bg-info d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="card-title">Farmer Profile</h3>
                                </div>
                                <div class="row form-group mb-0">
                                    <label class="col-md-5" for="user_system_id">Farmer ID No:</label>
                                    <div class="col-md-7 input-group input-group-sm user_info">
                                        <input type="text"  id="user_system_id" name="user_system_id" value="" required class="form-control system_id">
                                        <span class="input-group-append">
                                            <button type="button"  class="btn btn-dark btn-flat find_user_info"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" id="previousLoanHistory">
                                <p class="text-center">Search by farmer ID to see the loan history.</p>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <div class="card card-success d-none">
                            <div class="card-header">
                                <h3 class="card-title">Payment Information</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#SL</th>
                                                <th>Date</th>
                                                <th class="text-center">Amount</th>
                                                <th class="text-center"><button type="button" class="btn btn-sm btn-success add-new-payment"><i class="fa fa-plus-circle"></i></button></th>
                                            </tr>
                                        </thead>
                                        <tbody class="payment-tbody">

                                            <tr>
                                                <td class="sl">1</td>
                                                <td><input type="date" required class="form-control" name="dates[]" ></td>
                                                <td><input type="text" required class="form-control text-right amounts" name="amounts[]" ></td>
                                                <td class="text-center"><button type="button" class="btn btn-sm btn-danger remove-payment"><i class="fa fa-times"></i></button></td>
                                            </tr>

                                        </tbody>
                                        <footer>
                                            <tr>
                                                <th colspan="2" class="text-right">Total:</th>
                                                <th class="text-right total-paid"></th>
                                                <th></th>
                                            </tr>
                                        </footer>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="form-group row">
                                    <a href="{{ route('loan-info.index') }}" class="btn btn-default float-right">Cancel</a>
                                    <div class="col-sm-9">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </form>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Payment Collection</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="paymentGenerateForm" method="post">
                    @csrf
                    <input type="hidden" name="loan_info_id" id="loan_info_id" value="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="payment-date" class="col-form-label">Payment Date:</label>
                            <input type="date" class="form-control" required name="date" id="payment-date">
                        </div>
                        <div class="form-group">
                            <label for="amount" class="col-form-label">Payment Amount:</label>
                            <input type="text" class="form-control" required name="amount" id="amount">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- {{ route('death.store') }} --}}
@endsection
@push('script')
    <script>

        $(document).on('click', '.payment-btn', function(e){
            e.preventDefault();
            let payment_modal = $("#paymentModal");
            payment_modal.find("#loan_info_id").val($(this).attr('data-id'));
            payment_modal.modal('toggle');
        })
        $(document).on('click', '.find_user_info', function(e) {
            e.preventDefault();
            let _this = $(this);
            let _this_system_id = $("#user_system_id").val();

            if (_this_system_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('user.loanInfo.searchPaymentUser', '') }}/" + _this_system_id,
                    beforeSend: function() {
                        _this.prop("disabled", true);
                        $("#previousLoanHistory").html(
                            '<i class="fa fa-spinner fa-spin"></i> Loading...');
                    },
                    success: function(response) {
                        _this.prop("disabled", false);
                        $("#previousLoanHistory").html(response);
                    },
                    error: function(xhr, status, error) {
                        _this.prop("disabled", true);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        $("#previousLoanHistory").html(responseText.message);
                        toastr.error(responseText.message);
                    }
                });
            } else {
                toastr.error("Farmer ID Not Found.");
            }

        })

        $(document).on('change', '#bank', function(e) {
            e.preventDefault();
            let _this = $(this);
            let _this_html = _this.html();
            $.ajax({
                type: "GET",
                url: "{{ url('branch-options') }}/" + _this.val(),
                success: function(response) {
                    let branch_html = '<option value="">Select Branch</option>';
                    if (response.branches.length) {
                        response.branches.forEach(element => {
                            branch_html += '<option value="' + element.id + '">' + element
                                .bn_name + '</option>'
                        });
                    }
                    $("#branch").html(branch_html)
                }
            });
        })

         $(document).on('submit', "#paymentGenerateForm", function(e) {
            e.preventDefault();
            let thisForm = $(this);
            $.ajax({
                type: "POST",
                url: "{{ route('loan-payment.store') }}",
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    thisForm.find('button[type="submit"]').prop("disabled", true);
                },
                success: function(response) {
                    thisForm.find('button[type="submit"]').prop("disabled", false);
                    toastr.success(response.message);
                    $("#paymentModal").modal('toggle');
                    $(".find_user_info").trigger('click');
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


    </script>
@endpush
