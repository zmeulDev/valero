<div class="bg-white dark:bg-gray-800 rounded-xl mt-4 px-4 pb-4 border border-gray-200 dark:border-gray-700 overflow-hidden shadow-xs">
  <h3 class="text-xl font-bold text-gray-900 dark:text-white px-4 py-4  dark:border-gray-700">
    Related Articles
  </h3>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($relatedArticles as $relatedArticle)
      <div class="bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden transition-transform transform hover:scale-105 hover:shadow-xs">
        <a href="{{ route('articles.index', $relatedArticle->slug) }}" class="flex flex-col p-4">
          <img src="{{ asset('storage/' . $relatedArticle->featured_image) }}" alt="{{ $relatedArticle->title }}"
            class="w-full h-32 object-cover rounded-md mb-2 shadow-sm">
          <div class="flex-1 min-w-0">
            <h4 class="text-md font-semibold text-gray-900 dark:text-white truncate">{{ $relatedArticle->title }}</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
              {{ $relatedArticle->created_at->format('F d, Y') }}
            </p>
          </div>
        </a>
      </div>
    @endforeach
  </div>
</div>