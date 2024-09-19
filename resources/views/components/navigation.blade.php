<header>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white border border-gray-200 rounded-lg">
            <div class="flex items-center justify-between h-16 px-4">
                <a href="{{ route('home') }}" class="flex items-center">
                    <span class="text-xl font-bold text-gray-800">{{ config('app.name') }}</span>
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