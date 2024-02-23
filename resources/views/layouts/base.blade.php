<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @hasSection('title')

            <title>@yield('title') - {{ config('app.name') }}</title>
        @else
            <title>ფასები | Prices</title>
        @endif

        <meta name="description" content="შეადარეთ 1000-ზე მეტი პროდუქტი სუპერმარკეტებსა და მაღაზიებში." />
        <meta name="keywords" content="" />

        <meta name="author" content="dealense" />
        <meta name="application-name" content="ურიკა | Trolley" />

        <!-- For Facebook -->
        <meta property="og:title" content="Trolley" />
        <meta property="og:type" content="product" />
        <meta property="og:image" content="{{ Vite::asset('resources/imgs/Trolley.png') }}" />
        <meta property="og:url" content="urika.ge" />
        <meta property="og:description" content="შეადარეთ 1000-ზე მეტი პროდუქტი სუპერმარკეტებსა და მაღაზიებში." />

        <!-- For Twitter -->
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content="Trolley" />
        <meta name="twitter:description" content="შეადარეთ 1000-ზე მეტი პროდუქტი სუპერმარკეტებსა და მაღაზიებში." />
        <meta name="twitter:image" content="{{ Vite::asset('resources/imgs/Trolley.png') }}" />

        <!-- Favicon -->
		<link rel="shortcut icon" href="{{ Vite::asset('resources/imgs/logo.ico') }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        @livewireStyles
        @livewireScripts

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>
        @yield('body')
    </body>
</html>
