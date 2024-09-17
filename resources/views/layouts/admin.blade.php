<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    @vite('resources/css/app.css') <!-- Make sure you include your CSS file -->
</head>
<body class="bg-gray-100">

    <!-- Admin Navigation Bar -->
    <header class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">Admin Dashboard</a>
            <nav>
                <a href="{{ route('admin.articles.index') }}" class="px-3 hover:underline">Manage Articles</a>
                <a href="{{ route('home') }}" class="px-3 hover:underline">Home</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:underline">Logout</button>
                </form>
            </nav>
        </div>
    </header>

    <!-- Main Admin Content -->
    <div class="container mx-auto mt-6">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center p-4 mt-6">
        &copy; {{ date('Y') }} Your Application. All Rights Reserved.
    </footer>
    
</body>
</html>
