<header class="mb-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border border-gray-200 rounded-lg">
            <div class="flex items-center justify-between h-16 px-4">
                <a href="{{ route('home') }}" class="flex items-center">
                    <!-- Icon -->
                    <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-800">{{ config('app.name') }}</span>
                </a>
                <nav class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">Home</a>
                    @auth
                        @if($isAdmin)
                            <a href="{{ route('admin.dashboard') }}" class="bg-blue-500 text-white hover:bg-blue-600 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">Admin Panel</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white hover:bg-red-600 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-green-500 text-white hover:bg-green-600 px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">Login</a>
                    @endauth
                </nav>
            </div>
        </div>
    </div>
</header>