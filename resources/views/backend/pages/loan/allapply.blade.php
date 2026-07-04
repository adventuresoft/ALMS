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
                $difference = $current_time->diffInMinutes($step_time);
                
                @endphp 
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$app->user->system_id}}</td>
                    <td>{{$app->user->name}}</td>
                    <td>{{$app->user->addressInfo?->permanentDistrict?->name?$app->user->addressInfo?->permanentDistrict?->name.' & ' :''}} {{$app->user->addressInfo?->permanentThana?->name}}</td>
                    <td>{{ financialYears($app->financial_year) }}</td>
                    <td>{{ number_format($app->loan_amount,2) }}</td>
                   
                    <td>{{ ucfirst($app->status) }}</td>

                    <td>
                        @if($difference >10 )
                        <a href="{{ route('loan.apply.view', $app->id) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-eye"></i> View
                        </a>
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
