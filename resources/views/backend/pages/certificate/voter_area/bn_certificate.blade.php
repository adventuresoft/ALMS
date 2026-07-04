@extends('backend.master', ['mainMenu' => 'Certificate', 'subMenu' =>'VoterArea'])
@push('style')
<style>
    @media print {
        
            #printPageButton {
                display: none;
            }
            .bg-success{
                background: #28a745!important;
                color: #fff;
            }
           

            footer{
                display: none;
            }
            .content-wrapper, .container, .card, .card-footer{
                background: #ffffff
            }

            .border-dark{
                border: 1px solid #343a40!important;
            }
            
        }
</style>
@endpush
@section('title', 'Voter Area Certificate')
@section('content')
<div class="container">
  <div class="card mt-2">
      <div class="card-body border border-dark ">
          <div class="border border-5 border-info p-5">
              <div class="row  text-center">
                  <div class="col-md-12 ">
                      <img height="100" width="100" class="mx-auto d-block"
                          src="{{ isset($certificate->user->institute->top_image) ? asset($certificate->user->institute->top_image)  : asset('public/backend/img/certificate/govt-bd-logo.png') }}" alt="govt-bd-logo">
                  </div>
              </div>
              <div class="row mt-2">
                  <div class="col-md-2 text-right">
                      <img height="100" width="100" class="mx-auto d-block"
                          src=" {{isset($certificate->user->institute->left_image) ? asset($certificate->user->institute->left_image)  : 'https://seeklogo.com/images/M/moharajpur-union-logo-6FAC2CBD46-seeklogo.com.png '}}"
                          alt="govt-bd-logo">
                  </div>
                  <div class="col-md-8 text-center">
                      <h1 class="text-danger bold">{{ $certificate->user->institute->union->bn_name ?? '' }} ইউনিয়ন পরিষদ
                      </h1>
                      <p>
                        ডাকঘরঃ <strong class="text-success">{{ $certificate->user->institute->union->bn_name ?? '' }}</strong>,
                        থানাঃ <strong class="text-success">{{ $certificate->user->institute->union->thana->bn_name ?? '' }}</strong>,
                        জেলাঃ <strong class="text-success">{{ $certificate->user->institute->union->thana->district->bn_name ?? '' }}, বাংলাদেশ</strong>
                    </p>
                  </div>
                  <div class="col-md-2 text-left">
                      <img height="100" width="100" class="mx-auto d-block"
                          src="{{isset($certificate->user->institute->right_image) ? asset($certificate->user->institute->right_image)  : 'https://upload.wikimedia.org/wikipedia/en/thumb/a/ab/Mujib_100_Logo.svg/1200px-Mujib_100_Logo.svg.png'}} "
                          alt="govt-bd-logo">
                  </div>
              </div>
              <div class="row character-certificate mt-2">
                  <div class="col-md-3 text-left">
                    <h6 class="mt-2">নম্বর- <strong class="text-success">{{ bnValue($certificate->system_id ?? '') }}</strong></h6>
                </div>
                  <div class="col-md-6 text-center">
                      <h3 class="text-light bg-success bold p-2">ভোটার এলাকার পরিবর্তনের সনদ</h3>
                  </div>
                  <div class="col-md-3 text-right">
                    <h6 class="mt-2">তারিখঃ {{ bnValue(date('d/m/Y', strtotime($certificate->created_at))) }} খ্রিঃ</h6>
                </div>
              </div>
              <div class="row mt-5">

                  <div class="col-md-12 certificate-body">        
                    <p> 
                        এই মর্মে প্রত্যয়ন করা যাচ্ছে যে, {{isset($certificate->user->people->gender) ? ($certificate->user->people->gender == 1 ? 'জনাব' : 'জনাবা') : '' }}  <strong class="text-success">{{ $certificate->user->people->bn_name ?? '' }}</strong>, 
                        আইডি নং <strong class="text-success"> {{ bnValue($certificate->user->system_id ?? '') }}</strong> 
                        পিতাঃ <strong class="text-info">{{isset($certificate->user->people->father_live_status) ? ($certificate->user->people->father_live_status == 2 ? 'মৃত' : "") : ''}} {{ $certificate->user->familyInfo->father_name_bn ?? '' }}</strong> 
                        এবং মাতাঃ <strong class="text-info">{{isset($certificate->user->people->mother_live_status) ? ($certificate->user->people->mother_live_status ==2 ? 'মৃত' : "") : ''}} {{ $certificate->user->familyInfo->mother_name_bn ?? '' }}</strong>, 
                        
                        স্থায়ী ঠিকানাঃ 
                        গ্রাম - <strong class="text-info">{{$certificate->user->addressInfo->permanentVillage->bn_name ?? '' }}</strong>, 
                        ওয়ার্ড- <strong class="text-info">{{ $certificate->user->addressInfo->permanentWard->bn_ward_no ?? '' }}</strong>, 
                        এলাকা- <strong class="text-info">{{ $certificate->user->addressInfo->permanentArea->bn_name ?? '' }}</strong>, 
                        রাস্তা- <strong class="text-info">{{ $certificate->user->addressInfo->permanentRoad->bn_name ?? '' }}</strong>, 
                        বাড়ি- <strong class="text-info">{{ $certificate->user->addressInfo->permanentHouse->house_bn ?? '' }}</strong>, 
                        
                        বর্তমান ঠিকানাঃ 
                        গ্রাম- <strong class="text-info">{{$certificate->user->addressInfo->presentVillage->bn_name ?? '' }}</strong>, 
                        ওয়ার্ড- <strong class="text-info">{{ $certificate->user->addressInfo->presentWard->bn_ward_no ?? '' }}</strong>, 
                        এলাকা- <strong class="text-info">{{ $certificate->user->addressInfo->presentArea->bn_name ?? '' }}</strong>, 
                        রাস্তা- <strong class="text-info">{{ $certificate->user->addressInfo->presentRoad->bn_name ?? '' }}</strong>, 
                        বাড়ি- <strong class="text-info">{{ $certificate->user->addressInfo->presentHouse->house_bn ?? '' }}</strong>, 
                        ফ্ল্যাট- <strong class="text-info">{{ bnValue($certificate->user->addressInfo->present_flat ?? '') }}</strong> 
                        অত্র ইউনিয়নের বাসিন্দা। জন্মসূত্রে তিনি বাংলাদেশের নাগরিক। ব্যক্তিগতভাবে আমি তাকি চিনি। 
                        আমার জানা মতে তিনি কোন অসামাজিক ও রাষ্ট্র বিরোধী কোন কাজে জড়িত নন। তাঁর স্বভাব চরিত্র ভালো। 
                    </p>
                    <br>
                    <p>আমি তার সার্বিক কল্যাণ ও মঙ্গলময় উন্নত জীবন কামনা করি।</p>
                    <br>
                    <p class="text-right"> চেয়ারম্যান </p> 
                    <p>NB.: Any Query <a href="https://www.upbd.com" target="_blank">www.upbd.com</a></p>

                  </div>
              </div>
          </div>


      </div>

      <div style="padding:12px">
          <p>This report generated by Jatri 24 Ltd. <a href="https://www.jatri24.com">www.jatri24.com</a></p>
          <button id="printPageButton" class="btn btn-outline-secondary btn-sm text-right" onClick="window.print();">Print</button>
      </div>
  </div>
</div>
@endsection
@push('script')
@endpush
