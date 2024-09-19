<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Valero' }} - {{ config('app.name', 'Valero') }}</title>

    <!-- Include CSS -->
    @vite('resources/css/app.css')

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Alpine.js for interactivity -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100">
    <x-navigation />

    <!-- Main Content -->
    <main class="container mx-auto p-6">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-6">
        &copy; {{ date('Y') }} Your Valero. All Rights Reserved.
    </footer>
    
</body>
</html>
