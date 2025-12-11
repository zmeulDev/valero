<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="google-site-verification" content="{{ config('app_googlesearchmeta') }}" />
  <title>{{ config('app_name') }} - {{ config('app_seo_title') }}</title>
  <meta name="description" content="{{ config('app_seo_description') }}">
  @if(config('app_seo_keywords'))
  <meta name="keywords" content="{{ config('app_seo_keywords') }}">
  @endif
  <meta property="og:title" content="{{ config('app_seo_og_title') ?: config('app.name') . ' - ' . config('app_seo_title') }}">
  <meta property="og:description" content="{{ config('app_seo_og_description') ?: config('app_seo_description') }}">
  <meta property="og:url" content="{{ url(route('home')) }}">
  <meta property="og:image" content="{{ url(asset('storage/brand/logo.png')) }}">
  <meta property="og:type" content="website">
  <link rel="canonical" href="{{ url(route('home')) }}">
  <link rel="icon" href="{{ asset('storage/brand/favicon.ico') }}">

  <!-- Organization Schema -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "{{ config('app.name') }}",
    "url": "{{ url(route('home')) }}",
    "logo": "{{ url(asset('storage/brand/logo.png')) }}"
  }
  </script>

  <!-- WebSite Schema with SearchAction -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "{{ config('app.name') }}",
    "url": "{{ url(route('home')) }}",
    "potentialAction": {
      "@type": "SearchAction",
      "target": {
        "@type": "EntryPoint",
        "urlTemplate": "{{ url(route('search')) }}?query={search_term_string}"
      },
      "query-input": "required name=search_term_string"
    }
  }
  </script>

  <!-- Vite Assets -->
  @vite(['resources/css/app.css', 'resources/js/valero-frontend.js'])

  <!-- Livewire Styles -->
  @livewireStyles

  <style>
    [x-cloak] { display: none !important; }
  </style>

  <!-- Cookie Consent Scripts -->
  @cookieconsentscripts
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

  <!-- Livewire Scripts -->
  @livewireScripts
  @stack('scripts')

</body>
</html>
