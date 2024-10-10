<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- SEO -->
  {!! seo(isset($category) ? $category : null) !!}
  <!-- End SEO -->

  <link rel="icon" href="{{ asset('storage/images/favicon.ico') }}">
  <!-- Include CSS -->
  @vite('resources/css/app.css')

  <!-- Livewire Styles -->
  @livewireStyles

  <!-- Alpine.js for interactivity -->
  <script src="//unpkg.com/alpinejs" defer></script>

</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <x-navigation />


  <!-- Main Content -->
  <main class="container mx-auto">
    <div class="container mx-auto px-4 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
      <div class="lg:col-span-3 space-y-8">
        <!-- Featured Article Section -->
        @if ($featuredArticle)
        <x-home.home-featured-articles :article="$featuredArticle" />
        @endif

        <div x-data="{ view: 'grid' }"
          class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
          <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Articles in category: {{ $category->name }}</h2>
          </div>
          @if ($articles->isEmpty())
          <x-nothing-found />
          @else
          <div class="lg:col-span-3 space-y-8">
            <x-home.home-latest-articles-grid :articles="$articles" />
          </div>
          @endif
          <!-- Pagination -->
          <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $articles->links() }}
          </div>
        </div>
      </div>
      <!-- Sidebar -->
      <x-sidebar.sidebar :popularArticles="$popularArticles" :categories="$categories" />
    </div>
  </main>

  <!-- Footer -->
  <x-footer />

  <!-- Custom Valero Frontend JS -->
  @vite('resources/js/valero-frontend.js')
</body>

</html>