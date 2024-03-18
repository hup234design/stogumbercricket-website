<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased font-sans">

@if ( cms('site_active', true) )
    <x-header-layout />
    @section('heading')
    @show
    <main class="mt-16">
        {{ $slot }}
    </main>
    <x-footer-layout />
@else
    <div class="h-screen w-full flex flex-col items-center justify-start p-8">
        <img src="{{ url('/images/logo.png') }}" class="w-96 mx-auto">
        <div class="prose prose-sm max-w-none text-center">
            <h1 class="text-brand uppercase">Stogumber Cricket Club</h1>
            <p class="lead font-bold uppercase">New Website Under Construction</p>
        </div>
    </div>
@endif


@livewireScripts

</body>
</html>
