<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Valero' }} - {{ config('app.name', 'Valero') }}</title>
  <link rel="icon" href="{{ asset('images/favicon.ico') }}">
  <!-- Include CSS -->
  @vite('resources/css/app.css')

  <!-- Livewire Styles -->
  @livewireStyles

  <style>
  [x-cloak] {
    display: none !important;
  }
  </style>

  <!-- Alpine.js for interactivity -->
  <script src="//unpkg.com/alpinejs" defer></script>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    // Function to apply the theme based on local storage
    function applyTheme() {
      if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
          '(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        lightIcon.classList.remove('hidden');
        darkIcon.classList.add('hidden');
      } else {
        document.documentElement.classList.remove('dark');
        darkIcon.classList.remove('hidden');
        lightIcon.classList.add('hidden');
      }
    }

    // Apply theme on page load
    applyTheme();

    if (themeToggleBtn) {
      themeToggleBtn.addEventListener('click', function() {
        // Toggle icons inside button
        darkIcon.classList.toggle('hidden');
        lightIcon.classList.toggle('hidden');

        // Toggle dark mode class and update local storage
        if (document.documentElement.classList.contains('dark')) {
          document.documentElement.classList.remove('dark');
          localStorage.setItem('color-theme', 'light');
        } else {
          document.documentElement.classList.add('dark');
          localStorage.setItem('color-theme', 'dark');
        }
      });
    }
  });
  </script>

</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <x-navigation />

  <!-- Main Content -->
  <main class="container mx-auto">
    {{ $slot }}
  </main>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white text-center p-4 mt-6">
    &copy; {{ date('Y') }} Your Valero. All Rights Reserved.
    Version: <span id="version">{{ config('app.version') }}</span>
  </footer>
</body>

</html>