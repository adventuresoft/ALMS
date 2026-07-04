@extends('frontend.master')
@section('title', 'Agri Loan Monitoring')
@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
@endpush
@section('content')

    <div class="grid grid-cols-1 md:grid-cols-12 gap-1">
        <div class="md:col-span-8 col-span-1">
            @include('frontend.layouts.slider')

            <div class="border border-green-600 overflow-hidden relative bg-white mt-1">
                <div
                    class="absolute left-0 top-0 h-full flex items-center px-3 bg-green-600 text-white text-sm font-semibold z-10">
                    নোটিশ
                </div>
                <div class="whitespace-nowrap animate-marquee text-green-700 pl-24 py-2 text-sm font-semibold">
                    এই সাইটটি নির্মাণাধীন আছে। শীঘ্রই সকল সেবা চালু হবে। ধন্যবাদ।
                </div>
            </div>

            <section class="border border-green-600 overflow-hidden relative bg-white mt-1">
                <div class="max-w-4xl mx-auto text-start p-4">
                    <div class="mt-8">
                        <h3 class="text-2xl md:text-xl font-semibold text-green-700 mb-3">
                            অভিলক্ষ্য
                        </h3>
                        <p class="text-gray-700 text-sm leading-relaxed">
                            একটি স্বচ্ছ, জবাবদিহিমূলক এবং প্রযুক্তি-নির্ভর প্রশাসনিক
                            কাঠামো গঠন করা, যেখানে প্রতিটি নাগরিক সমান অধিকার ও সুযোগ ভোগ
                            করবে এবং উন্নয়নের সুফল সরাসরি জনগণের কাছে পৌঁছে যাবে।
                        </p>
                    </div>

                    <!-- Mission -->
                    <div class="mt-8">
                        <h3 class="text-2xl md:text-xl font-semibold text-green-700 mb-3">
                            রুপকল্প
                        </h3>
                        <p class="text-gray-700 text-sm leading-relaxed">
                            টেকসই, নিরাপদ ও লাভজনক কৃষি।
                        </p>
                    </div>
                </div>
            </section>

            @if (false)
            <section class="overflow-hidden relative bg-white mt-2">
                <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Card 1 -->
                    <div class="border border-black bg-white shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            আমাদের সম্পর্কে
                        </h3>
                        <div class="flex items-start gap-3">
                            <!-- Icon -->
                            <div class="text-green-600">
                                <!-- demo icon (replace with your own image or SVG) -->
                                <img class="h-12 w-12" src="{{asset('assets/images/about.png')}}" alt="about" >
                            </div>
                            <!-- Links -->
                            <ul class="text-blue-700 space-y-2">
                                <li>
                                    <a href="#" class="hover:underline">ভিশন ও মিশন</a>
                                </li>
                                <li>
                                    <a href="#" class="hover:underline">সাংগঠনিক কাঠামো </a>
                                </li>
                                <li>
                                    <a href="#" class="hover:underline">কর্মকর্তাবৃন্দ</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="border border-black bg-white shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            তথ্য অধিকার
                        </h3>
                        <div class="flex items-start gap-3">
                            <!-- Icon -->
                            <div class="text-purple-600">
                                <!-- demo icon (replace with your own image or SVG) -->
                                <img class="h-12 w-12" src="{{asset('assets/images/settings.png')}}" alt="about">
                            </div>
                            <!-- Links -->
                            <ul class="text-blue-700 space-y-2">
                                <li><a href="#" class="hover:underline">নীতিমালা</a></li>
                                <li>
                                    <a href="#" class="hover:underline">আইন ও বিধি</a>
                                </li>
                                <li>
                                    <a href="#" class="hover:underline">আবেদনের নিয়মাবলী</a>
                                </li>
                                <li>
                                    <a href="#" class="hover:underline">অভিযোগ ও মতামত</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            @endif
        </div>

        <div class="md:col-span-4 col-span-1">
            <div>
                <div class="text-center text-white bg-green-700 py-2">
                    <p>মাননীয় জেলা প্রশাসক</p>
                </div>

                <div class="grid grid-cols-2 gap-1 p-1">
                    <div>
                        <img src="{{asset('assets/images/dc.png')}}" class="w-60 h-full object-cover" alt="advisor" />
                    </div>

                    <div class="flex flex-col justify-center">
                        <h2 class="text-start text-md font-semibold mt-2">
                            মো: রেজাউল করিম 
                        </h2>
                        <p class="text-start">জেলা প্রশাসক</p>
                        <p class="text-start text-xs">ঢাকা</p>
                    </div>
                </div>
            </div>

            <div class="mt-1">
                <div class="text-center text-white bg-green-700 py-2">
                    <p>অতিরিক্ত জেলা প্রশাসক (সার্বিক)</p>
                </div>

                <div class="grid grid-cols-2 gap-1 p-1">
                    <div>
                        <img src="{{asset('assets/images/adc.png')}}" class="w-60 h-full object-cover"
                            alt="chairman" />
                    </div>

                    <div class="flex flex-col justify-center">
                        <h2 class="text-start text-md font-semibold mt-2">
                            মোঃ আব্দুল ওয়ারেছ আনসারী
                        </h2>
                        <p class="text-start">অতিরিক্ত জেলা প্রশাসক (সার্বিক)</p>
                        <p class="text-start text-xs">ঢাকা</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <script src="{{ asset('public/frontend/js/jquery.counterup.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.slider').bxSlider({
                mode: 'fade',
                responsive: true,
                infiniteLoop: true,
                auto: true,
                speed: 1000
            });
            $('.counter').counterUp({
                delay: 10,
                time: 1000
            });
        });
    </script>
@endpush
