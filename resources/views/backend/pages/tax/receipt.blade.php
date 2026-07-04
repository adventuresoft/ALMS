@extends('backend.master', ['mainMenu' => 'Tax', 'subMenu' => 'TaxList'])
@push('style')
    <style>
        @media print {

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

        }
    </style>
@endpush
@section('title', 'Tax Show')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tax Invoice</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('tax.index') }}">Tax</a></li>
                        <li class="breadcrumb-item active">Tax Invoice</li>
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
                      
                        <!-- /.card-header -->
                        <!-- form start -->

                        <div class="card-body">

                          <div class="row  text-center">
                              <div class="col-md-12 ">
                                  <img height="70" width="70" class="mx-auto d-block"
                                      src="{{ isset($tax->user->institute->top_image) ? asset($tax->user->institute->top_image)  : asset('public/backend/img/certificate/govt-bd-logo.png') }}" alt="govt-bd-logo">
                              </div>
                          </div>

                            <div class="row mt-2">
                                <div class="col-md-2 text-right">
                                    <img height="70" width="70" class="mx-auto d-block"
                                        src=" {{ isset($tax->user->institute->left_image) ? asset($tax->user->institute->left_image) : 'https://seeklogo.com/images/M/moharajpur-union-logo-6FAC2CBD46-seeklogo.com.png ' }}"
                                        alt="govt-bd-logo">
                                </div>
                                <div class="col-md-8 text-center">
                                    <h2 class="text-danger bold">{{ $tax->user->institute->union->bn_name ?? '' }}
                                    </h2>
                                    <p>
                                        ডাকঘরঃ <strong
                                            class="text-success">{{ $tax->user->institute->union->bn_name ?? '' }}</strong>,
                                        থানাঃ <strong
                                            class="text-success">{{ $tax->user->institute->union->thana->bn_name ?? '' }}</strong>,
                                        জেলাঃ <strong
                                            class="text-success">{{ $tax->user->institute->union->thana->district->bn_name ?? '' }},
                                            বাংলাদেশ</strong>
                                    </p>
                                </div>
                                <div class="col-md-2 text-left">
                                    <img height="70" width="70" class="mx-auto d-block"
                                        src="{{ isset($tax->user->institute->right_image) ? asset($tax->user->institute->right_image) : 'https://upload.wikimedia.org/wikipedia/en/thumb/a/ab/Mujib_100_Logo.svg/1200px-Mujib_100_Logo.svg.png' }} "
                                        alt="govt-bd-logo">
                                </div>
                            </div>


                            <div class="row character-tax mt-2">
                                <div class="col-md-4 text-left">
                                    <h6 class=" mt-2">নম্বর- <strong
                                            class="text-success">{{ bnValue($tax->system_id ?? '') }}</strong></h6>
                                </div>
                                <div class="col-md-4 text-center">
                                    <h3 class="text-light bg-success bold p-2">TAX INVOICE</h3>
                                    <h6 class="bold p-2">অর্থ বছর: <strong>{{$tax->taxYear->bn_name}}</strong></h6>
                                </div>
                                <div class="col-md-4 text-right">
                                    <h6 class="mt-2">তারিখঃ
                                        {{ bnValue(date('d/m/Y', strtotime($tax->created_at))) }} খ্রিঃ</h6>
                                </div>
                            </div>


                            <div>

                                <table class=" table my-2 user_info_table">
                                    <tr>
                                        <td class="bg-dark text-light"> হোল্ডিং এর মালিকের তথ্য: </strong> </td>
                                        <td> <strong> আইডি নং-{{ bnValue($tax->user->system_id ?? '') }}, নাম: {{ $tax->user->people->bn_name ?? '' }}   </strong> </td>
                                    </tr>
                                    <tr>
                                      <td class="bg-dark text-light"> হোল্ডিং সংক্রান্ত তথ্য: </strong> </td>
                                      <td> <strong> বাড়ি নং-{{ $tax->house->house_bn ?? '' }}, ওয়ার্ড নং-{{ $tax->unionWard->bn_ward_no ?? '' }}, এলাকা: {{ $tax->villageArea->bn_name ?? '' }}, গ্রাম: {{ $tax->village->bn_name ?? '' }} </strong> </td>
                                  </tr>
                                </table>

                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">ক্রমিক নং</th>
                                            <th style="width: 60%">করের বিষয়</th>
                                            <th style="width: 15%">বকেয়া কর</th>
                                            <th style="width: 15%">কর</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>১ ।</td>
                                            <td class="text-left">বসতবাড়ির বাৎসরিক মূল্যের উপর কর</td>
                                            <td class="text-right">{{ currencyFormat($tax->previous_residence_tax) }}</td>
                                            <td class="text-right">{{ currencyFormat($tax->residence_tax) }}</td>
                                        </tr>

                                        <tr>
                                            <td>২ ।</td>
                                            <td class="text-left">ব্যবসা/পেশা/জীবিকার উপর কর</td>
                                            <td class="text-right">{{ currencyFormat($tax->previous_income_tax ?? '') }}</td>
                                            <td class="text-right">{{ currencyFormat($tax->income_tax ?? '') }}</td>
                                        </tr>

                                        <tr>
                                            <td>৩ ।</td>
                                            <td class="text-left">সিনেমা/যাত্রা/থিয়েটার বা বিনোদেনমূলক অনুষ্ঠানের উপর কর
                                            </td>
                                            <td class="text-right">{{ currencyFormat($tax->previous_entertainment_institute_tax ?? '') }}
                                            </td>
                                            <td class="text-right">{{ currencyFormat($tax->entertainment_institute_tax ?? '') }}</td>
                                        </tr>

                                        <tr>
                                            <td>৪ ।</td>
                                            <td class="text-left">লাইসেন্স ও পারমিট ফিস</td>
                                            <td class="text-right">{{ currencyFormat($tax->previous_license_tax ?? '') }}</td>
                                            <td class="text-right">{{ currencyFormat($tax->license_tax ?? '') }}</td>
                                        </tr>

                                        <tr>
                                            <td>৫ ।</td>
                                            <td class="text-left">হাট-বাজার/ফেরিঘাট ও জলমহল ইজারা বাবদ ফি</td>
                                            <td class="text-right">{{ currencyFormat($tax->previous_bazar_tax ?? '') }}</td>
                                            <td class="text-right">{{ currencyFormat($tax->bazar_tax ?? '') }}</td>
                                        </tr>

                                        <tr>
                                            <td>৬ ।</td>
                                            <td class="text-left">ভূমি/ইমারত ভাড়ার উপর কর</td>
                                            <td class="text-right">{{ currencyFormat($tax->previous_land_tax ?? '') }}</td>
                                            <td class="text-right">{{ currencyFormat($tax->land_tax ?? '') }}</td>
                                        </tr>

                                        <tr>
                                            <td>৭ ।</td>
                                            <td class="text-left">নিলামে বিক্রয়লব্ধ আয়</td>
                                            <td class="text-right">{{ currencyFormat($tax->previous_auction_tax ?? '') }}</td>
                                            <td class="text-right">{{ currencyFormat($tax->auction_tax ?? '') }}</td>
                                        </tr>

                                        <tr>
                                            <td>৮ ।</td>
                                            <td class="text-left">জরিমানা (যদি থাকে)</td>
                                            <td class="text-right">{{ currencyFormat($tax->previous_fine ?? '') }}</td>
                                            <td class="text-right">{{ currencyFormat($tax->fine ?? '') }}</td>
                                        </tr>

                                        <tr>
                                            <td>৯ ।</td>
                                            <td class="text-left">অন্যান্য দাবি আদায় (যদি থাকে)</td>
                                            <td class="text-right">{{ currencyFormat($tax->previous_others ?? '') }}</td>
                                            <td class="text-right">{{ currencyFormat($tax->others ?? '') }}</td>
                                        </tr>

                                        <tr>
                                            <td>১০ ।</td>
                                            <td class="text-left">বিবিধ</td>
                                            <td class="text-right">{{ currencyFormat($tax->previous_extra ?? '') }}</td>
                                            <td class="text-right">{{ currencyFormat($tax->extra ?? '') }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2" class="text-right"><strong>মোট:</strong></td>
                                            <td class="text-right">
                                                @php
                                                    $total_previous = 0;
                                                    $total_previous = $total_previous + ($tax->previous_extra ? $tax->previous_extra : 0);
                                                    $total_previous = $total_previous + ($tax->previous_others ? $tax->previous_others : 0);
                                                    $total_previous = $total_previous + ($tax->previous_fine ? $tax->previous_fine : 0);
                                                    $total_previous = $total_previous + ($tax->previous_auction_tax ? $tax->previous_auction_tax : 0);
                                                    $total_previous = $total_previous + ($tax->previous_land_tax ? $tax->previous_land_tax : 0);
                                                    $total_previous = $total_previous + ($tax->previous_bazar_tax ? $tax->previous_bazar_tax : 0);
                                                    $total_previous = $total_previous + ($tax->previous_license_tax ? $tax->previous_license_tax : 0);
                                                    $total_previous = $total_previous + ($tax->previous_entertainment_institute_tax ? $tax->previous_entertainment_institute_tax : 0);
                                                    $total_previous = $total_previous + ($tax->previous_income_tax ? $tax->previous_income_tax : 0);
                                                    $total_previous = $total_previous + ($tax->previous_residence_tax ? $tax->previous_residence_tax : 0);
                                                @endphp
                                                <strong class="previous_total">{{ currencyFormat($total_previous) }}</strong>
                                            </td>
                                            <td class="text-right">

                                                @php
                                                    $total_current = 0;
                                                    $total_current = $total_current + ($tax->extra ? $tax->extra : 0);
                                                    $total_current = $total_current + ($tax->others ? $tax->others : 0);
                                                    $total_current = $total_current + ($tax->fine ? $tax->fine : 0);
                                                    $total_current = $total_current + ($tax->auction_tax ? $tax->auction_tax : 0);
                                                    $total_current = $total_current + ($tax->land_tax ? $tax->land_tax : 0);
                                                    $total_current = $total_current + ($tax->bazar_tax ? $tax->bazar_tax : 0);
                                                    $total_current = $total_current + ($tax->license_tax ? $tax->license_tax : 0);
                                                    $total_current = $total_current + ($tax->entertainment_institute_tax ? $tax->entertainment_institute_tax : 0);
                                                    $total_current = $total_current + ($tax->income_tax ? $tax->income_tax : 0);
                                                    $total_current = $total_current + ($tax->residence_tax ? $tax->residence_tax : 0);
                                                @endphp

                                                <strong class="current_total">{{ currencyFormat($total_current??0.00) }}</strong>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="3" class="text-right"><strong>সর্বমোট:</strong></td>
                                            <td class="text-right bg-gradient-gray"><strong
                                                    class="sum_of_total">{{ currencyFormat($total_current + $total_previous) }}</strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div>
                              <table class="table border table-borderless text-center">
                                <tr>
                                  <td>
                                    <br><br>
                                    <p>------------------------------</p>
                                    <p>লাইসেন্স ও বিজ্ঞাপন সুপার ভাইজার</p>
                                  </td>
                                  <td>
                                    <br><br>
                                    <p>------------------------------</p>
                                    <p>সীল</p>
                                  </td>
                                  <td>
                                    <br><br>
                                    <p>------------------------------</p>
                                    <p>কর কর্মকর্তা বা কর্তৃপক্ষ</p>
                                  </td>
                                </tr>
                              </table>
                            </div>
                            <div class="row">
                              <div class="col-md-12 text-right">
                                  <small>Develop & Maintenance by:<a href="https://www.jatri24.com"> Jatri 24 Ltd.</a> & <a href="https://www.adventure-soft.com"> Adventure Soft Ltd.</a></small>
                              </div>
                            </div>


                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <div class="form-group row">
                                <div class="col-sm-9">
                                    <button type="button" id="printPageButton" class="btn btn-secondary text-right"
                                        onClick="window.print();">Print</button>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-footer -->
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
@endpush
