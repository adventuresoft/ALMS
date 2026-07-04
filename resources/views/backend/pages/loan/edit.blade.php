@extends('backend.master', ['mainMenu' => 'Loan', 'subMenu' => 'LoanGenerate'])
@push('style')
@endpush
@section('title', 'Loan Generate')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Loan Generate</h1>
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
                    <form action="" id="loanGenerateForm" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$loan->id}}">
                        <div class="card card-info">
                            <div class="p-3 bg-info d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="card-title">Previous Loan History</h3>
                                </div>
                                <div class="row form-group mb-0">
                                    <label class="col-md-5" for="user_system_id">Farmer ID No:</label>
                                    <div class="col-md-7 input-group input-group-sm user_info">
                                        <input type="text" disabled id="user_system_id" name="user_system_id" value="{{$loan->user->system_id}}" required class="form-control system_id">
                                        <span class="input-group-append">
                                            <button type="button" disabled class="btn btn-dark btn-flat find_user_info"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" id="previousLoanHistory">
                                <table class="table">
                                    <tr>
                                        <td>Name: <strong>{{$loan->user->farmer->bn_name}}</strong></td>
                                        <td>Father's Name: <strong>{{$loan->user->familyInfo->father_name}}</strong></td>
                                        <td>Mother's Name: <strong>{{$loan->user->familyInfo->mother_name}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Date of Birth: <strong>{{bnValue(date('d-m-Y', strtotime($loan->user->date_of_birth)))}}</strong></td>
                                        <td>Mobile No: <strong>{{bnValue($loan->user->mobile)}}</strong></td>
                                        <td>Address: <strong>{{$loan->user->addressInfo->permanent_area ? $loan->user->addressInfo->permanent_area : $loan->user->addressInfo->present_area }}</strong></td>
                                    </tr>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Generate New Loan</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="financial_year">Financial Year</label>
                                            <select name="financial_year" id="financial_year" class="form-control">
                                                <option value="">Select Financial Year</option>
                                                @foreach (financialYears() as $key => $financial_year)
                                                    <option {{$key == $loan->financial_year ? 'selected' : ''}} value="{{ $key }}">{{ $financial_year }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bank">Bank</label>
                                            <select class="form-control" id="bank" name="bank">
                                                <option value="">Select Bank</option>
                                                @if (count($banks))
                                                    @foreach ($banks as $bank)
                                                        <option {{$bank->id == $loan->bank_id ? 'selected' : ''}} value="{{ $bank->id }}">{{ $bank->bn_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="branch">Branch</label>
                                            <select class="form-control" id="branch" name="branch">
                                                <option value="">Select Branch</option>
                                                @if (count($branches))
                                                    @foreach ($branches as $branch)
                                                        <option {{$branch->id == $loan->branch_id ? 'selected' : ''}} value="{{ $branch->id }}">{{ $branch->bn_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="loan_type">Loan Type</label>
                                            <select name="loan_type" id="loan_type" class="form-control">
                                                <option value="">Select Loan Type</option>
                                                @foreach (loanTypes() as $l_key => $loanType)
                                                    <option {{$l_key == $loan->loan_type ? 'selected' : ''}} value="{{ $l_key }}">{{ $loanType }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="loan_amount">Loan Amount</label>
                                            <input type="text" id="loan_amount" class="form-control" name="loan_amount" value="{{$loan->amount}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="interest_rate">Interest Rate</label>
                                            <input type="text" id="interest_rate" class="form-control" name="interest_rate" value="{{$loan->interest_rate}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="total_payable">Total Payable</label>
                                            <input type="text" id="total_payable" class="form-control" name="total_payable" value="{{$loan->total_payable}}">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="distribution_date">Distribution Date</label>
                                            <input type="date" class="form-control" name="distribution_date" value="{{$loan->distribution_date}}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="ontime_payable_date">Duration Date</label>
                                            <input type="date" class="form-control" name="ontime_payable_date" value="{{$loan->ontime_payable_date}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="last_payable_date">Default Date</label>
                                            <input type="date" class="form-control" name="last_payable_date" value="{{$loan->last_payable_date}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="">Select Status</option>
                                                @foreach (loanStatuses() as $key => $status)
                                                    <option {{$key == $loan->status ? 'selected' : ''}} value="{{ $key }}">{{ $status }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-header" style="padding-left: 0;">
                                    <h3 class="card-title">Loan Guarantor Information</h3>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="guarantor_name">Guarantor Name</label>
                                            <input type="text" class="form-control" placeholder="Guarantor Name" name="guarantor_name" value="{{$loan->guarantor_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="guarantor_dob">Date of Birth</label>
                                            <input type="date" class="form-control" name="guarantor_dob" value="{{$loan->guarantor_dob}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="guarantor_nid">NID</label>
                                            <input type="text"  id="guarantor_nid" class="form-control" name="guarantor_nid" placeholder="NID" value="{{$loan->guarantor_nid}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="guarantor_mobile">Mobile</label>
                                            <input type="text" id="guarantor_mobile" class="form-control" placeholder="Mobile" name="guarantor_mobile" value="{{$loan->guarantor_mobile}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="guarantor_father_name">Father Name</label>
                                            <input type="text" class="form-control" placeholder="Father Name" name="guarantor_father_name" value="{{$loan->guarantor_father_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="guarantor_mother_name">Mother Name</label>
                                            <input type="text" class="form-control" placeholder="Mother Name" name="guarantor_mother_name" value="{{$loan->guarantor_mother_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="guarantor_profession">Profession</label>
                                            <input type="text" class="form-control" placeholder="Profession" name="guarantor_profession" value="{{$loan->guarantor_profession}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="guarantor_address">Address</label>
                                            <textarea id="guarantor_address" class="form-control" placeholder="Address" name="guarantor_address" rows="1">{{$loan->guarantor_address}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
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

    {{-- {{ route('death.store') }} --}}
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $("#loanGenerateForm").on('submit', function(e) {
                e.preventDefault();
                let thisForm = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{route('loan-info.store')}}",
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
                        $('.find_user_info').trigger('click');
                        thisForm.trigger('reset');
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


        $(document).on('click', '.find_user_info', function(e){
            e.preventDefault();
            let _this = $(this);
            let _this_system_id = $("#user_system_id").val();

            if(_this_system_id){
                $.ajax({
                    type: "GET",
                    url: "{{ route('user.loanInfo.searchBySystemID', '') }}/" + _this_system_id,
                    beforeSend: function() {
                        _this.prop("disabled",true);
                        $("#previousLoanHistory").html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                    },
                    success: function(response) {
                        _this.prop("disabled",false);
                        $("#previousLoanHistory").html(response);
                    },
                    error: function(xhr, status, error) {
                        _this.prop("disabled",true);
                        var responseText = jQuery.parseJSON(xhr.responseText);
                        $("#previousLoanHistory").html(responseText.message);
                        toastr.error(responseText.message);
                    }
                });
            }else {
                toastr.error("Farmer ID Not Found.");
            }

        })


        $(document).on('change', '#bank', function(e){
            e.preventDefault();
            let _this = $(this);
            let _this_html = _this.html();
            $.ajax({
                type: "GET",
                url: "{{ url('branch-options') }}/"+_this.val(),
                success: function(response) {
                    let branch_html = '<option value="">Select Branch</option>';
                    if (response.branches.length) {
                        response.branches.forEach(element => {
                            branch_html +='<option value="'+element.id+'">'+element.bn_name+'</option>'
                        });
                    }
                    $("#branch").html(branch_html)
                }
            });
        })

        $(document).on('change', '#interest_rate', function(e){
            e.preventDefault();
            calculateTotalPayable();
        })

        $(document).on('change', '#total_payable', function(e){
            e.preventDefault();
            calculateInterestRate();
        })

        function calculateTotalPayable() {
            let loan_amount = parseFloat($("#loan_amount").val());
            let interest_rate = parseFloat($("#interest_rate").val());
            let total_payable = 0;

            if (!isNaN(loan_amount) && !isNaN(interest_rate) && interest_rate >= 0) {
                total_payable = loan_amount + (loan_amount * (interest_rate / 100));
            }

            $("#total_payable").val(total_payable.toFixed(2)); // formatted for readability
        }


        function calculateInterestRate() {
            let loan_amount = parseFloat($("#loan_amount").val());
            let total_payable = parseFloat($("#total_payable").val());
            let interest_rate = 0;

            if (!isNaN(loan_amount) && !isNaN(total_payable) && total_payable >= loan_amount && loan_amount > 0) {
                let interest_amount = total_payable - loan_amount;
                interest_rate = (interest_amount / loan_amount) * 100;
            }

            $("#interest_rate").val(interest_rate.toFixed(2));
        }

    </script>
@endpush
