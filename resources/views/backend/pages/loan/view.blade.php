@extends('backend.master', ['mainMenu' => 'Loan', 'subMenu' => 'AllLoanApply'])

@section('title', 'Loan Application Details')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <h1>Farmar Profile</h1>
    </div>
</section>

<section class="content">
<div class="container-fluid">
@include('includes.messages')
<div class="card card-primary">
<div class="card-body">

    {{-- ============================
        ১. কৃষকের তথ্য
    ============================== --}}
    <table width="100%" border="1" cellspacing="0" cellpadding="6">
        <tr>
            <td width="70%">
                <strong>Farmar Name:</strong> {{ $app->user->name ?? '---' }} <br>
                <strong>NID:</strong> {{ $app->user->nid ?? '---' }} <br>
                <strong>Mobile:</strong> {{ $app->user->mobile ?? '---' }} <br>
                <strong>User ID:</strong> {{ $app->user->system_id ?? '---' }}
            </td>
            <td width="30%" align="center">
                <img src="{{ asset('default-user.png') }}" width="120">
            </td>
        </tr>
    </table>

    <br>

    {{-- ============================
        ২. জমির তথ্য (STATIC LAYOUT)
    ============================== --}}
    <table width="100%"class="table table-striped table-bordered" cellspacing="0" cellpadding="6">
        <tr><th colspan="7" style="text-align:center">জমির তথ্য</th></tr>
        <tr>
            <th>Land Type</th>
            <th>Upazila/Thana</th>
            <th>Mouza</th>
            <th>Khatiyan No</th>
            <th>Dag No.</th>
            <th>Area (acre)</th>
            <th>Remarks</th>
        </tr>
        @if(isset($app->user->propertyInfos) && $app->user->propertyInfos->count() > 0)
       @foreach($app->user->propertyInfos as $property)
        <tr>
            <td>{{$property->land_type}}</td>
            <td>{{$property->upazila}}</td>
            <td>{{$property->mouza}}</td>
            <td>{{$property->khatian_no}}</td>
            <td>{{$property->dag_no}}</td>
            <td>{{$property->quantity}}</td>
            <td>{{$property->remarks??''}}</td>
        </tr>
        @endforeach
        @endif
    </table>

    <br>

    {{-- ============================
        ৩. Cultivation তথ্য (STATIC)
    ============================== --}}
    <table width="100%" class="table table-striped table-bordered"  cellspacing="0" cellpadding="6">
        <tr><th colspan="3" style="text-align:center">Cultivation (চাষাবাদ)</th></tr>
        <tr>
            <th>Item</th>
            <th>Area (acre)</th>
            <th>Remarks</th>
        </tr>
        @foreach($app->user->cultivations as $cultivation)
        
        <tr>
            <td>{{$cultivation->cropInfo?->name}}</td>
            <td>{{number_format($cultivation->quantity,2)}}</td>
            <td>{{$cultivation->description}}</td>
        </tr>
        @endforeach
    </table>

    <br>

    {{-- ============================
        ৪. পূর্বের ঋণের তথ্য
    ============================== --}}
    <table width="100%" class="table table-striped table-bordered" cellspacing="0" cellpadding="6">
        <tr><th colspan="2" style="text-align:center">পূর্বের ঋণের তথ্য</th></tr>
        <tr>
            <td width="50%">Loan Amount:</td>
            <td>{{ number_format($app->user->loanInfos->sum('amount'),2) }}</td>
        </tr>
        <tr>
            <td>Financial Year:</td>
            <td>
              {{ implode(', ', $app->user->loanInfos->pluck('financial_year')->map(fn($y) => financialYears($y))->toArray()) }}
            </td>
        </tr>
    </table>

    <br>
    <hr>
 <h4>আবেদিত লোনের তথ্য :</h4>
    <div class="row d-flex flex-row">
  <div class=" col-md-6 d-flex flex-coumun justify-content-between">

             <p><strong>Loan Amount:</strong> {{ $app->loan_amount }}</p>
             <p><strong>Financial Year:</strong> {{ financialYears($app->financial_year) }}</p>
            </div>
    </div>

<br>

    {{-- ============================
        ৫. গ্যারান্টর তথ্য
    ============================== --}}
    <h4>Guarantor Information:</h4>
    <div class="row d-flex flex-row">
         <div class=" col-md-4">

             <p><strong>Guarantor Name:</strong> {{ $app->g_name }}</p>
             <p><strong>Guarantor NID:</strong> {{ $app->g_nid }}</p>
             <p><strong>Guarantor Mobile:</strong> {{ $app->g_mobile }}</p>
            </div>   
        <div class="col-md-4">

            <p><strong>Father name:</strong> {{ $app->g_father }}</p>
            <p><strong>Mother name:</strong> {{ $app->g_mother }}</p>
            <p><strong>Profession:</strong> {{ $app->g_profession }}</p>
        </div>
        <div class="col-md-4">

            <p><strong>Guarantor Date of Birth:</strong> {{ $app->g_dob }}</p>
            <p><strong>Relation:</strong> {{ $app->g_relation }}</p>
            <p><strong>Address:</strong> {{ $app->g_address }}</p>
        </div>
    </div>

    <hr>


    <div class="text-center my-3">
        @if(!Auth::check() || !in_array(Auth::user()->role_id, [13, 5]))
            @if($app->status != 'rejected')
                <input type="button" id="proceedBtn" class="btn btn-primary btn-sm" value="Proceed">
                <a href="#" class="btn btn-danger btn-sm ml-2" onclick="if(confirm('Are you sure you want to reject this loan application?')){ event.preventDefault(); document.getElementById('view-reject-form').submit(); }">
                    <i class="fa fa-times"></i> Reject Application
                </a>
                <form id="view-reject-form" action="{{ route('loan.apply.reject', $app->id) }}" method="POST" style="display:none;">
                    @csrf
                </form>
            @else
                <span class="badge badge-danger p-2">Application Rejected</span>
            @endif
        @else
            @if($app->status == 'approved')
                <span class="badge badge-success p-2" style="font-size: 14px;"><i class="fas fa-check-circle mr-1"></i> Loan Approved</span>
            @elseif($app->status == 'rejected')
                <span class="badge badge-danger p-2" style="font-size: 14px;"><i class="fas fa-times-circle mr-1"></i> Application Rejected</span>
            @else
                <span class="badge badge-warning p-2" style="font-size: 14px;"><i class="fas fa-clock mr-1"></i> Pending Approval</span>
            @endif
        @endif
        <a href="{{ route('loan.apply.all') }}" class="btn btn-dark btn-sm ml-2"> <i class="fa fa-arrow-circle-left"></i> Back to List</a>
    </div>

