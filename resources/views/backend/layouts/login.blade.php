<!DOCTYPE html>
<html lang="en">
<head>
    <title>Agriloan | {{$title  ?? ''}}</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('frontend/css/jquery.mmenu.all.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/mstyle.css')}}">
    @stack('css')
    @stack('style')
</head>

<body class="login-img3-body">
    <div class="container">
        @yield('content')
    </div>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="{{ asset('frontend/js/jquery.mmenu.all.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('frontend/js/script.js') }}"></script>

    @stack('js')
    @stack('script')
</body>
</html>
