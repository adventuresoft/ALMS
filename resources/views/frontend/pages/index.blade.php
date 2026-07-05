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
    <div class="max-w-screen-xl mx-auto mt-6 mb-16 lg:m-0">
        <!-- Section 1: 4 Cards Row (Farmer Reg, Official Login, Mission, Vision - Hidden on Desktop as it is in Hero) -->
        <section class="lg:hidden grid grid-cols-1 md:grid-cols-2 gap-4 mb-10 items-stretch">
            <!-- Card 1: Farmer Registration / Apply -->
            <a href="{{ url('/application') }}" class="group flex items-center justify-between gap-2.5 xl:gap-3 bg-[#006a4e] hover:bg-[#005841] p-4 xl:p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-[#005a40] h-full">
                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0 text-left">
                    <h3 class="text-white font-bold text-[13px] xl:text-[15px] leading-tight mb-1 whitespace-nowrap">
                        কৃষক নিবন্ধন / আবেদন
                    </h3>
                    <p class="text-white/80 text-xs leading-normal font-normal">
                        নতুন নিবন্ধনের জন্য এখানে ক্লিক করুন
                    </p>
                </div>
                <div class="flex-shrink-0 text-white/90 group-hover:translate-x-1 transition-transform duration-300">
                    <svg class="w-4 h-4 xl:w-5 xl:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>

            <!-- Card 2: Official Login / Dashboard Entry -->
            @if(Auth::check())
            <a href="{{ route('dashboard') }}" class="group flex items-center justify-between gap-2.5 xl:gap-3 bg-gradient-to-r from-[#006a4e] to-[#005841] hover:from-[#005841] hover:to-[#004633] p-4 xl:p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-[#004d39] h-full">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0 text-left">
                    <h3 class="text-white font-bold text-[13px] xl:text-[15px] leading-tight mb-1 whitespace-nowrap">
                        ড্যাশবোর্ড এ প্রবেশ
                    </h3>
                    <p class="text-white/80 text-xs leading-normal font-normal">
                        স্বাগতম, {{ mb_substr(Auth::user()->name ?? 'ব্যবহারকারী', 0, 15) }}
                    </p>
                </div>
                <div class="flex-shrink-0 text-white/90 group-hover:translate-x-1 transition-transform duration-300">
                    <svg class="w-4 h-4 xl:w-5 xl:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            @else
            <a href="{{ url('/login?role=admin') }}" class="group flex items-center justify-between gap-2.5 xl:gap-3 bg-[#1e293b] hover:bg-[#0f172a] p-4 xl:p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-[#151c28] h-full">
                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0 text-left">
                    <h3 class="text-white font-bold text-[13px] xl:text-[15px] leading-tight mb-1 whitespace-nowrap">
                        অফিসিয়াল লগইন
                    </h3>
                    <p class="text-white/80 text-xs leading-normal font-normal">
                        অফিসিয়ালদের জন্য লগইন করুন
                    </p>
                </div>
                <div class="flex-shrink-0 text-white/90 group-hover:translate-x-1 transition-transform duration-300">
                    <svg class="w-4 h-4 xl:w-5 xl:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            @endif

            <!-- Card 3: Mission -->
            <div class="flex items-start gap-3 bg-[#f4fbf7] hover:bg-[#ebf7f1] p-4 xl:p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-green-200/80 h-full">
                <div class="w-10 h-10 rounded-lg bg-[#006a4e]/10 text-[#006a4e] flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0 text-left">
                    <h3 class="text-[#006a4e] font-bold text-[13px] xl:text-[15px] leading-tight mb-1 whitespace-nowrap">
                        অভিলক্ষ্য (Mission)
                    </h3>
                    <p class="text-gray-600 text-xs xl:text-[13px] leading-relaxed text-left">
                        একটি স্বচ্ছ, জবাবদিহিতামূলক এবং প্রযুক্তিনির্ভর প্রশাসনিক কাঠামোর গঠন করা, যেখানে প্রতিটি নাগরিক সমান অধিকার ও সুযোগ পাবে এবং উন্নয়নের সুফল সরাসরি জনগণের কাছে পৌঁছে দেওয়া নিশ্চিত করা।
                    </p>
                </div>
            </div>

            <!-- Card 4: Vision -->
            <div class="flex items-start gap-3 bg-[#f4fbf7] hover:bg-[#ebf7f1] p-4 xl:p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-green-200/80 h-full">
                <div class="w-10 h-10 rounded-lg bg-[#006a4e]/10 text-[#006a4e] flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0 text-left">
                    <h3 class="text-[#006a4e] font-bold text-[13px] xl:text-[15px] leading-tight mb-1 whitespace-nowrap">
                        রূপকল্প (Vision)
                    </h3>
                    <p class="text-gray-600 text-xs xl:text-[13px] leading-relaxed text-left">
                        টেকসই, নিরাপদ ও লাভজনক কৃষি ভিত্তিক প্লাটফর্ম ব্যবহারের মাধ্যমে কৃষকদের দোরগোড়ায় সেবা পৌঁছে দেওয়া এবং স্মার্ট বাংলাদেশ বিনির্মাণে ভূমিকা রাখা।
                    </p>
                </div>
            </div>
        </section>
    </div>
@endsection
