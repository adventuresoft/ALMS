@extends('backend.master', ['mainMenu' => 'Subsidy', 'subMenu' => 'SubsidyCreate'])
@push('style')
@endpush
@section('title', 'Subsidy Create')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Subsidy Create</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('subsidy.index') }}">Subsidy</a></li>
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
                    <form action="" id="subsidyGenerateForm" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{$subsidy->id}}">
                        <div class="card card-info">
                            <div class="p-3 bg-info d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="card-title">Previous Loan History</h3>
                                </div>
                                <div class="row form-group mb-0">
                                    <label class="col-md-5" for="user_system_id">Farmer ID No:</label>
                                    <div class="col-md-7 input-group input-group-sm user_info">
                                        <input type="text" disabled id="user_system_id" name="user_system_id" value="{{$subsidy->user->system_id}}" required class="form-control system_id">
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-dark btn-flat find_user_info"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" id="previousLoanHistory">
                                <table class="table">
                                    <tr>
                                        <td>Name: <strong>{{$subsidy->user->farmer->bn_name}}</strong></td>
                                        <td>Father's Name: <strong>{{$subsidy->user->familyInfo->father_name}}</strong></td>
                                        <td>Mother's Name: <strong>{{$subsidy->user->familyInfo->mother_name}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Date of Birth: <strong>{{bnValue(date('d-m-Y', strtotime($subsidy->user->date_of_birth)))}}</strong></td>
                                        <td>Mobile No: <strong>{{bnValue($subsidy->user->mobile)}}</strong></td>
                                        <td>Address: <strong>{{$subsidy->user->addressInfo->permanent_area ? $subsidy->user->addressInfo->permanent_area : $subsidy->user->addressInfo->present_area }}</strong></td>
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="financial_year">Financial Year</label>
                                            <select name="financial_year" id="financial_year" class="form-control">
                                                <option value="">Financial Year</option>
                                                @foreach (financialYears() as $key=>$financial_year)
                                                    <option {{ $subsidy->financial_year == $key ? 'selected' : '' }} value="{{$key}}">{{$financial_year}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="type_id">Subsidy Type</label>
                                            <select name="type_id" id="type_id" class="form-control">
                                                <option value="">Subsidy Type</option>
                                                @if (count($subsidy_types))
                                                    @foreach ($subsidy_types as $l_key=>$type)
                                                        <option {{ $subsidy->type_id == $type->id ? "selected" : "" }} value="{{$type->id}}">{{$type->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="text" id="amount" class="form-control" value="{{ $subsidy->amount }}" name="amount">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="">Select Status</option>
                                                @foreach (loanStatuses() as $key=>$status)
                                                    <option {{ $subsidy->status == $key ? "selected" : "" }} value="{{$key}}">{{$status}}</option>
                                                @endforeach
                                            </select>
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
            $('.find_user_info').trigger('click');
            $("#subsidyGenerateForm").on('submit', function(e) {
                e.preventDefault();
                let thisForm = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{route('subsidy.store')}}",
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

    </script>
@endpush
