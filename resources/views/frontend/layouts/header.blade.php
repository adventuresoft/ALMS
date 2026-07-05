<style>
  header.sticky-header-container {
    position: -webkit-sticky !important;
    position: sticky !important;
    top: 0 !important;
    z-index: 999999 !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }
  .top-bar, .top-bar *, .navbar, .navbar * {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  }

  /* ── Scrolled State Styles (Like UPMS - smaller height & compact) ── */
  body.is-scrolled header.sticky-header-container {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15) !important;
  }
  body.is-scrolled .top-bar > div {
    padding-top: 4px !important;
    padding-bottom: 4px !important;
  }
  body.is-scrolled .top-bar img {
    height: 38px !important;
    width: 38px !important;
    padding: 2px !important;
  }
  body.is-scrolled .top-bar h1 {
    font-size: 16px !important;
    margin-bottom: 0 !important;
  }
  body.is-scrolled .top-bar p {
    display: none !important; /* Hide subtitle on scroll to reduce height like UPMS */
  }
  body.is-scrolled .navbar .py-1\.5,
  body.is-scrolled .navbar ul.nav-links {
    padding-top: 2px !important;
    padding-bottom: 2px !important;
  }
  body.is-scrolled .navbar a,
  body.is-scrolled .navbar button {
    padding-top: 4px !important;
    padding-bottom: 4px !important;
    font-size: 11.5px !important;
  }
  body.is-scrolled .navbar svg {
    width: 14px !important;
    height: 14px !important;
  }
  /* Override Bootstrap 3 CSS conflicts for Navbar on pages like Application/Krishok Nibondhon */
  @media (min-width: 768px) {
    nav.navbar, nav.alms-navbar {
      display: block !important;
      margin-bottom: 0 !important;
      min-height: auto !important;
      border: none !important;
      border-bottom: 1px solid #f3f4f6 !important;
      border-radius: 0 !important;
    }
  }
  @media (max-width: 767.98px) {
    nav.navbar.hidden, nav.alms-navbar.hidden {
      display: none !important;
    }
  }
</style>
<header class="sticky-header-container top-0 z-50 w-full shadow-md bg-white">
<!-- top bar -->
<div class="top-bar" style="background-color: #005c36;">
    <div class="w-full max-w-[1920px] mx-auto pl-8 md:pl-16 lg:pl-24 xl:pl-32 pr-12 lg:pr-16 xl:pr-20 py-2">
        <div class="flex flex-row justify-between items-center">
            <!-- Left side Logo & Text -->
            <div class="flex flex-row items-center gap-3">
                <a href="{{url('/')}}">
                  <img src="{{asset('public/backend/img/certificate/govt-bd-logo.png')}}" class="h-[52px] w-[52px] object-contain bg-white rounded-full p-1" alt="govt-logo" />
                </a>
                <div class="text-white text-left">
                    <a href="{{url('/')}}" class="text-white hover:text-white">
                        <h1 class="text-lg md:text-[22px] font-bold tracking-wide leading-tight">
                            Agriculture Loan Management & Monitoring System
                        </h1>
                    </a>
                    <p class="text-sm md:text-[16px] font-medium text-green-100 mt-1 tracking-normal">General Section, Dhaka</p>
                </div>
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
<nav class="navbar alms-navbar md:!block hidden bg-white shadow-sm border-b border-gray-100" style="margin-bottom: 0 !important; min-height: 0 !important; border-radius: 0 !important; border-top: none !important; border-left: none !important; border-right: none !important;">
    <div class="w-full max-w-[1920px] mx-auto pl-8 md:pl-16 lg:pl-24 xl:pl-32 pr-12 lg:pr-16 xl:pr-20 flex justify-between items-center">
        <!-- Left: Navigation Links -->
        <ul class="nav-links flex items-center justify-start gap-1 lg:gap-2 xl:gap-3 py-1.5 text-sm flex-shrink-0">
            <li>
                <a href="{{ url('/') }}" class="flex items-center gap-1.5 font-bold transition-colors bg-green-50 text-green-800 px-3 py-1.5 rounded-md whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    হোম 
                </a>
            </li>
        </ul>

        <!-- Right: Login Buttons / User Profile -->
        <div class="flex items-center gap-2 xl:gap-3 flex-shrink-0">
            @if(Auth::check())
                <div class="relative inline-block text-left" id="userDropdownContainer">
                    <button type="button" onclick="document.getElementById('userDropdownMenu').classList.toggle('hidden')" class="flex items-center gap-2 px-3 py-1.5 bg-[#006a4e] text-white font-bold rounded-lg shadow hover:bg-[#005841] transition text-xs xl:text-sm">
                        <span class="w-6 h-6 rounded-full bg-white/20 flex items-center justify-center font-bold text-white text-xs">
                            {{ mb_substr(Auth::user()->name ?? 'U', 0, 1) }}
                        </span>
                        <span>{{ Auth::user()->name ?? 'প্রোফাইল' }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="userDropdownMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-2 border border-gray-100 z-50 text-gray-800">
                        <div class="px-4 py-2 border-b border-gray-100 text-xs text-gray-500">
                            লগইন স্ট্যাটাস: <span class="font-bold text-green-600">সক্রিয়</span>
                        </div>
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-green-50 text-gray-700 hover:text-green-700 font-medium">
                            <i class="fas fa-tachometer-alt text-green-600 w-4"></i> ড্যাশবোর্ড
                        </a>
                        <a href="{{ route('profile') }}" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-green-50 text-gray-700 hover:text-green-700 font-medium">
                            <i class="fas fa-user text-green-600 w-4"></i> প্রোফাইল
                        </a>
                        <hr class="my-1 border-gray-100">
                        <a href="#" onclick="event.preventDefault(); logoutUser();" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-red-50 text-red-600 font-medium">
                            <i class="fas fa-sign-out-alt text-red-600 w-4"></i> লগআউট
                        </a>
                    </div>
                </div>
                <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @else
                <a href="{{ url('/login?role=krishok') }}" class="flex items-center gap-1 xl:gap-2 px-3 py-1.5 border border-green-600 text-green-700 font-bold rounded hover:bg-green-50 transition text-xs whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    কৃষক লগইন
                </a>
                <a href="{{ url('/login?role=admin') }}" class="flex items-center gap-1 xl:gap-2 px-3 py-1.5 border border-blue-600 text-blue-700 font-bold rounded hover:bg-blue-50 transition text-xs whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    অ্যাডমিন লগইন
                </a>
                <a href="{{ url('/login?role=banker') }}" class="flex items-center gap-1 xl:gap-2 px-3 py-1.5 border border-purple-600 text-purple-700 font-bold rounded hover:bg-purple-50 transition text-xs whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                    ব্যাংকার লগইন
                </a>
            @endif
        </div>
    </div>
</nav>
</header>

<!-- Mobile Navbar -->
<nav class="navbar md:hidden bg-white shadow-md relative">
    <div id="mobile-menu"
        class="fixed top-0 left-0 h-full w-72 bg-white text-gray-900 transform -translate-x-full transition-transform duration-300 ease-in-out z-50 shadow-lg">
        <div class="p-4 space-y-2">
            <!-- Mobile Nav Links -->
            <a href="{{ url('/') }}" class="block px-4 py-2 hover:bg-gray-100 rounded text-green-700 bg-green-50 font-bold">হোম</a>
            <hr class="my-2 border-gray-200">
            @if(Auth::check())
                <div class="p-3 bg-green-50 rounded-lg mb-2">
                    <div class="font-bold text-gray-800 text-sm">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-green-700 font-medium mt-0.5">লগইন করা হয়েছে</div>
                </div>
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-100 rounded text-green-700 font-bold">ড্যাশবোর্ড</a>
                <a href="{{ route('profile') }}" class="block px-4 py-2 hover:bg-gray-100 rounded text-blue-700 font-bold">প্রোফাইল</a>
                <a href="#" onclick="event.preventDefault(); logoutUser();" class="block px-4 py-2 hover:bg-gray-100 rounded text-red-600 font-bold">লগআউট</a>
            @else
                <a href="{{ url('/login?role=krishok') }}" class="block px-4 py-2 text-green-700 font-bold">কৃষক লগইন</a>
                <a href="{{ url('/login?role=admin') }}" class="block px-4 py-2 text-blue-700 font-bold">অ্যাডমিন লগইন</a>
                <a href="{{ url('/login?role=banker') }}" class="block px-4 py-2 text-purple-700 font-bold">ব্যাংকার লগইন</a>
            @endif
        </div>
    </div>
</nav>

@push('script')
    <script>
        function logoutUser() {
            $("#logoutForm").submit();
        }
        document.addEventListener('click', function(e) {
            const container = document.getElementById('userDropdownContainer');
            const menu = document.getElementById('userDropdownMenu');
            if (container && menu && !container.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        // Sticky Header Shrink on Scroll (Like UPMS)
        function handleStickyHeaderScroll() {
            if (window.scrollY > 50) {
                if (!document.body.classList.contains("is-scrolled")) {
                    document.body.classList.add("is-scrolled");
                }
            } else {
                if (document.body.classList.contains("is-scrolled")) {
                    document.body.classList.remove("is-scrolled");
                }
            }
        }
        window.addEventListener("scroll", handleStickyHeaderScroll, { passive: true });
        handleStickyHeaderScroll();
    </script>
@endpush