@if(!Auth::check() || !in_array(Auth::user()->role_id, [13, 5]))
<div id="approveForm" style="display:none;">
    {{-- -------------------------------------
        APPROVAL FORM SECTION (FINAL PART)
    -------------------------------------- --}}
    <form action="{{ route('loan.apply.approve', $app->id) }}" method="POST">
        @csrf

        {{-- Hidden KEY for financial year --}}
        <input type="hidden" name="financial_year" value="{{ $app->financial_year }}">
        <input type="hidden" value="{{ $app->user->system_id }}" name="system_id">

        <table width="100%" border="1" cellspacing="0" cellpadding="6">
            <tr><th colspan="4" style="text-align:center">ঋণ অনুমোদন</th></tr>

            <tr>
                <td>Type of loan:</td>
                <td>
                    <select name="loan_type" class="form-control" required>
                        @foreach(loanTypes() as $key => $type)
                            <option value="{{ $key }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </td>

                <td>Financial Year:</td>
                <td>{{ financialYears($app->financial_year) }}</td>
            </tr>

            <tr>

             <td>Total payable:</td>
                <td><input type="text" name="total_payable" class="form-control" value="{{ $app->loan_amount }}"></td>


                <td>Interest rate (%):</td>
                <td><input type="text" name="interest_rate" class="form-control" id="interest_rate"></td>            
                
            </tr>
            <tr>
                <td>Returned amount (Loan + Interest)</td>
                <td>  <input 
        type="text" 
        name="returned_amount" 
        id="returned_amount" 
        class="form-control" 
        value="{{ $app->loan_amount }}"
        readonly 
        >
    </td>
            </tr>

            <tr>
                <td>Bank:</td>
                <td>
                    <select name="bank_id" id="bank_id" class="form-control" readonly>
                        <option value="">-- নির্বাচন করুন --</option>
                        @foreach($banks as $bank)
                            <option {{isset($bankinfo) && $bankinfo->id==$bank->id?'selected':''}} value="{{ $bank->id }}">{{ $bank->bn_name }}</option>
                        @endforeach
                    </select>
                </td>

                <!-- <td>Branch:</td>
                <td>
                    <select name="branch_id" id="branch_id" class="form-control">
                        <option value="">-- নির্বাচন করুন --</option>
                    </select>
                </td> -->
            </tr>

            <tr>
                <td>Distribution date:</td>
                <td><input type="date" name="distribution_date" class="form-control" value="{{ now()->format('Y-m-d') }}"></td>

                <td>Default date:</td>
                <td><input type="date" name="ontime_payable_date" class="form-control" value="{{ now()->addMonths(6)->format('Y-m-d') }}"></td>
            </tr>

            <tr>
                <td>Expired date:</td>
                <td><input type="date" name="last_payable_date" class="form-control" value="{{ now()->addMonths(9)->format('Y-m-d') }}"></td>
                <td></td>
                <td></td>
            </tr>

        </table>

        <br>
        <div class="text-center my-3">
        <button class="btn btn-success "> <i class="fa fa-save"></i> Submit</button>
        <a href="{{ route('loan-info.index') }}" class="btn btn-dark "><i class="	fa fa-arrow-circle-left"></i> Cancel</a>
        </div>

    </form>
</div>
@endif
</div>
</div>

</div>
</section>

@endsection
@push('script')
<script>
$(document).ready(function() {

$('#proceedBtn').on('click', function () {

    let url = "{{ route('loan.apply.proceed', $app->id) }}";

    // Disable button while request runs
    $('#proceedBtn').prop('disabled', true).val('Processing...');

    $.post(url, {_token: "{{ csrf_token() }}"})
        .done(function (response) {

            // SUCCESS → show the hidden form
            $('#approveForm').slideDown();

        })
        .fail(function () {
            alert('Could not proceed. Try again.');
            $('#proceedBtn').prop('disabled', false).val('Proceed');
        });

});



$(function(){

    function calculateReturnedAmount() {
        let loan = parseFloat({{ $app->loan_amount }});
        let rate = parseFloat($('#interest_rate').val());

        if (!isNaN(loan) && !isNaN(rate)) {
            let interest = loan * (rate / 100);
            let returned = loan + interest;
            $('#returned_amount').val(returned.toFixed(2));
        }
    }

    // Trigger on interest change
    $('#interest_rate').on('input', function(){
        calculateReturnedAmount();
    });

    // Optional: recalc on page load
    calculateReturnedAmount();
});


});


</script>
@endpush