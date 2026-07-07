@extends('backend.master', ['mainMenu' => 'Report', 'subMenu' => 'LoanReport'])
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
                    <h1>Loan Report</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('report.loan-report') }}">General report</a></li>
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
                                    <h3 class="card-title">Loan Report</h3>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body table-responsive">

                             <form>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Financial Year</label>
                                            <select name="" class="form-control">
                                                <option value="">Select Financial Year</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Bank</label>
                                            <select name="" class="form-control">
                                                <option value="">Select Bank</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Branch</label>
                                            <select name="" class="form-control">
                                                <option value="">Select Branch</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </form>

                            @if (false)
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
                                                <td>{{$loan?->user?->addressInfo->permanent_area ? $loan?->user?->addressInfo->permanent_area : $loan?->user?->addressInfo->present_area}}</td>
                                                <td>{{$loan->branch->bn_name ?? 'N/A'}}, {{$loan->bank->bn_name ?? 'N/A'}}</td>
                                                <td>{{$loan->amount}}</td>
                                                <td>{{$loan->financial_year ? financialYears($loan->financial_year) : '' }}</td>
                                                <td>{{$loan->status ? loanStatuses($loan->status) : ''}}</td>

                                                <td style="width: 10%">
                                                    <div class="table-action">
                                                        {{-- <a href="{{ route('loan-info.show', $loan->id) }}" title="View" data-toggle="tooltip" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> --}}
                                                        {{-- <a href="{{ route('loan-payment.show', $loan->id) }}" title="Payment" data-toggle="tooltip" class="btn btn-sm btn-success"><i class="fa fa-money-bill"></i></a> --}}
                                                        @can('loan-all-loans-update')
                                                        <a href="{{ route('loan-info.edit', $loan->id) }}" title="Edit" data-toggle="tooltip" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                        @endcan
                                                        @if ($loan->status == 'pending')
                                                            @can('loan-all-loans-delete')
                                                            <form class="deleteFarmer" action="{{route('loan-info.destroy', $loan->id)}}" method="post" style="display:inline-block;">
                                                                @csrf
                                                                @method('Delete')
                                                                <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></button>
                                                            </form>
                                                            @endcan
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {{ $loans->links() }}
                            @endif

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

</script>
@endpush
