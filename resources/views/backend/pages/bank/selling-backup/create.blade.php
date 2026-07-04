@extends('backend.master', ['mainMenu' => 'BankSelling', 'subMenu' => 'BankSellingCreate'])
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
                        <li class="breadcrumb-item"><a href="{{ route('loan-info.index') }}">Bank Selling</a></li>
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
                    <form id="sellGenerateForm" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $bank_selling->id }}">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Generate New Bank Selling</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="bank">Bank</label>
                                            <select class="form-control" id="bank" name="bank">
                                                <option value="">Select Bank</option>
                                                @if (count($banks))
                                                    @foreach ($banks as $bank)
                                                        <option {{ isset($bank_selling->bank_id) && $bank->id == $bank_selling->bank_id ? 'selected' : '' }} value="{{ $bank->id }}">{{ $bank->bn_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="branch">Branch</label>
                                            <select class="form-control" id="branch" name="branch">
                                                <option value="">Select Branch</option>
                                                @if (isset($branches))
                                                    @foreach ($branches as $branch)
                                                        <option {{ $branch->id == $bank_selling->branch_id ? 'selected' : '' }} value="{{ $branch->id }}">{{ $branch->bn_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="financial_year">Financial Year</label>
                                            <select name="financial_year" id="financial_year" class="form-control">
                                                <option value="">Select Year</option>
                                                @foreach (financialYears() as $key => $financial_year)
                                                    <option {{ isset($bank_selling->financial_year) && $bank_selling->financial_year == $key ? 'selected' : ''  }} value="{{ $key }}">{{ $financial_year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="amount">Selling Amount</label>
                                            <input type="text" id="amount" value="{{ $bank_selling->amount }}" class="form-control" name="amount">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">

                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="form-group row">
                                    <a href="{{ route('bank-selling.index') }}"
                                        class="btn btn-default float-right">Cancel</a>
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
                        location.href = "{{ route('bank-selling.index') }}";
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


        $(document).on('click', '.find_user_info', function(e) {
            e.preventDefault();
            let _this = $(this);
            let _this_system_id = $("#user_system_id").val();

            if (_this_system_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('user.loanInfo.searchBySystemID', '') }}/" + _this_system_id,
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
    </script>
@endpush
