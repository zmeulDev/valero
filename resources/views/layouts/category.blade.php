<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Language" content="{{ str_replace('_', '-', app()->getLocale()) }}">

  <link rel="preconnect" href="{{ url('/') }}">

  @php
    $catName = $category->name ?? '';
    $catDesc = isset($category) ? 'Browse articles in ' . $catName . ' category on ' . config('app_name') . '.' : config('app_seo_description');
    $catUrl = isset($category) ? url(route('category.index', $category->slug)) : url(route('home'));
    $twitterHandle = config('app_twitter_handle') ? '@' . ltrim(config('app_twitter_handle'), '@') : '';
    $ogLocale = match(app()->getLocale()) { 'ro' => 'ro_RO', 'es' => 'es_ES', default => 'en_US' };
  @endphp

  <link rel="preload" as="font" href="{{ Vite::asset('resources/fonts/Poppins-Regular.ttf') }}" type="font/ttf" crossorigin="anonymous">
  <link rel="preload" as="font" href="{{ Vite::asset('resources/fonts/Poppins-Medium.ttf') }}" type="font/ttf" crossorigin="anonymous">

  <title>{{ isset($category) ? $catName . ' - ' . config('app_name') : config('app_name') }}</title>
  <meta name="description" content="{{ $catDesc }}">
  <meta name="robots" content="index, follow">

  <meta property="og:title" content="{{ isset($category) ? $catName . ' - ' . config('app_name') : config('app_name') }}">
  <meta property="og:description" content="{{ $catDesc }}">
  <meta property="og:url" content="{{ $catUrl }}">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="{{ config('app_name') }}">
  <meta property="og:locale" content="{{ $ogLocale }}">
  <meta property="og:image" content="{{ url(asset('storage/brand/logo.png')) }}">

  @if($twitterHandle)
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="{{ $twitterHandle }}">
  <meta name="twitter:title" content="{{ isset($category) ? $catName . ' - ' . config('app_name') : config('app_name') }}">
  <meta name="twitter:description" content="{{ $catDesc }}">
  @endif

  <link rel="canonical" href="{{ $catUrl }}">
  <link rel="icon" href="{{ asset('storage/brand/favicon.ico') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/brand/apple-touch-icon.png') }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="theme-color" content="#0ea5e9">

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

  <!-- BreadcrumbList Schema -->
  @if(isset($category))
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
      },
      {
        "@type": "ListItem",
        "position": 2,
        "name": "{{ $catName }}"
      }
    ]
  }
  </script>
  @endif

  <!-- Vite Assets -->
  @vite(['resources/js/valero-frontend.js'])
  @livewireStyles

  <!-- Alpine.js -->
  <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="font-sans antialiased bg-background text-text" x-data="{ scrolled: false }"
  @scroll.window="scrolled = (window.pageYOffset > 20)">
  <x-navigation />

  <!-- Main Content -->
  <main class="container mx-auto">
    <div class="container mx-auto px-4 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
      <div class="lg:col-span-3 space-y-8">
        @if ($featuredArticle)
          <x-home.featured :article="$featuredArticle" />
        @endif

        <div x-data="{ view: 'grid' }"
          class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
          <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
              {{ __('frontend.common.articles_in_category') }}: {{ $category->name }}
            </h2>
          </div>
          @if ($articles->isEmpty())
            <x-nothing-found />
          @else
            <div class="lg:col-span-3 space-y-8">
              <x-home.latest-grid :articles="$articles" />
            </div>
          @endif
          <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $articles->links() }}
          </div>
        </div>
      </div>
      <x-sidebar.sidebar :popularArticles="$popularArticles" :categories="$categories" />
    </div>
  </main>

  <x-footer />
  <x-scroll-top />

</body>

</html>
