@extends('backend.master', ['mainMenu' => 'Report', 'subMenu' => 'GeneralReport'])
@push('style')
    <style>
        #farmer_table_wrapper .dataTables_filter {
            float: right;
        }

        #farmer_table_wrapper .dataTables_paginate {
            float: right;
        }
    </style>
@endpush
@push('style')
    <style>
        /* Print settings */
        @media print {
            @page {
                size: A4 portrait;
                margin: 20mm;
            }
            .top-bar{
                display: none;
            }

            .navbar {
                display: none;
            }

            #printPageButton {
                display: none;
            }

            .bg-success {
                background: #28a745 !important;
                color: #fff;
            }

            footer {
                display: none;
            }

            .content-wrapper,
            .container,
            .card,
            .card-footer {
                background: #ffffff
            }

            .border-dark {
                border: 1px solid #343a40 !important;
            }

            /* body {
                font-family: "Siyam Rupali", Arial, sans-serif;
                font-size: 12px;
            } */
            .no-print {
                display: none !important;
            }
            .bold{
                font-weight: 600 !important;
                font-size: 16px !important;
                line-height: 1.2 px;
            }
            td{
                padding: 3px !important;
            }
            .col-md-8{
                width: 66%;
                float: left;
            }
            .col-md-4{
                width: 33%;
                float: right;
            }
        }
    </style>
@endpush
@section('title', 'Loan View')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
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

            <!-- Main row -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="card">
                        <div class="card-header ">
                            <div class="text-center">
                                <h4 class="bold">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h4>
                                <h4 class="bold">সাধারণ শাখা</h4>
                                <h4 class="bold">জেলা প্রশাসকের কার্যালয়,</h4>
                                <h4 class="bold">ঢাকা।</h4>
                                <h4 class="text-success bold">সাধারণ রিপোর্ট</h4>
                            </div>
                        </div>

                        <!-- /.card-header -->

                        <div class="card-body table-responsive">
                            <table id="farmer_table" class="table table-bordered table-striped">
                                <tr>
                                    <td>মোট কৃষকের সংখ্যা</td>
                                    <td>মোট নারী কৃষকের সংখ্যা</td>
                                    <td>মোট পুরুষ কৃষকের সংখ্যা</td>
                                </tr>
                                <tr>
                                    <td>{{ bnValue($total_farmers) }}</td>
                                    <td>{{ bnValue($male_farmers) }}</td>
                                    <td>{{ bnValue($female_farmers) }}</td>
                                </tr>
                                <tr>
                                    <td>মোট লোনপ্রাপ্ত কৃষকের সংখ্যা</td>
                                    <td>মোট লোনপ্রাপ্ত নারী কৃষকের সংখ্যা</td>
                                    <td>মোট লোনপ্রাপ্ত পুরুষ কৃষকের সংখ্যা</td>
                                </tr>
                                <tr>
                                    <td>{{ bnValue($total_loan_received_users) }}</td>
                                    <td>{{ bnValue($total_loan_received_female_users) }}</td>
                                    <td>{{ bnValue($total_loan_received_male_users) }}</td>
                                </tr>
                                <tr>
                                    <td>মোট ব্যাংকের সংখ্যা</td>
                                    <td>মোট শাখার সংখ্যা</td>
                                    <td>মোট লোনের পরিমাণ</td>
                                </tr>
                                <tr>
                                    <td>{{ bnValue($total_banks) }}</td>
                                    <td>{{ bnValue($total_branches) }}</td>
                                    <td>{{ bnValue(currencyFormat($total_loan_amount)) }}</td>
                                </tr>
                                <tr>
                                    <td>নারী কৃষকের প্রণোদনার পরিমাণ</td>
                                    <td>পুরুষ কৃষকের প্রণোদনার পরিমাণ</td>
                                    <td>মোট প্রণোদনার পরিমাণ</td>
                                </tr>
                                <tr>
                                    <td>{{ bnValue(currencyFormat($total_subsidy_received_female_users)) }}</td>
                                    <td>{{ bnValue(currencyFormat($total_subsidy_received_male_users)) }}</td>
                                    <td>{{ bnValue(currencyFormat($total_subsidy_amount)) }}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
@push('script')
<script>

</script>
@endpush
