<tr>
    <td style="min-width: 250px;">
        <select class="form-control bank" name="bank[]" style="min-width: 250px; height: 42px; font-size: 14px;">
            <option value="">Select Bank</option>
            @if (count($banks))
                @foreach ($banks as $bank)
                    <option {{(isset($loan->bank_id) && ($loan->bank_id == $bank->id)) ? 'selected' : ''  }} value="{{$bank->id}}">{{$bank->en_name}}</option>
                @endforeach
            @endif
        </select>
    </td>
    <td style="min-width: 160px;">
        <input type="text"
            class="form-control branch"
            name="branch[]"
            value="{{ $loan->branch_name ?? '' }}"
            placeholder="Branch Name"
            style="height: 42px; font-size: 14px;">
    </td>
    <td>
        <select class="form-control" name="loan_type[]" style="height: 42px; font-size: 14px;">
            <option value="">Loan Type</option>
            @foreach (loanTypes() as $key => $loanType)
                <option {{(isset($loan->loan_type) && ($loan->loan_type == $key)) ? 'selected' : ''  }} value="{{ $key }}">{{ $loanType }}</option>
            @endforeach
        </select>
    </td>
    <td style="min-width: 130px;">
        <input type="text"
            class="form-control amount-input"
            value="{{ isset($loan->amount) ? number_format($loan->amount, 2) : '' }}"
            name="amount[]"
            placeholder="0.00"
            style="height: 42px; font-size: 14px; text-align: right; max-width: 130px;">
    </td>
    <td>
        <select class="form-control" name="financial_year[]" style="height: 42px; font-size: 14px;">
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
