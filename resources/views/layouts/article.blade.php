<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- SEO -->
  {!! seo()->for($article) !!}

  <!-- Enhanced Article Schema with ImageObject Array for Google Discovery -->
  @php
    $coverMedia = $article->media->firstWhere('is_cover', true);
    $articleImageObjects = [];
    if ($coverMedia) {
      $imageObj = [
        '@type' => 'ImageObject',
        'url' => url(asset('storage/' . $coverMedia->image_path)),
        'caption' => $coverMedia->alt_text ?: $article->title
      ];
      if ($coverMedia->dimensions) {
        $imageObj['width'] = $coverMedia->dimensions['width'] ?? 1200;
        $imageObj['height'] = $coverMedia->dimensions['height'] ?? 630;
      }
      $articleImageObjects[] = $imageObj;
    }
    $articleDescription = \Illuminate\Support\Str::limit(strip_tags($article->excerpt ?: $article->content), 160);
  @endphp
  @if(count($articleImageObjects) > 0)
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": @json($article->title),
    "description": @json($articleDescription),
    "image": @json($articleImageObjects),
    "datePublished": "{{ $article->created_at->toIso8601String() }}",
    "dateModified": "{{ $article->updated_at->toIso8601String() }}",
    "author": {
      "@type": "Person",
      "name": @json($article->user->name)
    },
    "publisher": {
      "@type": "Organization",
      "name": @json(config('app.name')),
      "logo": {
        "@type": "ImageObject",
        "url": "{{ url(asset('storage/brand/logo.png')) }}"
      }
    },
    "mainEntityOfPage": {
      "@type": "WebPage",
      "@id": "{{ url(route('articles.index', ['slug' => $article->slug])) }}"
    }@if(count($article->tags_array ?? []) > 0),
    "keywords": @json($article->tags_array)
    @endif
  }
  </script>
  @endif

  <!-- Additional Article Meta Tags -->
  <meta name="article:author" content="{{ $article->user->name }}">
  <meta name="article:section" content="{{ $article->category->name }}">
  <meta property="article:section" content="{{ $article->category->name }}">
  @if($article->tags_array)
    @foreach($article->tags_array as $tag)
      <meta name="article:tag" content="{{ trim($tag) }}">
      <meta property="article:tag" content="{{ trim($tag) }}">
    @endforeach
  @endif
  @if($article->media->firstWhere('is_cover', true))
    @php
      $coverMedia = $article->media->firstWhere('is_cover', true);
      $dimensions = $coverMedia->dimensions ?? null;
    @endphp
    @if($dimensions)
      <meta property="og:image:width" content="{{ $dimensions['width'] ?? 1200 }}">
      <meta property="og:image:height" content="{{ $dimensions['height'] ?? 630 }}">
    @endif
    <meta property="og:image:type" content="image/jpeg">
  @endif
  <meta name="keywords" content="{{ implode(', ', array_merge([$article->category->name], $article->tags_array ?? [])) }}">

  <!-- Twitter Card Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $article->title }}">
  @php
    $description = $article->excerpt ?: strip_tags($article->content);
    $description = mb_substr($description, 0, 160);
  @endphp
  <meta name="twitter:description" content="{{ $description }}">
  @if($article->media->firstWhere('is_cover', true))
    <meta name="twitter:image" content="{{ url(asset('storage/' . $article->media->firstWhere('is_cover', true)->image_path)) }}">
    @if(isset($dimensions))
      <meta name="twitter:image:width" content="{{ $dimensions['width'] ?? 1200 }}">
      <meta name="twitter:image:height" content="{{ $dimensions['height'] ?? 630 }}">
    @endif
  @endif
  @if(config('seo.twitter.@username'))
    <meta name="twitter:site" content="@{{ config('seo.twitter.@username') }}">
    <meta name="twitter:creator" content="@{{ config('seo.twitter.@username') }}">
  @endif

  <!-- Organization Schema -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "{{ config('app.name') }}",
    "url": "{{ url(route('home')) }}",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ url(asset('storage/brand/logo.png')) }}"
    }
  }
  </script>

  <!-- ImageObject Schema for Article Images -->
  @if($article->media->count() > 0)
  @php
    $images = [];
    foreach($article->media as $media) {
      $imageData = [
        '@type' => 'ImageObject',
        'url' => url(asset('storage/' . $media->image_path)),
        'caption' => $media->alt_text ?: $article->title
      ];
      if($media->dimensions) {
        $imageData['width'] = $media->dimensions['width'] ?? 1200;
        $imageData['height'] = $media->dimensions['height'] ?? 630;
      }
      $images[] = $imageData;
    }
  @endphp
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "ImageGallery",
    "associatedArticle": {
      "@type": "Article",
      "headline": "{{ $article->title }}",
      "url": "{{ url(route('articles.index', ['slug' => $article->slug])) }}"
    },
    "image": @json($images)
  }
  </script>
  @endif

  <!-- Performance: Preconnect to external resources -->
  <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
  <link rel="dns-prefetch" href="https://unpkg.com">

  <!-- Vite Assets -->
  @vite(['resources/css/app.css', 'resources/js/valero-frontend.js'])

  <!-- Alpine.js -->
  <script src="//unpkg.com/alpinejs" defer></script>
  <link rel="icon" href="{{ asset('storage/brand/favicon.ico') }}">
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100"
  x-data="{ scrolled: false }"
  @scroll.window="scrolled = (window.pageYOffset > 20)"
>
  <x-header :categories="$categories" :role="$role" />

  <!-- Preview Banner for Scheduled Articles -->
  @if(isset($isPreview) && $isPreview)
    <div class="bg-yellow-500 text-white py-2 px-4 text-center font-medium">
      <div class="container mx-auto flex items-center justify-center">
        <x-lucide-eye class="w-5 h-5 mr-2" />
        <span>{{ __('frontend.common.preview_mode') }} - {{ $article->scheduled_at ? $article->scheduled_at->format('F d, Y H:i') : __('frontend.common.future_publication') }}</span>
      </div>
    </div>
  @endif

  <!-- Main Content -->
  <main class="container mx-auto">
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
      <div class="container mx-auto px-4 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
        <main class="lg:col-span-3">
          <article class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <div class="px-6 pb-8">
              
              <!-- Article Header -->
              <x-frontend.article.header :article="$article" />

              <!-- Options -->
              <x-frontend.article.options :article="$article" />

              <!-- Article Content -->
              <div class="prose prose-lg max-w-none dark:prose-invert mb-12">
                {!! $article->content !!}
              </div>

              <!-- Gallery -->
              <x-frontend.article.gallery :article="$article" />

              <!-- Related Articles Section -->
              <x-frontend.article.related :relatedArticles="$relatedArticles" :currentArticle="$article" />

            </div>
          </article>
        </main>

        <!-- Sidebar -->
        <aside class="lg:col-span-1">
          <div class="sticky top-8">
            <x-sidebar.sidebar :popularArticles="$popularArticles" :categories="$categories" />
          </div>
        </aside>
      </div>
    </div>

    <!-- Full-size Gallery Modal -->
    <x-frontend.article.modal-gallery />

  </main>

  <!-- Footer -->
  <x-footer />

  <!-- Back to top button -->
  <x-scroll-top />
</body>

</html>