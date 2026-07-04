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
                font-family: "Nikosh", Arial, sans-serif;
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
<div class="card-body">
    <div class="row">
        <div class="col-md-12 text-center">
            <h6 class="bold">গণপ্রজাতন্ত্রী বাংলাদেশ সরকর</h6>
            <h6 class="bold">সাধারণ শাখা</h6>
            <h6 class="bold">জেলা প্রশাসকের কার্যালয়,</h6>
            <h6 class="bold">ঢাকা।</h4>
            <h6 class="text-success bold">কৃষকের প্রোফাইল</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <table class="table table-borderless text-left">
                <thead>
                    <tr>
                        <th colspan="3">ব্যক্তিগত তথ্য</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td  style="width: 230px">আইডি নম্বর</td>
                        <td>:</td>
                        <td>{{ bnValue($user->system_id) }}</td>
                    </tr>
                    <tr>
                        <td>কৃষকের নাম</td>
                        <td>:</td>
                        <td>{{ $user->farmer->bn_name ?? '--' }}</td>
                    </tr>
                    <tr>
                        <td>কৃষকের নাম (ইংরেজি)</td>
                        <td>:</td>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <td>এনআইডি</td>
                        <td>:</td>
                        <td>{{ bnValue($user->system_id) }}</td>
                    </tr>
                    <tr>
                        <td>মোবাইল নম্বর</td>
                        <td>:</td>
                        <td>{{ bnValue($user->mobile) }}</td>
                    </tr>
                    <tr>
                        <td>জন্ম তারিখ</td>
                        <td>:</td>
                        <td>{{ bnValue($user->farmer->date_of_birth ?? '--') }}</td>
                    </tr>
                    <tr>
                        <td>লিঙ্গ</td>
                        <td>:</td>
                        <td>
                            {{ gender_show('bn', $user->farmer->gender ?? '') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <img style="aspect-ratio: 9 / 11;"
                                src="{{ asset(path: $user->image ? $user->image : 'public/no-image-found.jpeg') }}"
                                class="img-thumbnail" alt="farmer.jpg">
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <table class="table table-borderless text-left">
                <thead>
                    <tr>
                        <th colspan="3">পারিবারিক তথ্য</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 230px">পিতার নাম</td>
                        <td>:</td>
                        <td>{{ $user->familyInfo->father_name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>পিতার এনআইডি</td>
                        <td>:</td>
                        <td>{{ bnValue($user->familyInfo->father_nid ?? '') }}</td>
                    </tr>
                    <tr>
                        <td>মাতার নাম</td>
                        <td>:</td>
                        <td>{{ $user->familyInfo->mother_name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td>মাতার এনআইডি</td>
                        <td>:</td>
                        <td>{{ bnValue($user->familyInfo->mother_nid ?? '') }}</td>
                    </tr>
                    <tr>
                        <td>স্পাউসের নাম</td>
                        <td>:</td>
                        <td>
                            @php
                                $spouse = (isset($user->familyInfo->spouse) && !is_null($user->familyInfo->spouse)) ? json_decode($user->familyInfo->spouse, true) : [];

                            @endphp
                            {{ $spouse['name'] ?? '' }}
                        </td>
                    </tr>
                    {{-- <tr>
                                                <td>স্পাউসের এনআইডি</td>
                                                <td>:</td>
                                                <td>{{ bnValue($user->familyInfo->spouse_nid ?? '') }}</td>
                                            </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <table class="table table-borderless text-left">
                <thead>
                    <tr>
                        <th colspan="3">যোগাযোগের তথ্য</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="width: 230px">বর্তমান ঠিকানা</td>
                        <td>:</td>
                        <td>{{ $user->addressInfo->present_area }}</td>
                    </tr>
                    <tr>
                        <td>স্থায়ী ঠিকানা</td>
                        <td>:</td>
                        <td>{{ $user->addressInfo->permanent_area }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-borderless text-left">
                <thead>
                    <tr>
                        <th colspan="9">জমির তথ্য</th>
                    </tr>
                    <tr>
                        <th>ক্রমিক নং</th>
                        <th>জমির ধরন</th>
                        <th>বিভাগ</th>
                        <th>জেলা</th>
                        <th>থানা</th>
                        <th>মৌজা</th>
                        <th>দাগ নং</th>
                        <th>খতিয়ান নং</th>
                        <th>জমির পরিমাণ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($user->lands as $landKey=>$land)
                        <tr>
                            <td class="sl land-sl">{{ bnValue(++$landKey) }}</td>
                            <td>{{$land->land_type ?? ''}}</td>
                            <td>{{$land->division ?? ''}}</td>
                            <td>{{$land->district ?? ''}}</td>
                            <td>{{$land->thana ?? ''}}</td>
                            <td>{{$land->mouza ?? ''}}</td>
                            <td>{{$land->dag_no ?? ''}}</td>
                            <td>{{$land->khatiyan_no ?? ''}}</td>
                            <td>{{$land->land_quantity ?? ''}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">কোন তথ্য পাওয়া যায়নি!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if (!isset($_GET['id']))
        <div class="row">
            <div class="col-md-12">
                <table class="table table">
                    <thead>
                        <tr>
                            <th colspan="4">ঋণের তথ্য</th>
                        </tr>
                        <tr>
                            <th>ব্যাংকের নাম ও শাখা</th>
                            <th>অর্থবছর</th>
                            <th>ঋণের পরিমাণ</th>
                            <th>ঋণের অবস্থা</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($user->loanInfos))
                            @foreach ($user->loanInfos as $loanInfo)
                                <tr>
                                    <td>{{ $loanInfo->bank->bn_name ?? '' }}, {{ $loanInfo->branch->bn_name ?? '' }}</td>
                                    <td>{{ bnValue(financialYears($loanInfo->financial_year)) }} </td>
                                    <td>{{ bnValue(currencyFormat($loanInfo->amount)) }}</td>
                                    <td>{{ loanStatuses($loanInfo->status) }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
