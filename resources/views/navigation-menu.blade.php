<!-- resources/views/navigation-menu.blade.php -->

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- Dashboard Link -->
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <!-- Categories Dropdown -->
                    @auth
                    <div x-data="{ categoriesOpen: false }" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link @click="categoriesOpen = ! categoriesOpen" type="button"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none transition">
                            {{ __('Categories') }}
                            <svg class="ms-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 11.586l3.293-4.293a1 1 0 011.414 1.414L10 14.414l-5.707-7.121a1 1 0 011.414-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </x-nav-link>
                        <!-- Dropdown Menu -->
                        <div x-show="categoriesOpen" @click.away="categoriesOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute z-50 mt-2 w-48 rounded-md shadow-lg">
                            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                                <!-- Option to View All Categories -->
                                <x-dropdown-link href="{{ route('categories.index') }}">
                                    {{ __('View All Categories') }}
                                </x-dropdown-link>
                                <!-- Option to Create New Category -->
                                <x-dropdown-link href="{{ route('categories.create') }}">
                                    {{ __('Create New Category') }}
                                </x-dropdown-link>
                                <div class="border-t border-gray-100"></div>
                                <!-- List of Categories -->
                                @foreach($categories as $category)
                                <x-dropdown-link href="{{ route('categories.show', $category->slug) }}">
                                    {{ $category->name }}
                                </x-dropdown-link>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Posts Dropdown -->
                    <div x-data="{ postsOpen: false }" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link @click="postsOpen = ! postsOpen" type="button"
                            class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 focus:outline-none transition">
                            {{ __('Posts') }}
                            <svg class="ms-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 11.586l3.293-4.293a1 1 0 011.414 1.414L10 14.414l-5.707-7.121a1 1 0 011.414-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </x-nav-link>
                        <!-- Dropdown Menu -->
                        <div x-show="postsOpen" @click.away="postsOpen = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute z-50 mt-2 w-48 rounded-md shadow-lg max-h-64 overflow-auto">
                            <div class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white">
                                <!-- Option to View All Posts -->
                                <x-dropdown-link href="{{ route('posts.index') }}">
                                    {{ __('View All Posts') }}
                                </x-dropdown-link>
                                <!-- Option to Create New Post -->
                                <x-dropdown-link href="{{ route('posts.create') }}">
                                    {{ __('Create New Post') }}
                                </x-dropdown-link>
                                <div class="border-t border-gray-100"></div>
                                <!-- List of Posts -->
                                @foreach($posts as $post)
                                <x-dropdown-link href="{{ route('posts.show', $post->slug) }}">
                                    {{ $post->title }}
                                </x-dropdown-link>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </div>

            <!-- Right Side of Navbar -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="ms-3 relative">
                    <!-- Existing Teams Dropdown Code -->
                    <!-- ... Keep your existing Teams Dropdown code here ... -->
                    <x-dropdown align="right" width="60">
                        <x-slot name="trigger">
                            <!-- ... -->
                        </x-slot>

                        <x-slot name="content">
                            <!-- ... Existing Team Management content ... -->
                        </x-slot>
                    </x-dropdown>
                </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <!-- Existing Settings Dropdown Code -->
                    <!-- ... Keep your existing Settings Dropdown code here ... -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <!-- ... -->
                        </x-slot>

                        <x-slot name="content">
                            <!-- ... Existing Account Management content ... -->
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Dashboard Link -->
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @auth
            <!-- Categories Dropdown -->
            <div x-data="{ categoriesOpen: false }" class="relative">
                <button @click="categoriesOpen = ! categoriesOpen" type="button"
                    class="w-full flex items-center px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-100 focus:outline-none transition">
                    {{ __('Categories') }}
                    <svg class="ms-auto h-5 w-5" :class="{ 'transform rotate-180': categoriesOpen }" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 12.586l3.293-4.293a1 1 0 011.414 1.414L10 15.414l-6.707-7.121a1 1 0 011.414-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <!-- Dropdown Menu -->
                <div x-show="categoriesOpen" @click.away="categoriesOpen = false" class="space-y-1">
                    <!-- Option to View All Categories -->
                    <x-responsive-nav-link href="{{ route('categories.index') }}">
                        {{ __('View All Categories') }}
                    </x-responsive-nav-link>
                    <!-- Option to Create New Category -->
                    <x-responsive-nav-link href="{{ route('categories.create') }}">
                        {{ __('Create New Category') }}
                    </x-responsive-nav-link>
                    <div class="border-t border-gray-100"></div>
                    <!-- List of Categories -->
                    @foreach($categories as $category)
                    <x-responsive-nav-link href="{{ route('categories.show', $category->slug) }}">
                        {{ $category->name }}
                    </x-responsive-nav-link>
                    @endforeach
                </div>
            </div>

            <!-- Posts Dropdown -->
            <div x-data="{ postsOpen: false }" class="relative">
                <button @click="postsOpen = ! postsOpen" type="button"
                    class="w-full flex items-center px-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-100 focus:outline-none transition">
                    {{ __('Posts') }}
                    <svg class="ms-auto h-5 w-5" :class="{ 'transform rotate-180': postsOpen }" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 12.586l3.293-4.293a1 1 0 011.414 1.414L10 15.414l-6.707-7.121a1 1 0 011.414-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
                <!-- Dropdown Menu -->
                <div x-show="postsOpen" @click.away="postsOpen = false" class="space-y-1">
                    <!-- Option to View All Posts -->
                    <x-responsive-nav-link href="{{ route('posts.index') }}">
                        {{ __('View All Posts') }}
                    </x-responsive-nav-link>
                    <!-- Option to Create New Post -->
                    <x-responsive-nav-link href="{{ route('posts.create') }}">
                        {{ __('Create New Post') }}
                    </x-responsive-nav-link>
                    <div class="border-t border-gray-100"></div>
                    <!-- List of Posts -->
                    @foreach($posts as $post)
                    <x-responsive-nav-link href="{{ route('posts.show', $post->slug) }}">
                        {{ $post->title }}
                    </x-responsive-nav-link>
                    @endforeach
                </div>
            </div>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <!-- ... Keep your existing Responsive Settings Options code here ... -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <!-- Existing Responsive Settings Options -->
            <!-- ... -->
        </div>
    </div>
</nav>