@extends('backend.master', ['mainMenu' => 'Report', 'subMenu' => 'PaymentReport'])

@push('style')
    <style>
        .report-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }
        .report-filter-header {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            color: #ffffff;
            border-radius: 12px 12px 0 0;
            padding: 16px 20px;
        }
        .kpi-card {
            border-radius: 10px;
            padding: 16px 20px;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            transition: transform 0.2s ease;
        }
        .kpi-card:hover {
            transform: translateY(-2px);
        }
        .kpi-title {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
            margin-bottom: 4px;
        }
        .kpi-value {
            font-size: 22px;
            font-weight: 800;
        }
        .table-report th {
            background-color: #065f46;
            color: #ffffff;
            font-size: 13px;
            font-weight: 600;
            vertical-align: middle !important;
            border: none;
        }
        .table-report td {
            vertical-align: middle !important;
            font-size: 13.5px;
        }
        .badge-approved-id {
            background-color: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
            padding: 4px 8px;
            border-radius: 6px;
            font-weight: 700;
            font-family: monospace;
            font-size: 12px;
        }
        .badge-fin-year {
            background-color: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        @media print {
            .no-print, .main-sidebar, .main-header, .card-header, .form-filter-sec, .pagination {
                display: none !important;
            }
            .content-wrapper {
                margin-left: 0 !important;
                padding: 0 !important;
            }
            .table-report th {
                background-color: #000 !important;
                color: #fff !important;
            }
        }
    </style>
@endpush

@section('title', 'Payment Report')

@section('content')
    <!-- Content Header -->
    <section class="content-header no-print">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold text-dark mb-0">
                        <i class="fas fa-money-check-alt text-success mr-2"></i>পেমেন্ট রিপোর্ট / Payment Report
                    </h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button class="btn btn-primary btn-sm px-3 font-weight-bold" onclick="window.print();">
                        <i class="fas fa-print mr-1"></i> প্রিন্ট করুন / Print
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Filter Card -->
            <div class="card report-card mb-4 no-print form-filter-sec">
                <div class="report-filter-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title font-weight-bold mb-0">
                        <i class="fas fa-filter mr-2"></i> ফিল্টার নির্বাচন করুন / Filter Options
                    </h3>
                </div>

                <div class="card-body p-4 bg-light">
                    <form method="GET" action="{{ route('report.payment-report') }}">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="financial_year" class="font-weight-bold text-secondary" style="font-size: 13px;">
                                    <i class="far fa-calendar-alt text-primary mr-1"></i> Financial Year (অর্থবছর)
                                </label>
                                <select name="financial_year" id="financial_year" class="form-control custom-select" style="border-radius: 6px;">
                                    <option value="">-- সকল অর্থবছর (All Years) --</option>
                                    @foreach(financialYears() as $key => $year)
                                        <option value="{{ $key }}" {{ request('financial_year') == $key ? 'selected' : '' }}>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="bank_id_select" class="font-weight-bold text-secondary" style="font-size: 13px;">
                                    <i class="fas fa-university text-success mr-1"></i> Bank (ব্যাংক)
                                </label>
                                <select name="bank_id" id="bank_id_select" class="form-control custom-select" style="border-radius: 6px;">
                                    <option value="">-- সকল ব্যাংক (All Banks) --</option>
                                    @foreach($banks as $bank)
                                        <option value="{{ $bank->id }}" {{ request('bank_id') == $bank->id ? 'selected' : '' }}>
                                            {{ $bank->en_name }} ({{ $bank->bn_name }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="branch_id_select" class="font-weight-bold text-secondary" style="font-size: 13px;">
                                    <i class="fas fa-code-branch text-info mr-1"></i> Branch (শাখা)
                                </label>
                                <select name="branch_id" id="branch_id_select" class="form-control custom-select" style="border-radius: 6px;">
                                    <option value="">-- সকল শাখা (All Branches) --</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('report.payment-report') }}" class="btn btn-outline-secondary px-3 mr-2" style="border-radius: 6px;">
                                    <i class="fas fa-undo mr-1"></i> রিসেট (Reset)
                                </a>
                                <button class="btn btn-success px-4 font-weight-bold" type="submit" style="background-color: #047857; border-radius: 6px;">
                                    <i class="fas fa-search mr-1"></i> রিপোর্ট খুঁজুন (Search Report)
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Report Results Section -->
            @if (isset($payments) && count($payments) > 0)
                <!-- KPI Metrics Cards -->
                <div class="row mb-4 no-print">
                    <div class="col-md-4 col-sm-6 mb-2">
                        <div class="kpi-card" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
                            <div class="kpi-title"><i class="fas fa-receipt mr-1"></i> মোট পেমেন্ট সংখ্যা (Total Payments)</div>
                            <div class="kpi-value">{{ number_format($payments->total()) }} টি</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-2">
                        <div class="kpi-card" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                            <div class="kpi-title"><i class="fas fa-hand-holding-usd mr-1"></i> মোট সংগৃহীত অর্থ (Total Paid Amount)</div>
                            <div class="kpi-value">৳ {{ number_format($payments->sum('amount'), 2) }}</div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 mb-2">
                        <div class="kpi-card" style="background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);">
                            <div class="kpi-title"><i class="fas fa-university mr-1"></i> ব্যাংক ফিল্টার (Bank Filter)</div>
                            <div class="kpi-value font-weight-normal" style="font-size: 16px;">
                                {{ request('bank_id') && $banks->find(request('bank_id')) ? $banks->find(request('bank_id'))->en_name : 'সকল ব্যাংক (All)' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Data Table Card -->
                <div class="card report-card overflow-hidden mb-4">
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-hover table-striped table-report mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">ক্রমিক</th>
                                    <th width="15%">পেমেন্টের তারিখ</th>
                                    <th width="22%">কৃষকের নাম ও অনুমোদিত আইডি</th>
                                    <th width="18%">যোগাযোগ ও এনআইডি</th>
                                    <th width="20%">ব্যাংক ও শাখা</th>
                                    <th width="10%">অর্থবছর</th>
                                    <th width="10%" class="text-right">জমাকৃত পরিমাণ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $key => $payment)
                                    @php
                                        $loan = $payment->loanInfo;
                                        $user = $loan?->user;
                                    @endphp
                                    <tr>
                                        <td class="text-center font-weight-bold">{{ $payments->firstItem() + $key }}</td>
                                        <td>
                                            <div class="font-weight-bold text-dark">
                                                <i class="far fa-calendar-check text-success mr-1"></i>
                                                {{ $payment->date ? date('d M, Y', strtotime($payment->date)) : '---' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold text-dark" style="font-size: 14px;">{{ $user->name ?? '---' }}</div>
                                            <div class="mt-1">
                                                <span class="badge-approved-id">
                                                    <i class="fas fa-id-badge mr-1"></i>{{ $user->approved_id ?? $user->system_id ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($user?->mobile)
                                                <div class="text-dark font-weight-bold mb-1">
                                                    <i class="fas fa-phone-alt text-success mr-1"></i>{{ $user->mobile }}
                                                </div>
                                            @endif
                                            <div class="text-muted small">
                                                NID: {{ $user->nid ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold text-dark">
                                                <i class="fas fa-university text-success mr-1"></i>{{ $loan->bank->en_name ?? $loan->bank->bn_name ?? 'N/A' }}
                                            </div>
                                            @if($loan?->branch)
                                                <div class="text-muted small mt-1">
                                                    <i class="fas fa-code-branch text-info mr-1"></i>{{ $loan->branch->bn_name }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge-fin-year">
                                                {{ $loan?->financial_year ? financialYears($loan->financial_year) : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <strong class="text-success font-weight-bold" style="font-size: 15px;">
                                                ৳ {{ number_format($payment->amount, 2) }}
                                            </strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-white d-flex justify-content-between align-items-center py-3 no-print">
                        <div class="text-muted small">
                            Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} entries
                        </div>
                        <div>
                            {{ $payments->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="card report-card p-5 text-center my-4">
                    <div class="text-muted">
                        <i class="fas fa-file-invoice-dollar fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                        <h5 class="font-weight-bold">কোনো পেমেন্ট রিপোর্ট ডাটা পাওয়া যায়নি</h5>
                        <p class="mb-0">আপনার সিলেক্টকৃত অর্থবছর বা ব্যাংকের ফিল্টারে কোনো জমা হিসেব নেই। অনুগ্রহ করে অন্য ফিল্টার চেষ্টা করুন।</p>
                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection

@push('script')
<script>
$(document).ready(function() {
    $('#bank_id_select').on('change', function() {
        var bankId = $(this).val();
        if (!bankId) {
            $('#branch_id_select').html('<option value="">-- সকল শাখা (All Branches) --</option>');
            return;
        }
        $.ajax({
            url: "{{ route('loan.getBranches', '') }}/" + bankId,
            type: "GET",
            success: function(data) {
                $('#branch_id_select').html('<option value="">-- সকল শাখা (All Branches) --</option>');
                $.each(data, function(key, branch) {
                    var selected = "{{ request('branch_id') }}" == branch.id ? 'selected' : '';
                    $('#branch_id_select').append('<option value="' + branch.id + '" ' + selected + '>' + branch.bn_name + '</option>');
                });
            }
        });
    });

    if ($('#bank_id_select').val()) {
        $('#bank_id_select').trigger('change');
    }
});
</script>
@endpush
