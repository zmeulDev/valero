<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" prefix="og: https://ogp.me/ns#">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- SEO -->
  {!! seo()->for($article) !!}

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

  <!-- Main Content -->
  <main class="container mx-auto">
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
      <div class="container mx-auto px-4 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
        <main class="lg:col-span-3">
          <article class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <div class="px-6 pb-8">
              
              <!-- Article Header -->
              <x-article.header :article="$article" />

              <!-- Buying Options -->
              <x-article.buying-options :article="$article" />

              <!-- Article Content -->
              <div class="prose prose-lg max-w-none dark:prose-invert mb-12">
                {!! $article->content !!}
              </div>

              <!-- Gallery -->
              <x-article.gallery :article="$article" />

              <!-- Related articles based on category only if there are related articles -->
              @if($relatedArticles->count() > 0)
                <x-article.related :relatedArticles="$relatedArticles" />
              @endif

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
    <x-article.fullgallery />

  </main>

  <!-- Footer -->
  <x-footer />

  <!-- Back to top button -->
  <x-scroll-top />
</body>

</html>