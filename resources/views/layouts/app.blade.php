<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Task and Inventory Management') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="header">
            <div class="navbar">
                <div class="logo">
                    <img src="{{ asset('images/Logo.png') }}" width="115px">
                </div>
                <nav>
                    <ul>
                        <li><a href="{{route('home')}}">HOME</a></li>
                        <li><a href="{{url('login')}}">LOGIN</a></li>
                        <li><a href="{{url('register')}}">REGISTER</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <main class="py-4 pb-0">
            @yield('content')
        </main>
    </div>
</body>
</html>
