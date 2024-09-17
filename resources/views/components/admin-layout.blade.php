<!-- resources/views/components/admin-layout.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }} - {{ config('app.name', 'Laravel') }}</title>

    <!-- Include CSS -->
    @vite('resources/css/app.css')

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Alpine.js for interactivity -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100">

    <!-- Navigation Component -->
    <header>
        <x-navigation />
    </header>

    <!-- Main Content -->
    <div class="container mx-auto mt-6">
        {{ $slot }}
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-6">
        &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All Rights Reserved.
    </footer>

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
