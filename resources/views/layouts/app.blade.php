<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }} - {{ config('app.name', 'Valero') }}</title>

    <!-- Include CSS -->
    @vite('resources/css/app.css')

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Alpine.js for interactivity -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="bg-gray-100">

    <!-- Navigation Bar -->
    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold">Valero Blog</a>
            <nav>
                <a href="{{ route('home') }}" class="px-3 hover:underline">Home</a>
                @auth
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="px-3 hover:underline">Admin Panel</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:underline">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-3 hover:underline">Login</a>
                @endauth
            </nav>
        </div>
    </header>

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
