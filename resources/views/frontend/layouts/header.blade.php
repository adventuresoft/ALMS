<!-- top bar -->
<style>
    .abedon-btn {
        border: 1px solid white;
        color: white;
        transition: all 0.3s ease;
    }
    .abedon-btn:hover {
        background-color: white !important;
        color: #005c36 !important;
    }
</style>
<div class="top-bar" style="background-color: #005c36;">
    <div class="w-full max-w-[1920px] mx-auto px-4 md:px-8 lg:px-12 py-2">
        <div class="flex flex-row justify-between items-center">
            <!-- Left side Logo & Text -->
            <div class="flex flex-row items-center gap-3">
                <a href="{{url('/')}}">
                  <img src="{{asset('assets/images/logo/govt-bd-logo.png')}}" class="h-[52px] w-[52px] object-contain bg-white rounded-full p-1" alt="govt-logo" />
                </a>
                <div class="text-white text-left">
                    <a href="{{url('/')}}" class="text-white hover:text-white">
                        <h1 class="text-lg md:text-[22px] font-semibold tracking-wide leading-tight">
                            Agriculture Loan Management & Monitoring System
                        </h1>
                    </a>
                    <p class="text-xs md:text-[13px] text-gray-200 mt-0.5">General Section, Dhaka</p>
                </div>
            </div>
            
            <!-- Right side Application Button -->
            <div class="hidden md:flex">
                <a href="{{ url('/application') }}" class="abedon-btn px-4 py-2 rounded font-bold text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    আবেদন করুন
                </a>
            </div>

            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-btn" class="md:hidden p-2 text-white" aria-label="Open mobile menu">
                <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>

<!-- Navigation -->
<nav class="navbar md:block hidden bg-white shadow-sm border-b border-gray-100">
    <div class="w-full max-w-[1920px] mx-auto px-4 md:px-8 lg:px-12 flex justify-between items-center">
        <!-- Left: Navigation Links -->
        <ul class="nav-links flex items-center justify-start gap-2 xl:gap-4 py-1.5 text-sm flex-shrink-0">
            <li>
                <a href="{{ url('/') }}" class="flex items-center gap-1.5 font-bold transition-colors bg-green-50 text-green-800 px-3 py-1.5 rounded-md whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    হোম 
                </a>
            </li>
        </ul>

        <!-- Right: Login Buttons -->
        <div class="flex items-center gap-2 xl:gap-3 flex-shrink-0">
            <a href="{{ url('/login?role=krishok') }}" class="flex items-center gap-1 xl:gap-2 px-3 py-1.5 border border-green-600 text-green-700 font-bold rounded hover:bg-green-50 transition text-xs whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                কৃষক লগইন
            </a>
            <a href="{{ url('/login?role=admin') }}" class="flex items-center gap-1 xl:gap-2 px-3 py-1.5 border border-blue-600 text-blue-700 font-bold rounded hover:bg-blue-50 transition text-xs whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                অ্যাডমিন লগইন
            </a>
            <a href="{{ url('/login?role=banker') }}" class="flex items-center gap-1 xl:gap-2 px-3 py-1.5 border border-purple-600 text-purple-700 font-bold rounded hover:bg-purple-50 transition text-xs whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                ব্যাংকার লগইন
            </a>
        </div>
    </div>
</nav>

<!-- Mobile Navbar -->
<nav class="navbar md:hidden bg-white shadow-md relative">
    <div id="mobile-menu"
        class="fixed top-0 left-0 h-full w-72 bg-white text-gray-900 transform -translate-x-full transition-transform duration-300 ease-in-out z-50 shadow-lg">
        <div class="p-4 space-y-2">
            <!-- Mobile Nav Links -->
            <a href="{{ url('/') }}" class="block px-4 py-2 hover:bg-gray-100 rounded text-green-700 bg-green-50 font-bold">হোম</a>
            <hr class="my-2 border-gray-200">
            <a href="{{ url('/login?role=krishok') }}" class="block px-4 py-2 text-green-700 font-bold">কৃষক লগইন</a>
            <a href="{{ url('/login?role=admin') }}" class="block px-4 py-2 text-blue-700 font-bold">অ্যাডমিন লগইন</a>
            <a href="{{ url('/login?role=banker') }}" class="block px-4 py-2 text-purple-700 font-bold">ব্যাংকার লগইন</a>
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
