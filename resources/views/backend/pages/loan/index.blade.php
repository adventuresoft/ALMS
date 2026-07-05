@extends('backend.master', ['mainMenu' => 'Loan', 'subMenu' => 'LoanList'])
@push('style')
    <style>
        #farmer_table_wrapper .dataTables_filter {
            float: right;
        }

        #farmer_table_wrapper .dataTables_paginate {
            float: right;
        }
    </style>
@endpush
@section('title', 'Loan View')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Loan Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('loan-info.index') }}">Loan</a></li>
                        <li class="breadcrumb-item active">View</li>
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
                    <div class="card card-info">
                        <div class="card-header ">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="card-title">Loan List</h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="farmer_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>ID & Name</th>
                                        <th>Mobile & Email</th>
                                        <th>Location</th>
                                        <th>Bank</th>
                                        <th>Loan</th>
                                        <th>Year</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($loans))
                                        @foreach ($loans as $key => $loan)

                                            @if($loan and isset($loan->user->system_id) )
                                            <tr>
                                                <td> {{$loop->iteration}}</td>
                                                <td>{{ $loan->user->name ?? '' }}<br>{{ $loan->user->system_id ?? '' }}</td>
                                                 <td>
                                                    @php
                                                        $mobile = $loan->user->mobile ? ('<a href="tel:'.$loan->user->mobile.'">'.$loan->user->mobile.'</a>') : '';
                                                        $email =  $loan->user->email ? ('<br><a href="mailto:'.$loan->user->email.'">'.$loan->user->email.'</a>') : '';
                                                    @endphp
                                                    {!!$mobile!!}
                                                    {!!$email!!}
                                                </td>
                                                <td>{{$loan?->user?->addressInfo?->permanent_area ? $loan?->user?->addressInfo?->permanent_area : $loan?->user?->addressInfo?->present_area}}</td>
                                                <td>{{$loan->branch->bn_name ?? 'N/A'}}, {{$loan->bank->bn_name ?? 'N/A'}}</td>
                                                <td>{{$loan->amount}}</td>
                                                <td>{{$loan->financial_year ? financialYears($loan->financial_year) : '' }}</td>
                                                <td>{{$loan->status ? loanStatuses($loan->status) : ''}}</td>

                                                <td style="width: 10%">
                                                    <div class="table-action">
                                                        {{-- <a href="{{ route('loan-info.show', $loan->id) }}" title="View" data-toggle="tooltip" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> --}}
                                                        @if ( create_permission() )
                                                            {{-- <a href="{{ route('loan-payment.show', $loan->id) }}" title="Payment" data-toggle="tooltip" class="btn btn-sm btn-success"><i class="fa fa-money-bill"></i></a> --}}
                                                            <a href="{{ route('loan-info.edit', $loan->id) }}" title="Edit" data-toggle="tooltip" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                            @if ($loan->status == 'pending')
                                                                <form class="deleteFarmer" action="{{route('loan-info.destroy', $loan->id)}}" method="post">
                                                                    @csrf
                                                                    @method('Delete')
                                                                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                                                                </form>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            </div>
                            {{ $loans->links() }}

                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $("#farmer_table").DataTable({
                "paging": false,
                "filter" : false,
            })

            $(".deleteFarmer").submit(function(e) {
                e.preventDefault();
                var thisForm = $(this);
                var formData = thisForm.serialize();
                var deleteUrl = thisForm.attr('action');
                $("#toast-container").show();
                toastr.success(
                    "<br /><button type='button' id='confirmationRevertNo' class='btn clear'>No</button><br /><button type='button' id='confirmationRevertYes' class='btn clear'>Yes</button>",
                    'Are you sure, you want to delete it?', {
                        closeButton: false,
                        allowHtml: true,
                        onShown: function(toast) {
                            $("#confirmationRevertYes").click(function() {
                                $.ajax({
                                    type: "POST",
                                    url: deleteUrl,
                                    data: formData,
                                    beforeSend: function() {
                                        thisForm.find('button[type="submit"]').prop("disabled", true);
                                    },
                                    success: function(response) {
                                        thisForm.find('button[type="submit"]').prop("disabled", false);
                                        toastr.success(response.message);
                                        setTimeout(function() {location.reload();},2000);
                                    },
                                    error: function(xhr, status, error) {
                                        thisForm.find('button[type="submit"]').prop("disabled", false);
                                        var responseText = jQuery.parseJSON(xhr.responseText);
                                        toastr.error(responseText.message);
                                    }
                                });
                            });
                            $("#confirmationRevertNo").click(function() {
                                $("#toast-container").hide();
                            })
                        }
                    });
            })
        })
    </script>
    <script>
        // $(function() {
        //     $("#farmer_table").DataTable({
        //         "responsive": true,
        //         "lengthChange": false,
        //         "autoWidth": false,
        //         "buttons": ["csv", "excel", "pdf", "print"]
        //     }).buttons().container().appendTo('#farmer_table_wrapper .col-md-6:eq(0)');
        // });
    </script>
@endpush
