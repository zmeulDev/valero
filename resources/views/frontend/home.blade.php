<x-home-layout>
  <!-- Default SEO title and description are used from config -->

  <div class="container mx-auto px-4 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
    <div class="lg:col-span-3 space-y-8">
      <!-- Featured Article Section -->
      @if ($featuredArticle)
        <x-home.featured :article="$featuredArticle" />
      @endif

      <!-- Latest Articles Section -->
      <x-home.latest :articles="$articles" />
    </div>

    <!-- Sidebar -->
    <x-sidebar.sidebar :popularArticles="$popularArticles" :categories="$categories" />

  </div>
</x-home-layout>