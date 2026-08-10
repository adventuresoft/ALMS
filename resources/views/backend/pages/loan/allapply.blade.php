@extends('backend.master', ['mainMenu' => 'Loan', 'subMenu' => 'AllLoanApply'])

@section('title', 'Loan Applications')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <h1>Loan Applications</h1>
    </div>
</section>

<section class="content">
<div class="container-fluid">
@include('includes.messages')
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">All Loan Applications</h3>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>SL. No.</th>
                    <th>Farmar ID</th>
                    <th>Farmar Name</th>
                    <th>District & Upazilla</th>
                    <th>Applied Bank</th>
                    <th>Financial Year</th>
                    <th>Loan Amount</th>                    
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($applications as $app)
                @php 
                $step_time=$app->step_time;
                $current_time=now();
                $difference = $step_time ? $current_time->diffInMinutes($step_time) : 999;
                @endphp 
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$app->user?->system_id ?? 'N/A'}}</td>
                    <td>{{$app->user?->name ?? 'N/A'}}</td>
                    <td>{{$app->user?->addressInfo?->permanentDistrict?->name ? $app->user?->addressInfo?->permanentDistrict?->name.' & ' : ''}} {{$app->user?->addressInfo?->permanentThana?->name}}</td>
                    <td>
                        <span class="badge badge-info">
                            {{ $app->bank?->en_name ?? $app->bank?->bn_name ?? 'N/A' }}
                        </span>
                    </td>
                    <td>{{ financialYears($app->financial_year) }}</td>
                    <td>{{ number_format($app->loan_amount,2) }}</td>
                   
                    <td>
                        @if($app->status == 'approved')
                            <span class="badge badge-success">Approved</span>
                        @elseif($app->status == 'rejected')
                            <span class="badge badge-danger">Rejected</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>

                    <td>
                        @can('loan-all-loan-apply-read')
                        <a href="{{ route('loan.apply.view', $app->id) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i> View
                        </a>
                        @endcan

                        @if(is_superadmin() || is_bank_admin())
                            @if($app->status != 'rejected')
                                <a href="#" class="btn btn-danger btn-sm ml-1"
                                    onclick="if(confirm('Are you sure you want to reject this loan application?')){
                                        event.preventDefault();
                                        document.getElementById('reject-form-{{ $app->id }}').submit();
                                    }">
                                    <i class="fa fa-times"></i> Reject
                                </a>

                                <form id="reject-form-{{ $app->id }}" action="{{ route('loan.apply.reject', $app->id) }}" method="POST" style="display:none;">
                                    @csrf
                                </form>
                            @endif
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $applications->links() }}

    </div>
</div>

</div>
</section>

@endsection
