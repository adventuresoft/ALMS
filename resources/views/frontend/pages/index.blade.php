@extends('frontend.master')
@section('title', 'Agri Loan Monitoring')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
    <style>
        .splide__arrow {
            background: white !important;
            opacity: 1 !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            width: 3rem !important;
            height: 3rem !important;
            z-index: 30 !important;
        }
        .splide__arrow svg {
            fill: #333 !important;
        }
        .splide__arrow--prev {
            left: 1.5rem !important;
        }
        .splide__arrow--next {
            right: 1.5rem !important;
        }
        .splide__pagination {
            bottom: 3rem !important;
            justify-content: flex-start !important;
            padding-left: 6rem !important;
            z-index: 20 !important;
        }
        @media (min-width: 768px) {
            .splide__pagination { padding-left: 8rem !important; }
        }
        .splide__pagination__page {
            background: #cbd5e1 !important;
            width: 10px !important;
            height: 10px !important;
            margin: 3px 6px !important;
        }
        .splide__pagination__page.is-active {
            background: #006a4e !important;
            transform: scale(1.2) !important;
        }
    </style>
@endpush

@section('hero')
    <!-- Full Width Slider -->
    <div class="w-full relative">
        @include('frontend.layouts.slider')
    </div>
@endsection

@section('content')
    <div class="max-w-screen-xl mx-auto mt-4 mb-12">
        <div class="border border-green-600 overflow-hidden relative bg-white">
            <div
                class="absolute left-0 top-0 h-full flex items-center px-3 bg-green-600 text-white text-sm font-semibold z-10">
                নোটিশ
            </div>
            <div class="whitespace-nowrap animate-marquee text-green-700 pl-24 py-2 text-sm font-semibold">
                এই সাইটটি নির্মাণাধীন আছে। শীঘ্রই সকল সেবা চালু হবে। ধন্যবাদ।
            </div>
        </div>

        <!-- Mission & Vision Cards -->
        <section class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="border border-green-600 bg-green-50 p-6 rounded-lg shadow-sm hover:shadow-md transition">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <h3 class="text-lg font-bold text-green-800">অভিলক্ষ্য (Mission)</h3>
                </div>
                <p class="text-gray-700 text-[13px] leading-relaxed text-justify">
                    একটি স্বচ্ছ, জবাবদিহিমূলক এবং প্রযুক্তি-নির্ভর প্রশাসনিক কাঠামো গঠন করা, যেখানে প্রতিটি নাগরিক সমান অধিকার ও সুযোগ ভোগ করবে এবং উন্নয়নের সুফল সরাসরি জনগণের কাছে পৌঁছে যাবে।
                </p>
            </div>
            
            <div class="border border-green-600 bg-green-50 p-6 rounded-lg shadow-sm hover:shadow-md transition">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <h3 class="text-lg font-bold text-green-800">রুপকল্প (Vision)</h3>
                </div>
                <p class="text-gray-700 text-[13px] leading-relaxed text-justify">
                    টেকসই, নিরাপদ ও লাভজনক কৃষি। ডিজিটাল প্ল্যাটফর্ম ব্যবহারের মাধ্যমে কৃষকদের দোরগোড়ায় সেবা পৌঁছে দেওয়া এবং স্মার্ট বাংলাদেশ বিনির্মাণে ভূমিকা রাখা।
                </p>
            </div>
        </section>
        
        <!-- 4 Action Cards Row -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6 mb-12">
            <!-- Farmer Reg/Apply -->
            <div class="border border-green-600 bg-white p-5 rounded shadow-sm text-center flex flex-col items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="w-10 h-10 mx-auto bg-green-100 text-green-700 rounded-full flex items-center justify-center mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <h3 class="text-[15px] font-bold text-gray-800 mb-1">কৃষক নিবন্ধন</h3>
                    <p class="text-[12px] text-gray-500 mb-4">কৃষি ঋণের জন্য আবেদন করতে নিবন্ধন করুন</p>
                </div>
                <a href="{{ url('/application') }}" class="w-full bg-green-600 text-white py-1.5 rounded font-bold hover:bg-green-700 transition text-[13px]">
                    আবেদন করুন
                </a>
            </div>

            <!-- Notice -->
            <div class="border border-blue-600 bg-white p-5 rounded shadow-sm text-center flex flex-col items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="w-10 h-10 mx-auto bg-blue-100 text-blue-700 rounded-full flex items-center justify-center mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h3 class="text-[15px] font-bold text-gray-800 mb-1">নোটিশ বোর্ড</h3>
                    <p class="text-[12px] text-gray-500 mb-4">সর্বশেষ আপডেট ও নির্দেশিকা জানুন</p>
                </div>
                <a href="#" class="w-full border border-blue-600 text-blue-700 py-1.5 rounded font-bold hover:bg-blue-50 transition text-[13px]">
                    বিস্তারিত
                </a>
            </div>

            <!-- Rules -->
            <div class="border border-purple-600 bg-white p-5 rounded shadow-sm text-center flex flex-col items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="w-10 h-10 mx-auto bg-purple-100 text-purple-700 rounded-full flex items-center justify-center mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-[15px] font-bold text-gray-800 mb-1">আবেদনের নিয়ম</h3>
                    <p class="text-[12px] text-gray-500 mb-4">কীভাবে আবেদন করতে হবে তার বিস্তারিত নিয়মাবলী</p>
                </div>
                <a href="#" class="w-full border border-purple-600 text-purple-700 py-1.5 rounded font-bold hover:bg-purple-50 transition text-[13px]">
                    দেখুন
                </a>
            </div>

            <!-- Login -->
            <div class="border border-orange-600 bg-white p-5 rounded shadow-sm text-center flex flex-col items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="w-10 h-10 mx-auto bg-orange-100 text-orange-700 rounded-full flex items-center justify-center mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                    </div>
                    <h3 class="text-[15px] font-bold text-gray-800 mb-1">সিস্টেম লগইন</h3>
                    <p class="text-[12px] text-gray-500 mb-4">কর্মকর্তা ও ব্যাংক প্রতিনিধি প্যানেল</p>
                </div>
                <a href="{{ url('/login') }}" class="w-full bg-orange-600 text-white py-1.5 rounded font-bold hover:bg-orange-700 transition text-[13px]">
                    লগইন করুন
                </a>
            </div>
        </div>
    </div>
@endsection
