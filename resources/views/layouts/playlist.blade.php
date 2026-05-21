<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{ $seo ?? '' }}

    @if(config('app_googlesearchmeta'))
    <meta name="google-site-verification" content="{{ config('app_googlesearchmeta') }}">
    @endif

    <!-- Vite Assets -->
    @vite(['resources/js/valero-frontend.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-background text-text" x-data="{ scrolled: false }"
    @scroll.window="scrolled = (window.pageYOffset > 20)">
    <x-navigation />

    <!-- Main Content -->
    <main class="container mx-auto">
        <div class="container mx-auto px-4 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-3 space-y-8">
                {{ $slot }}
            </div>
            <!-- Sidebar -->
            <x-sidebar.sidebar :popularArticles="$popularArticles" :categories="$categories" />
        </div>
    </main>

    <x-footer />
    <x-scroll-top />

    @livewireScripts
</body>

</html>