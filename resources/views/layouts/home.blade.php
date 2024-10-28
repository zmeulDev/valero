<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="google-site-verification" content="{{ config('app_googlesearchmeta') }}" />
  {!! seo() !!}
  <link rel="icon" href="{{ asset('storage/images/favicon.ico') }}">
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

</head>

<body 
    class="font-sans antialiased min-h-screen bg-gradient-to-br from-gray-50 to-white dark:from-gray-950 dark:to-gray-900 text-gray-900 dark:text-gray-100 selection:bg-indigo-500/20"
    x-data="{ scrolled: false }"
    @scroll.window="scrolled = (window.pageYOffset > 20)"
>
  <x-navigation />

  <!-- Flash Message Component -->
  <x-flash-message />

  <!-- Main Content -->
  <main class="container mx-auto">
    {{ $slot }}
  </main>

  <!-- Footer -->
  <x-footer />

  <!-- Back to top button -->
  <x-scroll-top />

  <!-- Custom Valero Frontend JS -->
  @vite('resources/js/valero-frontend.js')
  @livewireScripts

</body>

</html>