@extends('backend.master', ['mainMenu' => 'report', 'subMenu' => 'GeneralReport'])
@section('title', 'General Report')
@push('style')
    <style>
        .report-container {
            max-width: 900px;
            background: #fff;
            padding: 35px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            margin: 20px auto;
        }

        .report-pill {
            background-color: #f1f3f4;
            border-radius: 8px;
            padding: 10px 18px;
            margin-bottom: 10px;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #e0e0e0;
        }
        .report-pill .label {
            min-width: 180px;
            font-weight: bold;
            color: #5f6368;
        }
        .report-pill .value {
            font-weight: bold;
            color: #0e6a38;
            font-size: 16px;
            text-align: right;
            margin-left: auto;
        }

        .section-header-green {
            background-color: #0e6a38;
            color: white;
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 4px;
            margin-top: 25px;
            margin-bottom: 12px;
            font-size: 15px;
            letter-spacing: 0.5px;
        }

        .report-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .report-table th {
            background-color: #f5f5f5;
            color: #333;
            font-weight: bold;
            padding: 10px;
            border: 1px solid #dee2e6;
        }
        .report-table td {
            padding: 10px;
            vertical-align: middle;
            border: 1px solid #dee2e6;
        }

        /* Print settings */
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
            .no-print, #printPageButton, .navbar, footer, .top-bar, .breadcrumb, .content-header {
                display: none !important;
            }
            .content-wrapper, .container, .card, .card-footer {
                background: #ffffff !important;
                border: none !important;
            }
            .report-container {
                max-width: 100% !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .section-header-green {
                background-color: #0e6a38 !important;
                color: #fff !important;
            }
            .report-pill {
                background-color: #f1f3f4 !important;
                border: 1px solid #e0e0e0 !important;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header no-print">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1>General Report</h1>
                </div>
                <div class="col-sm-4 text-center">
                    <button id="printPageButton" class="btn btn-outline-primary btn-sm text-center" onClick="window.print();">
                        <i class="fa fa-print"></i> Print</button>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('report.general-report') }}">General report</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="report-container mx-auto">
                                
                                <!-- Header -->
                                <div class="row align-items-center mb-3">
                                    <div class="col-md-2 col-2 text-right">
                                        <img height="90" width="90" class="mx-auto d-block"
                                             src="{{ asset('backend/img/certificate/DC_Office Dhaka_Logo.png') }}" 
                                             alt="DC Office Dhaka Logo" 
                                             style="object-fit: contain;">
                                    </div>
                                    
                                    <div class="col-md-8 col-8 text-center">
                                        <h6 class="bold mb-1" style="color: #000; font-family: 'Nikosh', 'Arial', sans-serif; font-weight: bold; font-size: 15px;">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h6>
                                        <h6 class="bold mb-1" style="color: #000; font-family: 'Nikosh', 'Arial', sans-serif; font-weight: bold; font-size: 15px;">সাধারণ শাখা</h6>
                                        <h6 class="bold mb-1" style="color: #000; font-family: 'Nikosh', 'Arial', sans-serif; font-weight: bold; font-size: 15px;">জেলা প্রশাসকের কার্যালয়,</h6>
                                        <h6 class="bold mb-0" style="color: #000; font-family: 'Nikosh', 'Arial', sans-serif; font-weight: bold; font-size: 15px;">ঢাকা।</h6>
                                    </div>
                                    
                                    <div class="col-md-2 col-2 text-left">
                                        <img height="90" width="90" class="mx-auto d-block"
                                             src="{{ asset('backend/img/certificate/govt-bd-logo.png') }}" 
                                             alt="Govt Logo" 
                                             style="object-fit: contain;">
                                    </div>
                                </div>
                                
                                <!-- Divider -->
                                <div style="border-top: 3px solid #0e6a38; margin-bottom: 15px;"></div>
                                
                                <!-- Title -->
                                <div class="text-center mb-4">
                                    <h3 class="bold mb-1" style="color: #0e6a38; font-family: 'Nikosh', 'Arial', sans-serif; font-size: 26px; font-weight: bold;">সাধারণ রিপোর্ট</h3>
                                    <h5 style="color: #555; font-family: 'Arial', sans-serif; font-weight: normal; margin-top: -2px;">General Report</h5>
                                </div>

                                <!-- Summary Table matching Profile format -->
                                <div class="section-header-green">
                                    কৃষক ও ঋণ সংক্রান্ত সারসংক্ষেপ / Farmer & Loan Statistics
                                </div>

                                <table class="table report-table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>ক্যাটেগরি / Category</th>
                                            <th>মোট (Total)</th>
                                            <th>পুরুষ (Male)</th>
                                            <th>নারী (Female)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-left font-weight-bold">কৃষকের সংখ্যা / Farmers Count</td>
                                            <td class="font-weight-bold text-success">{{ bnValue($total_farmers) }}</td>
                                            <td>{{ bnValue($male_farmers) }}</td>
                                            <td>{{ bnValue($female_farmers) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left font-weight-bold">লোনপ্রাপ্ত কৃষকের সংখ্যা / Loan Received Farmers</td>
                                            <td class="font-weight-bold text-success">{{ bnValue($total_loan_received_users) }}</td>
                                            <td>{{ bnValue($total_loan_received_male_users) }}</td>
                                            <td>{{ bnValue($total_loan_received_female_users) }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Bank & Financial Information Section -->
                                <div class="section-header-green">
                                    ব্যাংক ও ঋণের তথ্য / Bank & Financial Information
                                </div>

                                <div class="report-pill mb-3">
                                    <span class="label">মোট ব্যাংকের সংখ্যা / Total Banks Count :</span>
                                    <span class="value">{{ bnValue($total_banks) }}</span>
                                </div>

                                <table class="table report-table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-left">বিবরণ / Description</th>
                                            <th class="text-right">পরিমাণ (Amount)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-left font-weight-bold">মোট বিতরণযোগ্য ঋণের পরিমাণ / Total Distributable Loan Amount</td>
                                            <td class="text-right font-weight-bold" style="color: #0e6a38;">{{ bnValue(currencyFormat($total_distributable_loan_amount)) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left font-weight-bold">মোট বিতরণকৃত ঋণের পরিমাণ / Total Distributed Loan Amount</td>
                                            <td class="text-right font-weight-bold" style="color: #0e6a38;">{{ bnValue(currencyFormat($total_distributed_loan_amount)) }}</td>
                                        </tr>
                                        <tr style="background-color: #fcfcfc;">
                                            <td class="text-left font-weight-bold text-success" style="font-size: 15px;">বাকি বিতরণযোগ্য ঋণের পরিমাণ / Remaining Distributable Loan Amount</td>
                                            <td class="text-right font-weight-bold text-success" style="font-size: 16px;">{{ bnValue(currencyFormat($remaining_distributable_loan_amount)) }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!-- Subsidy Information Section -->
                                <div class="section-header-green">
                                    প্রণোদনার তথ্য / Subsidy Information
                                </div>

                                <table class="table report-table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-left">বিবরণ / Description</th>
                                            <th class="text-right">পরিমাণ (Amount)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-left font-weight-bold">পুরুষ কৃষকের প্রণোদনার পরিমাণ / Male Farmers Subsidy</td>
                                            <td class="text-right font-weight-bold" style="color: #0e6a38;">{{ bnValue(currencyFormat($total_subsidy_received_male_users)) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-left font-weight-bold">নারী কৃষকের প্রণোদনার পরিমাণ / Female Farmers Subsidy</td>
                                            <td class="text-right font-weight-bold" style="color: #0e6a38;">{{ bnValue(currencyFormat($total_subsidy_received_female_users)) }}</td>
                                        </tr>
                                        <tr style="background-color: #fcfcfc;">
                                            <td class="text-left font-weight-bold text-success" style="font-size: 15px;">মোট প্রণোদনার পরিমাণ / Total Subsidy Amount</td>
                                            <td class="text-right font-weight-bold text-success" style="font-size: 16px;">{{ bnValue(currencyFormat($total_subsidy_amount)) }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
