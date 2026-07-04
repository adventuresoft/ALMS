<div class="relative w-full h-[450px]">
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
            </ul>
        </div>
    </div>

    <!-- The Static Overlay over the slider -->
    <div class="absolute inset-0 z-10 pointer-events-none flex">
        <!-- Left Side Gradient & Text -->
        <div class="w-full h-full bg-gradient-to-r from-[#f4fcf6] via-[#f4fcf6] to-transparent flex flex-col justify-center pl-16 md:pl-24 lg:pl-32">
            <div class="pointer-events-auto max-w-3xl -mt-8">
                <h1 class="text-xl md:text-2xl lg:text-[28px] xl:text-[32px] whitespace-nowrap font-extrabold text-[#006a4e] mb-4">
                    কৃষকের উন্নয়নে আমরা আছি আপনার পাশে
                </h1>
                <h3 class="text-gray-800 font-bold text-[15px] mb-3">
                    Agriculture Loan Management & Monitoring System (ALMS)
                </h3>
                <p class="text-gray-700 text-[13px] leading-relaxed font-medium">
                    কৃষি খাতে সহজ ঋণ প্রক্রিয়া, স্বচ্ছতা এবং দক্ষ ব্যবস্থাপনার মাধ্যমে<br>
                    কৃষকের অর্থনৈতিক উন্নয়ন নিশ্চিত করা।
                </p>
            </div>
        </div>
    </div>


    </div>
</div>
