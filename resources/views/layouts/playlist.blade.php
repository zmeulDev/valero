<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{ $seo ?? '' }}

    <!-- Vite Assets -->
    @vite(['resources/js/valero-frontend.js'])
    @livewireStyles

    <link rel="icon" href="{{ asset('storage/brand/favicon.ico') }}">
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100"
    x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
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