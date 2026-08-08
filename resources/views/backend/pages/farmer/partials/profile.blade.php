@push('style')
    <style>
        .profile-container {
            max-width: 900px;
            background: #fff;
            padding: 35px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            margin: 20px auto;
        }

        .profile-pill {
            background-color: #f1f3f4;
            border-radius: 8px;
            padding: 8px 16px;
            margin-bottom: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            border: 1px solid #e0e0e0;
        }
        .profile-pill .label {
            min-width: 150px;
            font-weight: bold;
            color: #5f6368;
        }
        .profile-pill .value {
            font-weight: bold;
            color: #202124;
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

        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 8px 4px !important;
            font-size: 13px;
            vertical-align: middle;
        }
        .info-table tr {
            border-bottom: 1px dotted #dcdcdc;
        }
        .info-table tr:last-child {
            border-bottom: none;
        }
        .info-label {
            font-weight: 600;
            color: #333;
            width: 45%;
        }
        .info-value {
            color: #444;
            font-weight: 500;
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
            .profile-container {
                max-width: 100% !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            /* force background colors when printing */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .section-header-green {
                background-color: #0e6a38 !important;
                color: #fff !important;
            }
            .profile-pill {
                background-color: #f1f3f4 !important;
                border: 1px solid #e0e0e0 !important;
            }
        }
    </style>
@endpush

<div class="card-body">
    <div class="profile-container mx-auto">
        
        <!-- Header -->
        <div class="row align-items-center mb-3">
            <div class="col-md-2 col-2 text-right">
                <img height="90" width="90" class="mx-auto d-block"
                     src="{{ asset('backend/img/certificate/union.png') }}" 
                     alt="Union Parishad Logo" 
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
            <h3 class="bold mb-1" style="color: #0e6a38; font-family: 'Nikosh', 'Arial', sans-serif; font-size: 26px; font-weight: bold;">কৃষক তথ্য বিবরণী</h3>
            <h5 style="color: #555; font-family: 'Arial', sans-serif; font-weight: normal; margin-top: -2px;">Farmer Information Record</h5>
        </div>
        
        <!-- Photo and Pill fields -->
        <div class="row align-items-stretch mb-4">
            <div class="col-md-4 text-center d-flex align-items-center justify-content-center">
                <div style="border: 2px solid #0e6a38; border-radius: 8px; padding: 6px; background-color: #fff; width: 100%; max-width: 180px; aspect-ratio: 1/1.2; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                    <img src="{{ asset($user->image ? $user->image : 'public/assets/images/person-avatar.png') }}" 
                         alt="Farmer Photo" 
                         style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px;">
                </div>
            </div>
            
            <div class="col-md-8 d-flex flex-column justify-content-center">
                <div class="profile-pill">
                    <span class="label">Name :</span>
                    <span class="value">{{ $user->name }}</span>
                </div>
                <div class="profile-pill">
                    <span class="label">Name (Bangla) :</span>
                    <span class="value">{{ $user->farmer->bn_name ?? '--' }}</span>
                </div>
                <div class="profile-pill">
                    <span class="label">Reg. People ID :</span>
                    <span class="value">{{ $user->system_id }}</span>
                </div>
                <div class="profile-pill">
                    <span class="label">NID :</span>
                    <span class="value">{{ $user->nid ?? '--' }}</span>
                </div>
                <div class="profile-pill">
                    <span class="label">Mobile :</span>
                    <span class="value">{{ $user->mobile ?? '--' }}</span>
                </div>
            </div>
        </div>
        
        <!-- Personal Information Section -->
        <div class="section-header-green">
            ব্যক্তিগত তথ্য / Personal Information
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table info-table table-borderless">
                    <tbody>
                        <tr>
                            <td class="info-label">Name (English) :</td>
                            <td class="info-value">{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">NID No. :</td>
                            <td class="info-value">{{ $user->nid ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Blood Group :</td>
                            <td class="info-value">{{ $user->farmer->blood_group ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Date of Birth :</td>
                            <td class="info-value">{{ $user->farmer->date_of_birth ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Birth Place :</td>
                            <td class="info-value">{{ $user->farmer->birth_place ?? '--' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table info-table table-borderless">
                    <tbody>
                        <tr>
                            <td class="info-label">Name (Bangla) :</td>
                            <td class="info-value">{{ $user->farmer->bn_name ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Birth Reg. No. :</td>
                            <td class="info-value">{{ $user->birth_certificate ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Gender :</td>
                            <td class="info-value">{{ gender_show('en', $user->farmer->gender ?? 3) }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Religion :</td>
                            <td class="info-value">{{ $user->farmer->religion->name ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Email :</td>
                            <td class="info-value">{{ $user->email ?? '--' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Family Information Section -->
        <div class="section-header-green">
            পারিবারিক তথ্য / Family Information
        </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table info-table table-borderless">
                    <tbody>
                        <tr>
                            <td class="info-label">Father's Name :</td>
                            <td class="info-value">{{ $user->familyInfo->father_name ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Father's NID :</td>
                            <td class="info-value">{{ $user->familyInfo->father_nid ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Father's Live Status :</td>
                            <td class="info-value">{{ family_constant_option('live_status')[$user->familyInfo->father_live_status ?? 0] ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Marital Status :</td>
                            <td class="info-value">{{ family_constant_option('marital_status')[$user->familyInfo->marital_status ?? 0] ?? '--' }}</td>
                        </tr>
                        @php
                            $spouse = (isset($user->familyInfo->spouse) && !is_null($user->familyInfo->spouse)) ? json_decode($user->familyInfo->spouse, true) : [];
                        @endphp
                        @if(isset($user->familyInfo->marital_status) && $user->familyInfo->marital_status == 2)
                            <tr>
                                <td class="info-label">Spouse Name :</td>
                                <td class="info-value">{{ $user->familyInfo->spouse_name ?? ($spouse['name'] ?? '--') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table info-table table-borderless">
                    <tbody>
                        <tr>
                            <td class="info-label">Mother's Name :</td>
                            <td class="info-value">{{ $user->familyInfo->mother_name ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Mother's NID :</td>
                            <td class="info-value">{{ $user->familyInfo->mother_nid ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Mother's Live Status :</td>
                            <td class="info-value">{{ family_constant_option('live_status')[$user->familyInfo->mother_live_status ?? 0] ?? '--' }}</td>
                        </tr>
                        @if(isset($user->familyInfo->marital_status) && $user->familyInfo->marital_status == 2)
                            <tr>
                                <td class="info-label">Married Date :</td>
                                <td class="info-value">{{ $user->familyInfo->married_date ?? '--' }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Spouse NID :</td>
                                <td class="info-value">{{ $user->familyInfo->spouse_nid ?? ($spouse['nid'] ?? '--') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Children Details -->
        @php
            $children = (isset($user->familyInfo->children) && !is_null($user->familyInfo->children)) ? json_decode($user->familyInfo->children, true) : [];
        @endphp
        @if(isset($user->familyInfo->have_children) && $user->familyInfo->have_children == 1 && !empty($children))
            <div class="row mt-3">
                <div class="col-md-12">
                    <h5 class="bold mb-2 pb-1" style="border-bottom: 2px solid #0e6a38; color: #0e6a38; font-size: 14px; font-weight: bold;">সন্তানদের তথ্য / Children Information</h5>
                    <table class="table table-bordered text-left" style="font-size: 13px;">
                        <thead style="background-color: #f5f5f5; color: #333;">
                            <tr>
                                <th style="width: 80px;">ক্রমিক নং</th>
                                <th>সন্তানের নাম / Child's Name</th>
                                <th>পেশা / Profession</th>
                                <th>জন্ম তারিখ / Date of Birth</th>
                                <th>এনআইডি বা জন্ম নিবন্ধন নং / NID or Birth Reg. No.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $childSl = 0; @endphp
                            @foreach($children as $child)
                                <tr>
                                    <td class="sl">{{ bnValue(++$childSl) }}</td>
                                    <td>{{ $child['name'] ?? '--' }}</td>
                                    <td>{{ $child['profession'] ?? '--' }}</td>
                                    <td>{{ isset($child['date']) && $child['date'] ? date('d-m-Y', strtotime($child['date'])) : '--' }}</td>
                                    <td>{{ $child['id'] ?? '--' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        
        <!-- Address Information Section -->
        <div class="section-header-green">
            ঠিকানার তথ্য / Address Information
        </div>
        <div class="row">
            <!-- Permanent Address -->
            <div class="col-md-6">
                <h5 class="bold mb-2 pb-1" style="border-bottom: 2px solid #0e6a38; color: #0e6a38; font-size: 14px; font-weight: bold;">স্থায়ী ঠিকানা / Permanent Address</h5>
                <table class="table info-table table-borderless">
                    <tbody>
                        <tr>
                            <td class="info-label">District :</td>
                            <td class="info-value">{{ $user->addressInfo->permanentDistrict->name ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Thana :</td>
                            <td class="info-value">{{ $user->addressInfo->permanentThana->name ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Union :</td>
                            <td class="info-value">{{ $user->addressInfo->permanentUnion->name ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Post Office :</td>
                            <td class="info-value">
                                @php
                                    $permUnionName = $user->addressInfo->permanentUnion->name ?? '';
                                    $permPostOffice = (strpos(strtolower($permUnionName), 'suktail') !== false) ? 'Barfa' : $permUnionName;
                                @endphp
                                {{ $permPostOffice ?: '--' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label">Address :</td>
                            <td class="info-value">{{ $user->addressInfo->permanent_area ?? '--' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Present Address -->
            <div class="col-md-6">
                <h5 class="bold mb-2 pb-1" style="border-bottom: 2px solid #0e6a38; color: #0e6a38; font-size: 14px; font-weight: bold;">বর্তমান ঠিকানা / Present Address</h5>
                <table class="table info-table table-borderless">
                    <tbody>
                        <tr>
                            <td class="info-label">District :</td>
                            <td class="info-value">{{ $user->addressInfo->presentDistrict->name ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Thana :</td>
                            <td class="info-value">{{ $user->addressInfo->presentThana->name ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Union :</td>
                            <td class="info-value">{{ $user->addressInfo->presentUnion->name ?? '--' }}</td>
                        </tr>
                        <tr>
                            <td class="info-label">Post Office :</td>
                            <td class="info-value">
                                @php
                                    $presUnionName = $user->addressInfo->presentUnion->name ?? '';
                                    $presPostOffice = (strpos(strtolower($presUnionName), 'suktail') !== false) ? 'Barfa' : $presUnionName;
                                @endphp
                                {{ $presPostOffice ?: '--' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="info-label">Address :</td>
                            <td class="info-value">{{ $user->addressInfo->present_area ?? '--' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cultivation & Agriculture Card Information -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="section-header-green">চাষাবাদ ও কৃষি কার্ডের তথ্য / Cultivation & Agriculture Card Info</div>
                
                <!-- Agriculture Card Details -->
                <div class="card card-outline card-success mb-3 no-print" style="border-radius: 8px; border-top: 3px solid #0e6a38; background-color: #fcfcfc;">
                    <div class="card-body py-3 px-4">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <span class="font-weight-bold text-muted mr-2" style="font-size: 13px;">কৃষি কার্ড আছে কি না? / Has Agriculture Card? :</span>
                                <span class="font-weight-bold text-dark" style="font-size: 14px;">
                                    {{ isset($user->farmer->is_agriculture_card) ? ($user->farmer->is_agriculture_card == 1 ? 'হ্যাঁ / Yes' : 'না / No') : '--' }}
                                </span>
                            </div>
                            @if(isset($user->farmer->is_agriculture_card) && $user->farmer->is_agriculture_card == 1)
                                <div class="col-md-6 col-6">
                                    <span class="font-weight-bold text-muted mr-2" style="font-size: 13px;">কৃষি কার্ড নম্বর / Agriculture Card No. :</span>
                                    <span class="font-weight-bold text-dark" style="font-size: 14px; letter-spacing: 0.5px;">
                                        {{ $user->farmer->agriculture_card_number ?? '--' }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Cultivated Crops Table -->
                <table class="table table-bordered text-left" style="font-size: 13px;">
                    <thead style="background-color: #f5f5f5; color: #333;">
                        <tr>
                            <th style="width: 80px;">ক্রমিক নং</th>
                            <th>ফসল / Crop Name</th>
                            <th>জমির মালিকানা / Land Ownership</th>
                            <th>জমির পরিমাণ / Land Quantity</th>
                            <th>ঠিকানা / Location Address</th>
                            <th>বিবরণ / Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user->cultivations as $cultKey => $cultivation)
                            <tr>
                                <td class="sl">{{ bnValue(++$cultKey) }}</td>
                                <td>{{ $cultivation->crop }}</td>
                                <td>{{ $cultivation->land_owner === 'own' ? 'নিজের / Own' : 'লীজ / Leased' }}</td>
                                <td>{{ $cultivation->quantity }}</td>
                                <td>{{ $cultivation->address ?: '--' }}</td>
                                <td>{{ $cultivation->description ?: '--' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">কোন তথ্য পাওয়া যায়নি! / No records found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Land Information -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="section-header-green">জমির তথ্য / Land Information</div>
                <table class="table table-bordered text-left" style="font-size: 13px;">
                    <thead style="background-color: #f5f5f5; color: #333;">
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
                                <td colspan="9" class="text-center text-muted">কোন তথ্য পাওয়া যায়নি!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Loan Information (if id parameter is not set) -->
        @if (!isset($_GET['id']))
            <div class="row mt-4 no-print">
                <div class="col-md-12">
                    <div class="section-header-green">ঋণের তথ্য / Loan Information</div>
                    <table class="table table-bordered" style="font-size: 13px;">
                        <thead style="background-color: #f5f5f5; color: #333;">
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
                                        <td>{{ $loanInfo->bank->bn_name ?? '' }}, {{ $loanInfo->branch_name ?? '' }}</td>
                                        <td>{{ bnValue(financialYears($loanInfo->financial_year)) }} </td>
                                        <td>{{ bnValue(currencyFormat($loanInfo->amount)) }}</td>
                                        <td>{{ loanStatuses($loanInfo->status) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center text-muted">কোন তথ্য পাওয়া যায়নি!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div>
</div>
