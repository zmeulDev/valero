@props(['categories', 'role' => false])

<header class="mb-0">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xs">

      <nav x-data="{ open: false, dropdownOpen: false }">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
          <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <x-application-logo class="h-8 w-8 sm:h-10 sm:w-10 text-gray-800 dark:text-white" />
            <span
              class="self-center text-xl sm:text-2xl font-semibold whitespace-nowrap dark:text-white">{{ config('app_name') }}</span>
          </a>
          <button @click="open = !open" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="navbar-dropdown" aria-expanded="false">
            <span class="sr-only">{{ __('frontend.common.open_main_menu') }}</span>
            <x-lucide-menu class="w-5 h-5" />
          </button>
          <div :class="{'block': open, 'hidden': !open}" class="w-full md:block md:w-auto" id="navbar-dropdown">
            <ul
              class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-900 dark:border-gray-700">
              <li>
                <x-button-action href="{{ route('home') }}" :active="request()->routeIs('home')">
                  <x-lucide-home class="w-4 h-4 mr-2" />
                  {{ __('frontend.common.home') }}
                </x-button-action>
              </li>
              @if($hasPlaylists ?? false)
                <li>
                  <x-button-action href="{{ route('frontend.playlists.index') }}"
                    :active="request()->routeIs('frontend.playlists.*')">
                    <x-lucide-layers class="w-4 h-4 mr-2" />
                    {{ __('frontend.playlists.title') }}
                  </x-button-action>
                </li>
              @endif
              @if($categories->count() > 0)
                <li x-data="{ open: false }" @click.away="open = false" class="relative">
                  <button @click="open = !open" type="button"
                    class="flex w-full md:w-auto items-center rounded-md border border-transparent py-2 px-4 text-center text-sm transition-all text-slate-600 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-gray-800 focus:bg-slate-100 active:bg-slate-100 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                    <x-lucide-folder class="w-4 h-4 mr-2" />
                    {{ __('frontend.common.categories') }}
                    <x-lucide-chevron-down class="ml-2 -mr-1 w-4 h-4" />
                  </button>
                  <div x-show="open" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute left-0 md:left-auto right-0 z-50 mt-2 font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-full md:w-44 dark:bg-gray-800 dark:divide-gray-600">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-300">
                      @foreach($categories as $category)
                        <li>
                          <a href="{{ route('category.index', $category->slug) }}"
                            class="flex items-center block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                            <x-lucide-tag class="w-4 h-4 mr-2" />
                            {{ $category->name }}
                          </a>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </li>
              @endif
              @auth
                @if($role)
                  <li>
                    <x-button-action href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                      <x-lucide-layout-dashboard class="w-4 h-4 mr-2" />
                      {{ __('frontend.common.admin_panel') }}
                    </x-button-action>
                  </li>
                @endif
                <li>
                  <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <x-button-action type="submit">
                      <x-lucide-log-out class="w-4 h-4 mr-2" />
                      {{ __('frontend.common.logout') }}
                    </x-button-action>
                  </form>
                </li>
              @else
                <li>
                  <x-button-action href="{{ route('login') }}">
                    <x-lucide-log-in class="w-4 h-4 mr-2" />
                    {{ __('frontend.common.login') }}
                  </x-button-action>
                </li>
              @endauth
              <li>
                <x-button-action id="theme-toggle">
                  <x-lucide-sun class="w-5 h-5" id="theme-toggle-light-icon" />
                  <x-lucide-moon class="w-5 h-5" id="theme-toggle-dark-icon" />
                </x-button-action>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </div>
</header>