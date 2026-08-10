@extends('backend.master', ['mainMenu' => 'Loan', 'subMenu' =>'ApplyLoan'])
@section('title', 'Apply for Loan')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Apply for Loan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Loan</a></li>
                    <li class="breadcrumb-item active">Apply</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @include('includes.messages')
        <form action="{{ route('loan.apply.store') }}" method="POST" id="applyLoanForm">
            @csrf

            <!-- Loan Information -->
            <div class="card card-info">
                <div class="card-header bg-info">
                    <h3 class="card-title">Loan Information</h3>
                </div>

                <div class="card-body">
                    <div class="row">

                        <div class="col-md-4">
                            <label>Financial Year</label>
                            <select name="financial_year" class="form-control">
                                <option value="">Select</option>
                                @foreach(financialYears() as $key => $year)
                                <option value="{{ $key }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Required Loan Amount <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="loan_amount" placeholder="1000000.00" required>
                        </div>

                        <div class="col-md-4">
                            <label>Select Bank <span class="text-danger">*</span></label>
                            <select name="bank_id" id="apply_bank_id" class="form-control" required>
                                <option value="">-- Select Bank --</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->en_name }} ({{ $bank->bn_name }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mt-3">
                            <label>Select Branch (Optional)</label>
                            <select name="branch_id" id="apply_branch_id" class="form-control">
                                <option value="">-- Select Branch --</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Guarantor Information -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Loan Guarantor Information</h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4">
                            <label>Guarantor Name</label>
                            <input type="text" class="form-control" name="g_name">
                        </div>

                        <div class="col-md-4">
                            <label>Guarantor NID</label>
                            <input type="text" class="form-control" name="g_nid">
                        </div>

                        <div class="col-md-4">
                            <label>Guarantor Mobile</label>
                            <input type="text" class="form-control" name="g_mobile">
                        </div>

                    </div>

                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label>Father's Name</label>
                            <input type="text" class="form-control" name="g_father">
                        </div>

                        <div class="col-md-4">
                            <label>Mother's Name</label>
                            <input type="text" class="form-control" name="g_mother">
                        </div>

                        <div class="col-md-4">
                            <label>Profession</label>
                            <input type="text" class="form-control" name="g_profession">
                        </div>

                    </div>

                    <div class="row mt-3">

                        <div class="col-md-4">
                            <label>Date of Birth</label>
                            <input type="date" class="form-control" name="g_dob">
                        </div>

                        <div class="col-md-4">
                            <label>Relation</label>
                            <input type="text" class="form-control" name="g_relation">
                        </div>

                        <div class="col-md-4">
                            <label>Address</label>
                            <input type="text" class="form-control" name="g_address">
                        </div>

                    </div>

                </div>

                <!-- Footer -->
                <div class="card-footer d-flex justify-content-end">
                    <button type="reset" class="btn btn-warning mr-2">
                        <i class="fa fa-undo-alt"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Submit
                    </button>
                </div>

            </div>

        </form>

    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#apply_bank_id').on('change', function() {
            var bankId = $(this).val();
            if (!bankId) {
                $('#apply_branch_id').html('<option value="">-- Select Branch --</option>');
                return;
            }
            $.ajax({
                url: "{{ route('loan.getBranches', '') }}/" + bankId,
                type: "GET",
                success: function(data) {
                    $('#apply_branch_id').html('<option value="">-- Select Branch --</option>');
                    $.each(data, function(key, branch) {
                        $('#apply_branch_id').append('<option value="' + branch.id + '">' + branch.bn_name + '</option>');
                    });
                }
            });
        });
    });
</script>
@endsection
