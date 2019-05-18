<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- FontAwsome -->
    <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
        window.App = {!! json_encode([
            'user' => Auth::user(),
            'signedIn' => Auth::check()
        ]) !!}
    </script>
    <style>
        body { padding-bottom:100px }
        .level { display: flex; align-items: center; }
        .flex { flex: 1; }
        .mr-1 { margin-right: 1rem }
        [v-cloak] { display: none }
    </style>
</head>
<body>
    <div id="app">
        
        @include('layouts.nav')

        <main class="py-4">
            @yield('content')
        </main>

        <flash-component message="{{ session('flash') }}"></flash-component>
    </div>
</body>
</html>
