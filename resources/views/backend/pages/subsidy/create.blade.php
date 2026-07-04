@extends('backend.master', ['mainMenu' => 'Subsidy', 'subMenu' =>'SubsidyCreate'])
@push('style')
@endpush
@section('title', 'Subsidy')
@section('content')
   <!-- Content Header (Page header) -->
   <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Subsidy</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('subsidy.index')}}">Subsidy</a></li>
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
                    <form action="" id="loanSubsidyForm" method="post">
                        @csrf
                        <div class="card card-info">
                            <div class="p-3 bg-info d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="card-title">Previous Loan History</h3>
                                </div>
                                <div class="row form-group mb-0">
                                    <label class="col-md-5" for="user_system_id">Farmer ID No:</label>
                                    <div class="col-md-7 input-group input-group-sm user_info">
                                        <input type="text" id="user_system_id" name="user_system_id" value="" required class="form-control system_id">
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-dark btn-flat find_user_info"><i class="fa fa-search"></i></button>
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

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Create Subsidy</h3>
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
                                                    <option value="{{$key}}">{{$financial_year}}</option>
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
                                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="text" id="amount" class="form-control" name="amount">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="">Select Status</option>
                                                @foreach (loanStatuses() as $key=>$status)
                                                    <option value="{{$key}}">{{$status}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <div class="form-group row">
                                    <a href="{{route('subsidy.index')}}" class="btn btn-default float-right">Cancel</a>
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
            $("#loanSubsidyForm").on('submit', function(e) {
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


        </script>
@endpush
