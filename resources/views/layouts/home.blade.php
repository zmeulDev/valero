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
    <button 
        @click="window.scrollTo({top: 0, behavior: 'smooth'})"
        x-show="scrolled"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-8"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-8"
        class="fixed right-8 bottom-8 p-2 rounded-xl bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm border border-gray-200/50 dark:border-gray-700/50 shadow-lg hover:shadow-xl transition-all duration-300"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
    </svg>
  </button>

  <!-- Custom Valero Frontend JS -->
  @vite('resources/js/valero-frontend.js')
  @livewireScripts

</body>

</html>