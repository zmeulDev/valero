<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="google-site-verification" content="{{ config('app_googlesearchmeta') }}" />
  {!! seo() !!}
  <link rel="icon" href="{{ asset('storage/brand/favicon.ico') }}">
  
  <!-- Assets -->
  <x-vite-assets />
  @livewireStyles

  <style>
    [x-cloak] { display: none !important; }
  </style>

  <!-- Alpine.js -->
  <script src="//unpkg.com/alpinejs" defer></script>

  <!-- Cookie Consent Scripts -->
  @cookieconsentscripts

  <!-- Additional Scripts -->
  @vite('resources/js/valero-frontend.js')
</head>

<body 
    x-data="{ scrolled: false }"
    @scroll.window="scrolled = (window.pageYOffset > 20)"
    class="font-sans antialiased bg-gradient-to-br from-gray-50 to-white dark:from-gray-950 dark:to-gray-900"
>
  <div class="min-h-screen flex flex-col">
    <!-- Header -->
    <x-header :categories="$categories" :role="$role" />

    <!-- Flash Messages -->
    <x-notification />

    <!-- Main Content -->
    <main class="flex-1">
      <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        {{ $slot }}
      </div>
    </main>

    <!-- Footer -->
    <x-footer />

    <!-- Back to top button -->
    <x-scroll-top />

    <!-- Cookie Consent Banner -->
    @include('frontend.cookies.consent')
  </div>

  <!-- Scripts -->
  @vite('resources/js/valero-frontend.js')
  @livewireScripts
  @stack('scripts')

</body>

</html>