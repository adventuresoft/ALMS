 <!-- top bar -->
 <div class="top-bar bg-green-700">
     <div class="container mx-auto md:px-4 px-2 max-w-screen-xl">
         <div class="flex flex-col md:flex-row justify-between items-center">
             <div class="w-full flex justify-end md:hidden">
                 <button id="mobile-menu-btn" class="md:hidden p-2 text-black" aria-label="Open mobile menu"
                     title="Open mobile menu">
                     <!-- Hamburger Icon -->
                     <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                         viewBox="0 0 24 24" stroke="white">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M4 6h16M4 12h16M4 18h16" />
                     </svg>

                     <!-- Close Icon -->
                     <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 hidden" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                             d="M6 18L18 6M6 6l12 12" />
                     </svg>
                 </button>
             </div>
             <div class="flex flex-col md:flex-row items-center gap-10">
                <a href="{{url('/')}}">
                  <img src="{{asset('assets/images/logo/govt-bd-logo.png')}}" class="govt-logo" alt="govt-logo" />
                </a>
                 <div class="text-white text-left md:text-left">
                    <a href="{{url('/')}}">
                        <h1 class="md:text-[25px] font-semibold">
                            Agriculture Loan Management & Monitoring System
                        </h1>
                     </a>
                     <p>General Section, Dhaka</p>
                 </div>
             </div>

             <ul class="space-y-2 text-center md:space-y-0 mt-2 md:mt-0 md:gap-6">
                 <li>
                     <a href="{{ url('/') }}/login" class="text-white text-lg"> System login </a>
                 </li>
                 <li>
                     <a href="{{ url('/') }}/application"
                         class="block px-2 text-center bg-gradient-to-r from-green-400 to-green-500 text-red font-bold py-1 rounded shadow hover:from-green-300 hover:to-green-400">
                         আবেদন করুন
                     </a>
                 </li>
             </ul>
         </div>
     </div>
 </div>
 <!-- Navigation -->
 <nav class="navbar md:block hidden bg-gray-100 shadow-md">
     <div class="container mx-auto max-w-screen-xl px-6">
         <!-- Navigation Links -->
         <ul class="nav-links flex items-center justify-start gap-8 py-3">
             <li><a href="{{ url('/') }}" class="font-semibold transition-colors">হোম </a></li>
             <li><a href="#" class="font-semibold transition-colors">আমাদের সম্পর্কে</a></li>
             <li><a href="#" class="font-semibold transition-colors">নোটিশ</a></li>
             <li><a href="#" class="font-semibold transition-colors">অন্যান্য</a></li>
             <li><a href="#" class="font-semibold transition-colors">ছবির গ্যালারী</a></li>
             <!--<li><a href="{{ url('/application') }}">আবেদন করুন</a></li>-->
         </ul>
     </div>
 </nav>

 <!-- Mobile Navbar -->
 <nav class="navbar md:hidden bg-white shadow-md relative">
     <div id="mobile-menu"
         class="fixed top-0 left-0 h-full w-72 bg-white text-gray-900 transform -translate-x-full transition-transform duration-300 ease-in-out z-50 shadow-lg">
         <div class="p-4 space-y-2">
             <!-- Mobile Nav Links -->
             <a href="{{ url('/') }}" class="block px-1 py-1 hover:bg-gray-100 rounded">
                 হোম
             </a>
             <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded">
                 আমাদের সম্পর্কে
             </a>
             <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded">
                 ইউনিয়ন আইন
             </a>
             <a href="{{ url('/') }}/allproject" class="block px-4 py-2 hover:bg-gray-100 rounded">
                 প্রকল্প
             </a>
             <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded">
                 নোটিশ
             </a>

             <!-- Dropdown: অন্যান্য -->
             <details class="px-2">
                 <summary
                     class="flex justify-between items-center px-2 py-2 cursor-pointer bg-gray-100 rounded hover:bg-gray-200">
                     অন্যান্য
                     <svg viewBox="0 0 20 20" fill="currentColor"
                         class="w-5 h-5 text-gray-500 transition-transform duration-200">
                         <path fill-rule="evenodd" clip-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10
              11.94l3.72-3.72a.75.75 0 1 1
              1.06 1.06l-4.25 4.25a.75.75 0
              0 1-1.06 0L5.22 9.28a.75.75
              0 0 1 0-1.06Z" />
                     </svg>
                 </summary>
                 <div class="mt-2 ml-4 space-y-1">
                     <a href="#" class="block px-2 py-1 text-sm hover:bg-gray-100 rounded">
                         আবেদনের নিয়ম
                     </a>
                     <a href="#" class="block px-2 py-1 text-sm hover:bg-gray-100 rounded">
                         সনদ প্রাপ্তির নিয়ম
                     </a>
                 </div>
             </details>

             <a href="#" class="block px-4 py-2 hover:bg-gray-100 rounded">
                 ছবির গ্যালারী
             </a>
         </div>
     </div>
 </nav>

 @push('script')
     <script>
         function logoutUser() {
             $("#logoutForm").submit();
         }
     </script>
 @endpush
