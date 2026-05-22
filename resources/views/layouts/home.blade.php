<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" prefix="og: https://ogp.me/ns#">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="Content-Language" content="{{ str_replace('_', '-', app()->getLocale()) }}">

  <link rel="preconnect" href="{{ url('/') }}">

  @php
    $twitterHandle = config('app_twitter_handle') ? '@' . ltrim(config('app_twitter_handle'), '@') : '';
    $ogLocale = match(app()->getLocale()) { 'ro' => 'ro_RO', 'es' => 'es_ES', default => 'en_US' };
  @endphp

  <link rel="preload" as="font" href="{{ Vite::asset('resources/fonts/Poppins-Regular.ttf') }}" type="font/ttf" crossorigin="anonymous">
  <link rel="preload" as="font" href="{{ Vite::asset('resources/fonts/Poppins-Medium.ttf') }}" type="font/ttf" crossorigin="anonymous">

  <title>{{ $title ?? (config('app_name') . ' - ' . config('app_seo_title')) }}</title>
  <meta name="description" content="{{ $description ?? config('app_seo_description') }}">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
  <meta property="og:title" content="{{ $ogTitle ?? (config('app_name') . ' - ' . config('app_seo_title')) }}">
  <meta property="og:description" content="{{ $ogDescription ?? config('app_seo_description') }}">
  <meta property="og:url" content="{{ request()->fullUrl() }}">
  <meta property="og:image" content="{{ $ogImage ?? url(asset('storage/brand/logo.png')) }}">
  <meta property="og:type" content="{{ $ogType ?? 'website' }}">
  <meta property="og:locale" content="{{ $ogLocale }}">
  <meta property="og:site_name" content="{{ config('app_name') }}">

  @if($twitterHandle)
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="{{ $twitterHandle }}">
  <meta name="twitter:title" content="{{ $ogTitle ?? (config('app_name') . ' - ' . config('app_seo_title')) }}">
  <meta name="twitter:description" content="{{ $ogDescription ?? config('app_seo_description') }}">
  <meta name="twitter:image" content="{{ $ogImage ?? url(asset('storage/brand/logo.png')) }}">
  @endif

  <link rel="canonical" href="{{ request()->fullUrl() }}">
  <link rel="icon" href="{{ asset('storage/brand/favicon.ico') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/brand/apple-touch-icon.png') }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="theme-color" content="#0ea5e9">
  {{ $head ?? '' }}

  @if(config('app_googlesearchmeta'))
  <meta name="google-site-verification" content="{{ config('app_googlesearchmeta') }}">
  @endif

  <!-- Organization Schema -->
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@type": "Organization",
    "name": "{{ config('app_name') }}",
    "url": "{{ url(route('home')) }}",
    "logo": "{{ url(asset('storage/brand/logo.png')) }}"
  }
  </script>

  <!-- WebSite Schema with SearchAction -->
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@type": "WebSite",
    "name": "{{ config('app_name') }}",
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

  <!-- BreadcrumbList Schema -->
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
      {
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "{{ url(route('home')) }}"
      }
    ]
  }
  </script>

  <!-- Vite Assets -->
  @vite(['resources/js/valero-frontend.js'])

  <!-- Livewire Styles -->
  @livewireStyles

  <!-- Cookie Consent Scripts -->
  @cookieconsentscripts
</head>

<body x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)"
  class="font-sans antialiased bg-background text-text">
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
