<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Digital Marketplace') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @section('header')
            @include('layouts._header')
        @show

        <div class="container">
            @include('flash::message')

            @yield('content')

            <hr>
        </div>
    </div>

    <!-- Scripts -->
    {{-- Todo: Replace fontawesome-all.js with a custom build --}}
    <script src="{{ asset('js/fontawesome-all.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
