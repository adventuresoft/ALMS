<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Agriloan | @yield('title') </title>

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/backend')}}/css/adminlte.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Splide CSS -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css"
    />

     <!-- Toastr -->
   <link rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css') }}">

    <!-- Optional: Default Theme -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/themes/splide-default.min.css"
    />

    {{-- E:\Herd\agriloan\public\frontend\style --}}
    <link rel="stylesheet" href="{{asset('assets/assets/style/global.css')}}" />

    @stack('style')

</head>
<body>
    @auth()
        <form id="logoutForm" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endauth

    <div class="font-inter overflow-x-hidden">
        @include('frontend.layouts.header')
        
        @yield('hero')
        
        <!-- Main Content Section -->
        <main class="container mx-auto max-w-screen-xl p-4">
            @yield('content')
        </main>
        @include('frontend.layouts.footer')
    </div>

    <!-- Splide JS -->
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="{{ asset('assets/js/navbar.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('public/plugins')}}/select2/js/select2.full.min.js"></script>
    <!-- Toastr -->
    <script src="{{ asset('public/plugins/toastr/toastr.min.js') }}"></script>


    <script>
      document.addEventListener("DOMContentLoaded", function () {
        new Splide("#image-carousel", {
          type: "loop",
          perPage: 1,
          gap: "1rem",
          autoplay: true,
          interval: 4000,
          pagination: true,
        }).mount();
      });
    </script>

    @stack('script')
</body>
</html>
