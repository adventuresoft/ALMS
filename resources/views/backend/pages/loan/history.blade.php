<div>
    <input type="hidden" name="user_id" value="{{$user->id}}">
    <table class="table">
        <tr>
            <td>Name: <strong>{{$user->farmer->bn_name}}</strong></td>
            <td>Father's Name: <strong>{{$user->familyInfo->father_name}}</strong></td>
            <td>Mother's Name: <strong>{{$user->familyInfo->mother_name}}</strong></td>
        </tr>
        <tr>
            <td>Date of Birth: <strong>{{date('d-m-Y', strtotime($user->date_of_birth))}}</strong></td>
            <td>Mobile No: <strong>{{bnValue($user->mobile)}}</strong></td>
            <td>Address: <strong>{{$user->addressInfo->permanent_area ? $user->addressInfo->permanent_area : $user->addressInfo->present_area }}</strong></td>
        </tr>
    </table>
    <table class="table table-bordered">
        <thead class="thead-dark bg-dark">
            <tr>
                <td>SL</td>
                <td>Financial Year</td>
                <td>Bank</td>
                <td>Branch</td>
                <td>Loan Type</td>
                <td>Amount</td>
                <td>Status</td>
            </tr>
        </thead>
        <tbody>
            @if (count($user->loanInfos))
                @foreach ($user->loanInfos as $loanInfo)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{financialYears($loanInfo->financial_year)}}</td>
                        <td>{{$loanInfo->branch->bank->bn_name ?? ''}}</td>
                        <td>{{$loanInfo->branch->bn_name ?? ''}}</td>
                        <td>{{loanTypes($loanInfo->loan_type)}}</td>
                        <td>{{$loanInfo->amount}}</td>
                        <td>{{loanStatuses($loanInfo->status)}}</td>
                    </tr>
                @endforeach
            @else
                    <tr>
                        <td colspan="7" class="text-center">There are no loan history.</td>
                    </tr>
            @endif
        </tbody>
    </table>
</div>
