@extends('backend.master', ['mainMenu' => 'Bank', 'subMenu' => 'BankSelling'])
@push('style')
@endpush
@section('title', 'Bank Selling')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bank Selling</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('bank.index') }}">Bank</a></li>
                        <li class="breadcrumb-item active">Selling</li>
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
                    <form id="sellGenerateForm" method="post">
                        @csrf
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Bank Selling</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-8 d-flex align-items-center" style="gap: 10px;">
                                        <label style="min-width: 100px; margin-bottom: 0;" for="financial_year">Financial Year</label>
                                        <select name="financial_year" id="financial_year" required class="form-control">
                                            <option value="">Select Year</option>
                                            @foreach (financialYears() as $key => $financial_year)
                                                <option {{ isset($year) && $year == $key ? 'selected' : ''  }} value="{{ $key }}">{{ $financial_year }}</option>
                                            @endforeach
                                        </select>
                                        <button style="min-width: 120px;" id="find-selling-btn" type="button" class="btn btn-primary">Find Selling</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#SL</th>
                                                    <th>Bank</th>
                                                    <th class="text-center">Selling Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $total_amount = 000000.00;
                                                @endphp
                                                @if (count($banks))
                                                    @foreach ($banks as $bank)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $bank->en_name }}</td>
                                                            <td>
                                                                @php
                                                                    $bank_amount = $bank_sells[$bank->id] ?? 0;
                                                                    $total_amount = $bank_amount + $total_amount;
                                                                @endphp
                                                                <input class="form-control text-right bank-{{ $bank->id }} selling-amount" placeholder="000000.00" type="text" name="amounts[{{ $bank->id }}]" value="{{ $bank_amount }}">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="2" class="text-right">Grand Total:</th>
                                                    <th class="text-right grand-total">{{ $total_amount }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div class="form-group text-right">
                                            <a class="btn btn-danger" href="{{ route('bank-selling.index') }}">Cancel</a>
                                            <button type="reset" class="btn btn-warning">Reset</button>
                                            <button type="submit" class="btn btn-info">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </form>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    {{-- {{ route('death.store') }} --}}
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $("#sellGenerateForm").on('submit', function(e) {
                e.preventDefault();
                let thisForm = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('bank-selling.store') }}",
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
                        location.href = response.redirect_url;
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

        $(document).on('click', '#find-selling-btn', function(e){
            e.preventDefault();
            let financial_year = $("#financial_year").val();
            if(financial_year){
                location.href = "{{ route('bank-selling.index') }}?year="+financial_year;
            } else {
                toastr.error("Invalid Year");
            }
        })

        $(document).on('change', '.selling-amount', function(e){
            e.preventDefault();
            calculateGrandTotal();
        })

        function calculateGrandTotal() {
            let total_price = 0;
            $('.selling-amount').each((index, element) => {
                const value = parseFloat($(element).val()) || 0; // handle NaN
                total_price += value;
            });
            $('.grand-total').text(total_price.toFixed(2)); // optional: show 2 decimals
        }

    </script>
@endpush
