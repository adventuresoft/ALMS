<tr>
    <td>
        <select class="form-control bank" name="bank[]">
            <option value="">Select Bank</option>
            @if (count($banks))
                @foreach ($banks as $bank)
                    <option {{(isset($loan->bank_id) && ($loan->bank_id == $bank->id)) ? 'selected' : ''  }} value="{{$bank->id}}">{{$bank->en_name}}</option>
                @endforeach
            @endif
        </select>
    </td>
    <td>
        <select class="form-control branch" name="branch[]">
            <option value="">Select Branch</option>
            @if (isset($loan->branch))
                <option selected value="{{$loan->branch_id}}">{{$loan->branch->en_name ?? ''}}</option>
            @endif
        </select>
    </td>
    <td>
        <select class="form-control" name="loan_type[]">
            <option value="">Loan Type</option>
            @foreach (loanTypes() as $key => $loanType)
                <option {{(isset($loan->loan_type) && ($loan->loan_type == $key)) ? 'selected' : ''  }} value="{{ $key }}">{{ $loanType }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <input type="text" class="form-control" value="{{$loan->amount ?? ''}}" name="amount[]">
    </td>
    <td>
        <select class="form-control" name="financial_year[]">
            <option value="">Financial Year</option>
            @foreach (financialYears() as $key => $year)
                <option {{(isset($loan->financial_year) && ($loan->financial_year == $key)) ? 'selected' : ''  }} value="{{ $key }}">{{ $year }}</option>
            @endforeach
        </select>
    </td>
    <td>
        <button type="button" class="btn btn-sm btn-danger remove-loan"><i class="fa fa-minus-circle"></i></button>
    </td>
</tr>
