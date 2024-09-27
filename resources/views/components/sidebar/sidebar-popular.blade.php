<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
  <h3 class="text-xl font-bold text-gray-900 dark:text-white px-6 py-4 border-b border-gray-200 dark:border-gray-700">
    Popular Articles
  </h3>
  <ul class="divide-y divide-gray-200 dark:divide-gray-700">
    @foreach ($popularArticles as $popularArticle)
    <li class="hover:bg-gray-50 dark:hover:bg-gray-750 transition duration-150 ease-in-out">
      <a href="{{ route('articles.index', $popularArticle->slug) }}" class="flex items-center space-x-4 px-6 py-4">
        <img src="{{ asset('storage/' . $popularArticle->featured_image) }}" alt="{{ $popularArticle->title }}"
          class="w-16 h-16 object-cover rounded-md">
        <div class="flex-1 min-w-0">
          <h4 class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $popularArticle->title }}
          </h4>
          <p class="text-xs text-gray-500 dark:text-gray-400">
            {{ $popularArticle->created_at->format('F d, Y') }}
          </p>
        </div>
      </a>
    </li>
    @endforeach
  </ul>
</div>