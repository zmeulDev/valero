<header>
    <nav x-data="{ open: false }" class="bg-white border-b border-gray-200 dark:bg-gray-900 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <x-application-logo class="h-8 w-8 sm:h-12 sm:w-12 text-gray-800 dark:text-white" />
                        <span class="ml-3 text-lg font-semibold text-gray-900 dark:text-white">
                            Admin<span class="text-gray-400 dark:text-gray-500 mx-2">|</span>{{ config('app_name') ?? config('app.name') }}
                        </span>
                    </a>

                    <!-- Primary Navigation Menu -->
                    <div class="hidden sm:ml-10 sm:flex sm:space-x-4">
                        <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')"
                            class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-colors duration-150">
                            <x-lucide-layout-dashboard class="w-4 h-4 mr-2" />
                            {{ __('admin.common.home') }}
                        </x-nav-link>

                        <!-- Publish Article -->
                        @if(auth()->user()->isAdmin())
                            <!-- dropdown with articles and categories -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                        class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-colors duration-150">
                                    <x-lucide-plus-circle class="w-4 h-4 mr-2" />
                                    {{ __('admin.common.articles') }}
                                    <x-lucide-chevron-down class="ml-2 h-4 w-4" />
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open"
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50">
                                    <div class="py-1">
                                        <a href="{{ route('admin.articles.index') }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.settings.index') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                            <div class="flex items-center">
                                                <x-lucide-book-open class="w-4 h-4 mr-2" />
                                                {{ __('admin.common.articles') }}
                                            </div>
                                        </a>

                                        <a href="{{ route('admin.categories.index') }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.teams.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                            <div class="flex items-center">
                                                <x-lucide-folder class="w-4 h-4 mr-2" />
                                                {{ __('admin.common.categories') }}
                                            </div>
                                        </a>

                                        <a href="{{ route('admin.media.index') }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.partners.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                            <div class="flex items-center">
                                                <x-lucide-image class="w-4 h-4 mr-2" />
                                                {{ __('admin.common.media') }}
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Settings Dropdown -->
                        @if(auth()->user()->isAdmin())
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                        class="inline-flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white transition-colors duration-150 {{ request()->routeIs('admin.settings.*', 'admin.teams.*', 'admin.partners.*') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">
                                    <x-lucide-settings class="w-4 h-4 mr-2" />
                                    {{ __('admin.common.settings') }}
                                    <x-lucide-chevron-down class="ml-2 h-4 w-4" />
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open"
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50">
                                    <div class="py-1">
                                        <a href="{{ route('admin.settings.index') }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.settings.index') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                            <div class="flex items-center">
                                                <x-lucide-sliders class="w-4 h-4 mr-2" />
                                                {{ __('admin.common.settings') }}
                                            </div>
                                        </a>

                                        <a href="{{ route('admin.teams.index') }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.teams.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                            <div class="flex items-center">
                                                <x-lucide-users class="w-4 h-4 mr-2" />
                                                {{ __('admin.common.teams') }}
                                            </div>
                                        </a>

                                        <a href="{{ route('admin.partners.index') }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->routeIs('admin.partners.*') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                            <div class="flex items-center">
                                                <x-lucide-handshake class="w-4 h-4 mr-2" />
                                                {{ __('admin.common.partners') }}
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <!-- Dark Mode Toggle -->
                    <x-button-action id="theme-toggle-admin" class="border-none">
                        <x-lucide-sun class="w-5 h-5" id="theme-toggle-light-icon-admin" />
                        <x-lucide-moon class="w-5 h-5" id="theme-toggle-dark-icon-admin" />
                    </x-button-action>

                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white focus:outline-none transition duration-150 ease-in-out">
                                    <div class="flex items-center">
                                        <img class="h-8 w-8 rounded-full object-cover border-2 border-transparent hover:border-indigo-500 transition-colors duration-200" 
                                             src="{{ auth()->user()->profile_photo_url }}" 
                                             alt="{{ auth()->user()->name }}" />
                                        <div class="ml-2 flex flex-col items-start">
                                            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">Administrator</span>
                                        </div>
                                        <x-lucide-chevron-down class="ml-2 h-4 w-4" />
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-2 border-b border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-800">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Signed in as</p>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ auth()->user()->email }}</p>
                                </div>

                                <x-dropdown-link href="{{ route('profile.show') }}" class="flex items-center">
                                    <x-lucide-user class="w-4 h-4 mr-2" />
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('admin.settings.index') }}" class="flex items-center">
                                    <x-lucide-settings class="w-4 h-4 mr-2" />
                                    {{ __('Settings') }}
                                </x-dropdown-link>

                                <div class="border-t border-gray-100 dark:border-gray-700"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link href="{{ route('logout') }}" 
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        <x-lucide-log-out class="w-4 h-4 mr-2" />
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center sm:hidden">
                    <button @click="open = !open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition-colors duration-200">
                        <x-lucide-menu x-show="!open" class="h-6 w-6" />
                        <x-lucide-x x-show="open" class="h-6 w-6" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div :class="{'block': open, 'hidden': !open}" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1 bg-white dark:bg-gray-900">
                <x-responsive-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')"
                    class="flex items-center">
                    <x-lucide-layout-dashboard class="w-4 h-4 mr-2" />
                    {{ __('admin.common.dashboard') }}
                </x-responsive-nav-link>
                
                <!-- Add other responsive nav links with icons -->
            </div>

            <!-- Mobile settings -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full object-cover" 
                             src="{{ auth()->user()->profile_photo_url }}" 
                             alt="{{ auth()->user()->name }}" />
                    </div>
                    <div class="ml-3">
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ auth()->user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link href="{{ route('profile.show') }}" class="flex items-center">
                        <x-lucide-user class="w-4 h-4 mr-2" />
                        {{ __('admin.common.profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link href="{{ route('logout') }}" 
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                            <x-lucide-log-out class="w-4 h-4 mr-2" />
                            {{ __('admin.common.logout') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</header>

