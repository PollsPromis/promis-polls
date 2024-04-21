<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @stack('styles')
    </style>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>
<body>
    <div class="wrapper">
        @include('partials.header')

        @yield('content')

        @include('partials.footer')
    </div>
<script src="{{ asset('assets/js/main.js') }}"></script>

</body>
</html>
