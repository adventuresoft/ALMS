@extends('backend.master', ['mainMenu' => 'Farmer', 'subMenu' => 'View'])
@push('style')
    <style>
        /* Print settings */
        @media print {
            @page {
                size: A4 landscape;
                margin: 5mm;
            }

            body{
                font-size: 13px;
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
                font-size: 13px !important;
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
@section('title', 'People View')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1>Farmer Information</h1>
                </div>
                <div class="col-sm-4 text-center">
                    <button id="printPageButton" class="btn btn-outline-primary btn-sm text-center" onClick="window.print();">
                        <i class="fa fa-print"></i> Print</button>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('farmer.index') }}">Farmer</a></li>
                        <li class="breadcrumb-item active">Permission</li>
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
                    <div class="card card-info">
                        {{-- <div class="card-header no-print">
                            <h3>Farmer Information</h3>
                        </div> --}}
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <h4 class="bold">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h4>
                                    <h4 class="bold">সাধারণ শাখা</h4>
                                    <h4 class="bold">জেলা প্রশাসকের কার্যালয়,</h4>
                                    <h4 class="bold">ঢাকা।</h4>
                                    <h4 class="bold">জেলায় বিতরণকৃত কৃষি ঋণ মনিটরিং কার্যক্রমের আওতায় ঋণ প্রাপ্ত  কৃষকদের তালিকা</h4>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ক্রমিক</th>
                                            <th>কৃষকের নাম ও আইডি নম্বর</th>
                                            <th>পিতার/স্বামীর নাম ও আইডি নম্বর</th>
                                            <th>মোবাইল নম্বর ও ঠিকানা</th>
                                            <th>কৃষিজমির পরিমাণ</th>
                                            <th>কৃষকের ধরন</th>
                                            <th>কৃষি, মৎস্য ও প্রাণী খামারের বিবরণ</th>
                                            <th>প্রাপ্ত কৃষি ঋণের পরিমাণ</th>
                                            <th>ব্যাংকের নাম ও শাখা</th>
                                            <th>কৃষি ঋণ প্রাপ্তির বছর ও অবস্থা</th>
                                            <th>ছবি</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $user)
                                            <tr>
                                                <td class="text-center">{{ bnValue($loop->iteration) }}</td>
                                                <td>
                                                    {{ $user->farmer->bn_name ?? '--' }}<br>
                                                    {{ bnValue($user->system_id) }}
                                                </td>
                                                <td>
                                                    {{ $user->familyInfo->father_name ?? '' }}<br>
                                                    {{ bnValue($user->familyInfo->father_nid ?? '') }}
                                                </td>
                                                <td>
                                                    {{ bnValue($user->mobile) }}<br>
                                                    {{ $user->addressInfo->permanent_area }}
                                                </td>
                                                <td>
                                                    {{farmerTypesByLandQuantity($user->cultivations()->sum('quantity'))}}
                                                </td>
                                                <td>
                                                    @php
                                                        $cultivations = [
                                                            'Crop Cultivation' => 'শস্য',
                                                            'Vegetable Cultivation' => 'সবজী'
                                                        ];
                                                        $land_owner = [
                                                            'own' => 'নিজস্ব',
                                                            'rental' => 'ভাড়া',
                                                            'lease' => 'বর্গা'
                                                        ];
                                                    @endphp
                                                    @if (count($user->cultivations))
                                                        @foreach ($user->cultivations as $cultivate)
                                                            @if ($cultivate->crop == "Crop Cultivation" || $cultivate->crop == "Vegetable Cultivation" )
                                                                {{$cultivations[$cultivate->crop] .'-'. $cultivate->quantity}} শতাংশ ({{$land_owner[$cultivate->land_owner] ?? '--'}})
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $cultivations = [
                                                            'Fish Cultivation' => 'মৎস্য',
                                                            'Poultry Farming' => 'মুরগী',
                                                            'Livestock Farming' => 'পশুপালন'
                                                        ];
                                                        $land_owner = [
                                                            'own' => 'নিজস্ব',
                                                            'rental' => 'ভাড়া',
                                                            'lease' => 'বর্গা'
                                                        ];
                                                        $is_others = 'নাই';
                                                    @endphp

                                                    @if (count($user->cultivations))
                                                        @foreach ($user->cultivations as $cultivate)
                                                            @if ($cultivate->crop == "Fish Cultivation" || $cultivate->crop == "Poultry Farming" || $cultivate->crop == "Livestock Farming" )
                                                                {{$cultivations[$cultivate->crop] .'-'. $cultivate->quantity}} শতাংশ ({{$land_owner[$cultivate->land_owner] ?? '--'}})
                                                                @php
                                                                    $is_others = '';
                                                                @endphp

                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    {{$is_others}}
                                                </td>
                                                <td>
                                                    @if (count($user->loanInfos))
                                                        @foreach ($user->loanInfos as $loanInfo)
                                                            {{bnValue($loanInfo->amount)}}
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (count($user->loanInfos))
                                                        @foreach ($user->loanInfos as $loanInfo)
                                                            {{$loanInfo->bank->bn_name ?? ''}}<br>
                                                            {{$loanInfo->branch_name ?? '' }}
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>

                                                    @if (count($user->loanInfos))
                                                        @foreach ($user->loanInfos as $loanInfo)
                                                            {{bnValue(financialYears($loanInfo->financial_year))}} <br>
                                                            {{ loanStatuses($loanInfo->status) }}
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td><img height="36" width="36" src="{{ asset(path: $user->image ? $user->image : 'public/no-image-found.jpeg') }}"></td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="11">No data available!</td></tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>

                            <div class="no-print">
                                {{$users->links()}}
                            </div>

                        </div>

                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection
