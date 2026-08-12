@extends('backend.master', ['mainMenu' => 'Report', 'subMenu' => 'DueReport'])

@push('style')
    <style>
        .report-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }
        .report-filter-header {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
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
            background-color: #b45309;
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

@section('title', 'Due Report')

@section('content')
    <!-- Content Header -->
    <section class="content-header no-print">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="font-weight-bold text-dark mb-0">
                        <i class="fas fa-exclamation-triangle text-warning mr-2"></i>বকেয়া রিপোর্ট / Due Report
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
                    <form method="GET" action="{{ route('report.due-report') }}">
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
                                <a href="{{ route('report.due-report') }}" class="btn btn-outline-secondary px-3 mr-2" style="border-radius: 6px;">
                                    <i class="fas fa-undo mr-1"></i> রিসেট (Reset)
                                </a>
                                <button class="btn btn-warning px-4 font-weight-bold text-white" type="submit" style="background-color: #d97706; border-radius: 6px;">
                                    <i class="fas fa-search mr-1"></i> রিপোর্ট খুঁজুন (Search Report)
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Report Results Section -->
            @if (isset($loans) && count($loans) > 0)
                @php
                    $totalPayableSum = 0;
                    $totalPaidSum = 0;
                    $totalDueSum = 0;
                    foreach($loans as $l) {
                        $payable = $l->total_payable ?: $l->amount;
                        $paid = $l->payments ? $l->payments->sum('amount') : 0;
                        $due = max(0, $payable - $paid);
                        $totalPayableSum += $payable;
                        $totalPaidSum += $paid;
                        $totalDueSum += $due;
                    }
                @endphp

                <!-- KPI Metrics Cards -->
                <div class="row mb-4 no-print">
                    <div class="col-md-3 col-sm-6 mb-2">
                        <div class="kpi-card" style="background: linear-gradient(135deg, #475569 0%, #334155 100%);">
                            <div class="kpi-title"><i class="fas fa-file-invoice mr-1"></i> মোট লোন সংখ্যা (Total Loans)</div>
                            <div class="kpi-value">{{ number_format($loans->total()) }} টি</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <div class="kpi-card" style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
                            <div class="kpi-title"><i class="fas fa-balance-scale mr-1"></i> মোট প্রদেয় ঋণ (Total Payable)</div>
                            <div class="kpi-value">৳ {{ number_format($totalPayableSum, 2) }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <div class="kpi-card" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                            <div class="kpi-title"><i class="fas fa-check-circle mr-1"></i> মোট আদায় (Total Paid)</div>
                            <div class="kpi-value">৳ {{ number_format($totalPaidSum, 2) }}</div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-2">
                        <div class="kpi-card" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);">
                            <div class="kpi-title"><i class="fas fa-clock mr-1"></i> মোট অবশিষ্ট বকেয়া (Remaining Due)</div>
                            <div class="kpi-value">৳ {{ number_format($totalDueSum, 2) }}</div>
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
                                    <th width="20%">কৃষকের নাম ও অনুমোদিত আইডি</th>
                                    <th width="16%">যোগাযোগ ও এনআইডি</th>
                                    <th width="17%">ব্যাংক ও শাখা</th>
                                    <th width="10%">অর্থবছর</th>
                                    <th width="11%" class="text-right">মোট প্রদেয়</th>
                                    <th width="11%" class="text-right">পরিশোধিত টাকা</th>
                                    <th width="10%" class="text-right">অবশিষ্ট বকেয়া</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $key => $loan)
                                    @php
                                        $user = $loan->user;
                                        $payable = $loan->total_payable ?: $loan->amount;
                                        $paid = $loan->payments ? $loan->payments->sum('amount') : 0;
                                        $due = max(0, $payable - $paid);
                                    @endphp
                                    @if($user)
                                    <tr>
                                        <td class="text-center font-weight-bold">{{ $loans->firstItem() + $key }}</td>
                                        <td>
                                            <div class="font-weight-bold text-dark" style="font-size: 14px;">{{ $user->name ?? '---' }}</div>
                                            <div class="mt-1">
                                                <span class="badge-approved-id">
                                                    <i class="fas fa-id-badge mr-1"></i>{{ $user->approved_id ?? $user->system_id ?? 'N/A' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($user->mobile)
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
                                            @if($loan->branch)
                                                <div class="text-muted small mt-1">
                                                    <i class="fas fa-code-branch text-info mr-1"></i>{{ $loan->branch->bn_name }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge-fin-year">
                                                {{ $loan->financial_year ? financialYears($loan->financial_year) : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="text-right font-weight-bold">
                                            ৳ {{ number_format($payable, 2) }}
                                        </td>
                                        <td class="text-right text-success font-weight-bold">
                                            ৳ {{ number_format($paid, 2) }}
                                        </td>
                                        <td class="text-right">
                                            @if($due > 0)
                                                <strong class="text-danger" style="font-size: 14px;">৳ {{ number_format($due, 2) }}</strong>
                                            @else
                                                <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i>পরিশোধিত (Paid)</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-white d-flex justify-content-between align-items-center py-3 no-print">
                        <div class="text-muted small">
                            Showing {{ $loans->firstItem() }} to {{ $loans->lastItem() }} of {{ $loans->total() }} entries
                        </div>
                        <div>
                            {{ $loans->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="card report-card p-5 text-center my-4">
                    <div class="text-muted">
                        <i class="fas fa-exclamation-circle fa-3x mb-3 text-secondary" style="opacity: 0.5;"></i>
                        <h5 class="font-weight-bold">কোনো বকেয়া রিপোর্ট ডাটা পাওয়া যায়নি</h5>
                        <p class="mb-0">আপনার সিলেক্টকৃত অর্থবছর বা ব্যাংকের ফিল্টারে কোনো বকেয়া তথ্য নেই। অনুগ্রহ করে অন্য ফিল্টার চেষ্টা করুন।</p>
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
