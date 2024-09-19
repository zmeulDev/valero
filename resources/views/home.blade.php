<x-app-layout>
  <x-slot name="title">Blog</x-slot>

  <div class="container mx-auto px-4 lg:px-8 py-12 grid grid-cols-1 lg:grid-cols-4 gap-8">
    <div class="lg:col-span-3 space-y-8">
      <!-- Featured Article Section -->
      @if ($featuredArticle)
      <div class="relative bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl overflow-hidden mb-8 shadow-lg">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-1 p-6 sm:p-8 flex flex-col sm:flex-row items-center">
          <div class="sm:w-1/3 mb-6 sm:mb-0 sm:mr-8">
            <img class="w-full h-48 sm:h-64 object-cover object-center rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300" src="{{ asset('storage/' . $featuredArticle->featured_image) }}" alt="{{ $featuredArticle->title }}" />
          </div>
          <div class="sm:w-2/3">
            <span class="inline-block bg-yellow-400 text-gray-900 text-xs font-bold px-3 py-1 rounded-full mb-4">FEATURED</span>
            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-4 leading-tight">
              <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="hover:text-yellow-400 transition-colors duration-150">{{ $featuredArticle->title }}</a>
            </h2>
            <p class="text-gray-200 mb-6">{{ Str::limit($featuredArticle->excerpt, 120) }}</p>
            <div class="flex items-center text-gray-200">
              <img class="w-8 h-8 rounded-full mr-3" src="{{ $featuredArticle->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($featuredArticle->user->name) }}" alt="{{ $featuredArticle->user->name }}">
              <span>{{ $featuredArticle->user->name }}</span>
              <span class="mx-2">•</span>
              <span>{{ $featuredArticle->created_at->format('M d, Y') }}</span>
            </div>
          </div>
        </div>
        <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="absolute bottom-4 right-4 bg-yellow-400 text-gray-900 px-4 py-2 rounded-full font-bold hover:bg-yellow-300 transition-colors duration-150 z-1">
          Read Now
        </a>
      </div>
      @endif

      <!-- Latest Articles Section -->
      <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white px-6 py-4 border-b border-gray-200 dark:border-gray-700">Latest Articles</h2>
        @if ($articles->isEmpty())
          <p class="text-gray-500 dark:text-gray-400 text-center italic p-6">No articles found.</p>
        @else
          <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($articles as $article)
            <article class="p-6">
              <div class="flex flex-col sm:flex-row">
                <div class="sm:w-[250px] mb-4 sm:mb-0 sm:mr-6 flex-shrink-0">
                  <div class="w-full h-[200px]">
                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
                      class="w-full h-full object-cover object-center rounded-lg">
                  </div>
                </div>
                <div class="flex-grow flex flex-col">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    <a href="{{ route('articles.show', $article->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-150">{{ $article->title }}</a>
                  </h3>
                  <p class="text-gray-600 dark:text-gray-300 mb-4 flex-grow">{{ Str::limit($article->excerpt, 120) }}</p>
                  <div class="flex items-center justify-between mt-auto">
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                      <span>{{ $article->created_at->format('M d, Y') }}</span>
                      <span class="mx-2">•</span>
                      <span>{{ $article->views }} views</span>
                    </div>
                    <a href="{{ route('articles.show', $article->slug) }}"
                      class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                      Read More
                      <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                  </div>
                </div>
              </div>
            </article>
            @endforeach
          </div>
          <!-- Pagination -->
          <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $articles->links() }}
          </div>
        @endif
      </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1">
      <div class="sticky top-16 space-y-8">
        <x-sidebar :popularArticles="$popularArticles" :categories="$categories" />
      </div>
    </div>
  </div>
</x-app-layout>