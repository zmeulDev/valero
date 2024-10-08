<header class="mb-0 mt-4">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xs">
      <nav x-data="{ open: false, dropdownOpen: false }">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
          <a href="{{ route('home') }}" class="flex items-center ">
            <x-application-logo/>
            <span class="self-center p-4 text-2xl dark:text-white">{{ config('app_name') ?: env('APP_NAME', 'Valero') }}</span>
          </a>
          <button @click="open = !open" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="navbar-dropdown" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M1 1h15M1 7h15M1 13h15" />
            </svg>
          </button>
          <div :class="{'block': open, 'hidden': !open}" class="w-full md:block md:w-auto" id="navbar-dropdown">
            <ul
              class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 dark:border-gray-700">
              <li>
                <x-button-action href="{{ route('home') }}" :active="request()->routeIs('home')">
                  Home
                </x-button-action>
              </li>
              <li x-data="{ open: false }" @click.away="open = false" class="relative">
                <button @click="open = !open" type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs
text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500
focus:ring-offset-2 disabled:opacity-25 transition ease-in-out delay-150 hover:-translate-y-1">
                  Categories
                  <x-lucide-chevron-down class="ml-2 -mr-1 w-4 h-4" />
                </button>
                <!-- Dropdown menu -->
                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                  x-transition:enter-start="transform opacity-0 scale-95"
                  x-transition:enter-end="transform opacity-100 scale-100"
                  x-transition:leave="transition ease-in duration-75"
                  x-transition:leave-start="transform opacity-100 scale-100"
                  x-transition:leave-end="transform opacity-0 scale-95"
                  class="absolute z-10 font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                  <ul class="py-2 text-sm text-gray-700 dark:text-gray-400">
                    @foreach($categories as $category)
                    <li>
                      <a href="{{ route('category.index', $category->slug) }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ $category->name }}</a>
                    </li>
                    @endforeach
                  </ul>
                </div>
              </li>
              @auth
              @if($isAdmin)
              <li>
                <x-button-action href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                  Admin Panel
                </x-button-action>
              </li>
              @endif
              <li>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                  @csrf
                  <x-button-action type="submit">
                    Logout
                  </x-button-action>
                </form>
              </li>
              @else
              <li>
                <x-button-action href="{{ route('login') }}">
                  Login
                </x-button-action>
              </li>
              @endauth
              <!-- Theme toggle button -->
              <li>
                <x-button-secondary id="theme-toggle">
                  <x-lucide-sun class="w-4 h-4" id="theme-toggle-light-icon" />
                  <x-lucide-moon class="w-4 h-4" id="theme-toggle-dark-icon" />
                </x-button-secondary>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </div>
</header>