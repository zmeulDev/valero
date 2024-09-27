<header class="mb-0">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-xs">
      <div class="flex items-center justify-between h-16 px-4">
        <a href="{{ route('home') }}" class="flex items-center">
          <!-- Logo -->
          <img src="/brand/logo.png" alt="Logo" class="h-12 w-12">
          <span class="ml-2 text-xl font-bold text-gray-800 dark:text-gray-200">{{ config('app.name') }}</span>
        </a>
        <nav class="flex items-center space-x-4">
          <a href="{{ route('home') }}"
            class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">Home</a>
          @auth
          @if($isAdmin)
          <a href="{{ route('admin.dashboard') }}"
            class="bg-blue-500 dark:bg-blue-600 text-white hover:bg-blue-600 dark:hover:bg-blue-700 px-3 py-2 rounded-full text-sm font-medium transition duration-150 ease-in-out">Admin
            Panel</a>
          @endif
          <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit"
              class="bg-red-500 dark:bg-red-600 text-white hover:bg-red-600 dark:hover:bg-red-700 px-3 py-2 rounded-full text-sm font-medium transition duration-150 ease-in-out">Logout</button>
          </form>
          @else
          <a href="{{ route('login') }}"
            class="bg-blue-500 dark:bg-blue-600 text-white hover:bg-blue-600 dark:hover:bg-blue-700 px-3 py-2 rounded-full text-sm font-medium transition duration-150 ease-in-out">Login</a>
          @endauth
          <!-- Dark Mode Toggle Button -->
          <button id="theme-toggle"
            class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
            <svg id="theme-toggle-dark-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
            </svg>
            <svg id="theme-toggle-light-icon" width="18" height="18" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="4"></circle>
              <path d="M12 2v2"></path>
              <path d="M12 20v2"></path>
              <path d="m4.93 4.93 1.41 1.41"></path>
              <path d="m17.66 17.66 1.41 1.41"></path>
              <path d="M2 12h2"></path>
              <path d="M20 12h2"></path>
              <path d="m6.34 17.66-1.41 1.41"></path>
              <path d="m19.07 4.93-1.41 1.41"></path>
            </svg>
          </button>
        </nav>
      </div>
    </div>
  </div>
</header>