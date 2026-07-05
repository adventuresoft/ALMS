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

<body class="login-img3-body" style="margin: 0 !important; padding: 0 !important; background-color: #f3f4f6 !important; width: 100%; overflow-x: hidden;">
    <div style="width: 100%; min-height: 100vh; background-color: #f3f4f6 !important;">
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
