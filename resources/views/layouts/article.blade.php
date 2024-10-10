<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- SEO -->
  {!! seo(isset($article) ? $article : null) !!}

  <link rel="icon" href="{{ asset('storage/images/favicon.ico') }}">
  <!-- Include CSS -->
  @vite('resources/css/app.css')


  <!-- End SEO -->

  <!-- Livewire Styles -->
  @livewireStyles

  <!-- Alpine.js for interactivity -->
  <script src="//unpkg.com/alpinejs" defer></script>

</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <x-navigation />

  <!-- Main Content -->
  <main class="container mx-auto">
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
      <div class="container mx-auto px-4 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
        <main class="lg:col-span-3">
          <article class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <!-- Featured Image with Metadata -->
            <x-article.feature :article="$article" :readingTime="$readingTime" />

            <div class="px-6 pb-8">
              <!-- Article Header -->
              <x-article.header :article="$article" />

              <!-- Article Content -->
              <div class="prose prose-lg max-w-none dark:prose-invert mb-12">
                {!! $article->content !!}
              </div>

              <!-- Gallery -->
              <x-article.gallery :article="$article" />

              <!-- Related articles based on category -->
              <x-article.related :relatedArticles="$relatedArticles" />

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
  <!-- Custom Valero Frontend JS -->
  @vite('resources/js/valero-frontend.js')
</body>

</html>