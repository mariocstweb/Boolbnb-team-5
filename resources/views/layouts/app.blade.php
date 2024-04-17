<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name' , 'BoolBnb') }} | @yield('title')</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
    {{-- STYLE BODY --}}
    <style>
        body{
            visibility: hidden;
        }
    </style>

    @yield('cdns')
</head>

<body>
    <div id="app">
        {{-- Navbar --}}
        @include('includes.layouts.navbar')

        <main class="container">
            @yield('content')
        </main>
    </div>
    @yield('scripts')
</body>

</html>
