<div class="relative w-full h-[480px] lg:h-[calc(100vh-155px)] min-h-[460px] max-h-[640px]">
    <!-- The Slider -->
    <div class="splide h-full w-full" id="image-carousel">
        <div class="splide__track h-full w-full">
            <ul class="splide__list h-full w-full">
                <li class="splide__slide">
                    <img src="{{asset('assets/images/carousel-umage-1.jpg')}}" alt="slide 1" class="h-full w-full object-cover" />
                </li>
                <li class="splide__slide">
                    <img src="{{asset('assets/images/carousel-umage-2.jpg')}}" alt="slide 2" class="h-full w-full object-cover" />
                </li>
                <li class="splide__slide">
                    <img src="{{asset('assets/images/carousel-umage-3.jpg')}}" alt="slide 3" class="h-full w-full object-cover" />
                </li>
            </ul>
        </div>
    </div>

    <!-- The Static Overlay over the slider -->
    <div class="absolute inset-0 z-10 pointer-events-none flex justify-between items-center">
        <!-- Left Side Gradient & Text -->
        <div class="w-full lg:w-3/5 h-full bg-gradient-to-r from-[#f4fcf6] via-[#f4fcf6]/95 to-transparent flex flex-col justify-center pl-8 md:pl-16 lg:pl-24 xl:pl-32">
            <div class="pointer-events-auto max-w-2xl -mt-4">
                <h1 class="text-xl md:text-2xl lg:text-[28px] xl:text-[32px] font-extrabold text-[#006a4e] leading-[1.4] mb-3.5">
                    <span>কৃষকের উন্নয়নে আমরা আছি</span><br>
                    <span class="inline-block mt-1.5 md:mt-2 text-[#005841]">আপনার পাশে</span>
                </h1>
                <h3 class="text-gray-800 font-bold text-sm xl:text-[15px] mb-2.5">
                    Agriculture Loan Management & Monitoring System (ALMS)
                </h3>
                <p class="text-gray-700 text-xs xl:text-[13px] leading-relaxed font-medium">
                    কৃষি খাতে সহজ ঋণ প্রক্রিয়া, স্বচ্ছতা এবং দক্ষ ব্যবস্থাপনার মাধ্যমে<br>
                    কৃষকের অর্থনৈতিক উন্নয়ন নিশ্চিত করা।
                </p>
            </div>
        </div>

        <!-- Right Side: 4 Cards Stack (Overlayed on Right Corner) -->
        <div class="pointer-events-auto hidden lg:flex flex-col justify-center gap-2.5 xl:gap-3 w-[340px] xl:w-[380px] 2xl:w-[410px] pr-12 lg:pr-16 xl:pr-20 z-20">
            <!-- Card 1: Farmer Registration / Apply -->
            <a href="{{ url('/application') }}" class="group flex items-center justify-between gap-3 bg-[#006a4e]/95 hover:bg-[#005841] backdrop-blur-md p-3 xl:p-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20">
                <div class="w-9 h-9 rounded-full bg-white/15 flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0 text-left">
                    <h3 class="text-white font-bold text-[13px] xl:text-[14.5px] leading-tight mb-0.5 whitespace-nowrap">
                        কৃষক নিবন্ধন / আবেদন
                    </h3>
                    <p class="text-white/80 text-[11px] leading-tight font-normal">
                        নতুন নিবন্ধনের জন্য এখানে ক্লিক করুন
                    </p>
                </div>
                <div class="flex-shrink-0 text-white/90 group-hover:translate-x-1 transition-transform duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>

            <!-- Card 2: Official Login / Dashboard Entry -->
            @if(Auth::check())
            <a href="{{ route('dashboard') }}" class="group flex items-center justify-between gap-3 bg-gradient-to-r from-[#006a4e]/95 to-[#005841]/95 hover:from-[#005841] hover:to-[#004633] backdrop-blur-md p-3 xl:p-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20">
                <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0 text-left">
                    <h3 class="text-white font-bold text-[13px] xl:text-[14.5px] leading-tight mb-0.5 whitespace-nowrap">
                        ড্যাশবোর্ড এ প্রবেশ
                    </h3>
                    <p class="text-white/80 text-[11px] leading-tight font-normal">
                        স্বাগতম, {{ mb_substr(Auth::user()->name ?? 'ব্যবহারকারী', 0, 15) }}
                    </p>
                </div>
                <div class="flex-shrink-0 text-white/90 group-hover:translate-x-1 transition-transform duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            @else
            <a href="{{ url('/login?role=admin') }}" class="group flex items-center justify-between gap-3 bg-[#1e293b]/95 hover:bg-[#0f172a] backdrop-blur-md p-3 xl:p-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-white/20">
                <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-white flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0 text-left">
                    <h3 class="text-white font-bold text-[13px] xl:text-[14.5px] leading-tight mb-0.5 whitespace-nowrap">
                        অফিসিয়াল লগইন
                    </h3>
                    <p class="text-white/80 text-[11px] leading-tight font-normal">
                        অফিসিয়ালদের জন্য লগইন করুন
                    </p>
                </div>
                <div class="flex-shrink-0 text-white/90 group-hover:translate-x-1 transition-transform duration-300">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </a>
            @endif

            <!-- Card 3: Mission -->
            <div class="flex items-start gap-2.5 bg-white/95 hover:bg-white backdrop-blur-md p-3 xl:p-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-green-600/30">
                <div class="w-8 h-8 rounded-lg bg-[#006a4e]/10 text-[#006a4e] flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0 text-left">
                    <h3 class="text-[#006a4e] font-bold text-[13px] xl:text-[14px] leading-tight mb-1 whitespace-nowrap">
                        অভিলক্ষ্য (Mission)
                    </h3>
                    <p class="text-gray-700 text-[11px] xl:text-[11.5px] leading-snug text-left line-clamp-3">
                        একটি স্বচ্ছ, জবাবদিহিতামূলক এবং প্রযুক্তিনির্ভর প্রশাসনিক কাঠামোর গঠন করা, যেখানে প্রতিটি নাগরিক সমান অধিকার ও সুযোগ পাবে এবং উন্নয়নের সুফল সরাসরি জনগণের কাছে পৌঁছে দেওয়া নিশ্চিত করা।
                    </p>
                </div>
            </div>

            <!-- Card 4: Vision -->
            <div class="flex items-start gap-2.5 bg-white/95 hover:bg-white backdrop-blur-md p-3 xl:p-3.5 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border border-green-600/30">
                <div class="w-8 h-8 rounded-lg bg-[#006a4e]/10 text-[#006a4e] flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <div class="flex-1 min-w-0 text-left">
                    <h3 class="text-[#006a4e] font-bold text-[13px] xl:text-[14px] leading-tight mb-1 whitespace-nowrap">
                        রূপকল্প (Vision)
                    </h3>
                    <p class="text-gray-700 text-[11px] xl:text-[11.5px] leading-snug text-left line-clamp-3">
                        টেকসই, নিরাপদ ও লাভজনক কৃষি ভিত্তিক প্লাটফর্ম ব্যবহারের মাধ্যমে কৃষকদের দোরগোড়ায় সেবা পৌঁছে দেওয়া এবং স্মার্ট বাংলাদেশ বিনির্মাণে ভূমিকা রাখা।
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
