<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Language" content="{{ str_replace('_', '-', app()->getLocale()) }}">

  <link rel="preconnect" href="{{ url('/') }}">

  @php
    $seoTitle = $article->meta_title ?: $article->title;
    $seoDescription = $article->meta_description ?: \App\Helpers\SeoHelper::smartTruncate($article->excerpt ?: strip_tags($article->content), 160);
    $seoRobots = $article->meta_robots ?: 'index, follow';
    $canonical = $article->canonical_url ?: url(route('articles.index', $article->slug));
    $coverMedia = $article->media->firstWhere('is_cover', true);
    $ogImage = $coverMedia?->image_path ? url('storage/' . $coverMedia->image_path) : url(asset('storage/brand/logo.png'));
    $ogImageWidth = $coverMedia?->image_width ?? null;
    $ogImageHeight = $coverMedia?->image_height ?? null;
    $twitterHandle = config('app_twitter_handle') ? '@' . ltrim(config('app_twitter_handle'), '@') : '';

    $ogLocale = match(app()->getLocale()) {
        'ro' => 'ro_RO',
        'es' => 'es_ES',
        default => 'en_US',
    };
  @endphp

  @if($coverMedia?->image_path)
  <link rel="preload" as="image" href="{{ $ogImage }}" imagesrcset="{{ $ogImage }}" imagesizes="100vw">
  @endif
  <link rel="preload" as="font" href="{{ Vite::asset('resources/fonts/Poppins-Regular.ttf') }}" type="font/ttf" crossorigin="anonymous">
  <link rel="preload" as="font" href="{{ Vite::asset('resources/fonts/Poppins-Medium.ttf') }}" type="font/ttf" crossorigin="anonymous">

  <title>{{ $seoTitle }} - {{ config('app_name') }}</title>
  <meta name="description" content="{{ $seoDescription }}">
  <meta name="author" content="{{ $article->user->name }}">
  <meta name="robots" content="{{ $seoRobots }}">

  <meta property="og:title" content="{{ $seoTitle }}">
  <meta property="og:description" content="{{ $seoDescription }}">
  <meta property="og:url" content="{{ url(route('articles.index', $article->slug)) }}">
  <meta property="og:type" content="article">
  <meta property="og:site_name" content="{{ config('app_name') }}">
  <meta property="og:locale" content="{{ $ogLocale }}">
  <meta property="og:image" content="{{ $ogImage }}">
  @if($ogImageWidth)
  <meta property="og:image:width" content="{{ $ogImageWidth }}">
  @endif
  @if($ogImageHeight)
  <meta property="og:image:height" content="{{ $ogImageHeight }}">
  @endif
  <meta property="article:published_time" content="{{ $article->created_at->toIso8601String() }}">
  <meta property="article:modified_time" content="{{ $article->updated_at->toIso8601String() }}">
  <meta property="article:section" content="{{ $article->category->name }}">
  <meta property="article:author" content="{{ $article->user->name }}">

  @if($twitterHandle)
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="{{ $twitterHandle }}">
  <meta name="twitter:creator" content="{{ $twitterHandle }}">
  <meta name="twitter:title" content="{{ $seoTitle }}">
  <meta name="twitter:description" content="{{ $seoDescription }}">
  <meta name="twitter:image" content="{{ $ogImage }}">
  @endif

  <link rel="canonical" href="{{ $canonical }}">
  <link rel="icon" href="{{ asset('storage/brand/favicon.ico') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/brand/apple-touch-icon.png') }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="theme-color" content="#0ea5e9">

  @if(config('app_googlesearchmeta'))
  <meta name="google-site-verification" content="{{ config('app_googlesearchmeta') }}">
  @endif

  <!-- Article Schema -->
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@type": "Article",
    "headline": "{{ $seoTitle }}",
    "description": "{{ $seoDescription }}",
    "image": ["{{ $ogImage }}"],
    "datePublished": "{{ $article->created_at->toIso8601String() }}",
    "dateModified": "{{ $article->updated_at->toIso8601String() }}",
    "author": {
      "@type": "Person",
      "name": "{{ $article->user->name }}",
      "url": "{{ url('/author/' . $article->user->id) }}"
    },
    "publisher": {
      "@type": "Organization",
      "name": "{{ config('app_name') }}",
      "logo": {
        "@type": "ImageObject",
        "url": "{{ url(asset('storage/brand/logo.png')) }}"
      }
    },
    "mainEntityOfPage": {
      "@type": "WebPage",
      "@id": "{{ url(route('articles.index', $article->slug)) }}"
    },
    "articleSection": "{{ $article->category->name }}",
    "wordCount": {{ str_word_count(strip_tags($article->content)) }}
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
      },
      {
        "@type": "ListItem",
        "position": 2,
        "name": "{{ $article->category->name }}",
        "item": "{{ url(route('category.index', $article->category->slug)) }}"
      },
      {
        "@type": "ListItem",
        "position": 3,
        "name": "{{ $seoTitle }}",
        "item": "{{ url(route('articles.index', $article->slug)) }}"
      }
    ]
  }
  </script>

  <!-- Vite Assets -->
  @vite(['resources/js/valero-frontend.js'])

  @livewireStyles
</head>

<body class="font-sans antialiased bg-background text-text" x-data="{ scrolled: false }"
  @scroll.window="scrolled = (window.pageYOffset > 20)">
  <x-header :categories="$categories" :role="$role" />

  @if(isset($isPreview) && $isPreview)
    <div class="bg-yellow-500 text-white py-2 px-4 text-center font-medium">
      <div class="container mx-auto flex items-center justify-center">
        <x-lucide-eye class="w-5 h-5 mr-2" />
        <span>{{ __('frontend.common.preview_mode') }} -
          {{ $article->scheduled_at ? $article->scheduled_at->format('F d, Y H:i') : __('frontend.common.future_publication') }}</span>
      </div>
    </div>
  @endif

  <!-- Main Content -->
  <main class="container mx-auto">
    <div class="bg-background min-h-screen">
      <div class="container mx-auto px-4 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
        <main class="lg:col-span-3">
          <article class="bg-surface rounded-xl shadow-md overflow-hidden">
            <div class="px-6 pb-8">
              <x-frontend.article.header :article="$article" :playlistContext="$playlistContext ?? null" />
              <x-frontend.article.options :article="$article" />
              <div class="prose prose-lg max-w-none dark:prose-invert mb-12">
                {!! $article->content !!}
              </div>
              <x-frontend.article.gallery :article="$article" />
              <x-frontend.article.related :relatedArticles="$relatedArticles" :currentArticle="$article" />
            </div>
          </article>
        </main>
        <aside class="lg:col-span-1">
          <div class="sticky top-8">
            <x-sidebar.sidebar :popularArticles="$popularArticles" :categories="$categories" />
          </div>
        </aside>
      </div>
    </div>
    <x-frontend.article.modal-gallery />
  </main>

  <x-footer />
  <x-scroll-top />

  @livewireScripts
</body>

</html>
