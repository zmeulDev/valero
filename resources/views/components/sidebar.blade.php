<div class="lg:col-span-1">
  <div class="sticky top-16 space-y-8">
    <aside class="space-y-8">
      <!-- Popular Articles Section -->
      <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <h3
          class="text-xl font-bold text-gray-900 dark:text-white px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          Popular Articles
        </h3>
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
          @foreach ($popularArticles as $popularArticle)
          <li class="hover:bg-gray-50 dark:hover:bg-gray-750 transition duration-150 ease-in-out">
            <a href="{{ route('articles.show', $popularArticle->slug) }}" class="flex items-center space-x-4 px-6 py-4">
              <img src="{{ asset('storage/' . $popularArticle->featured_image) }}" alt="{{ $popularArticle->title }}"
                class="w-16 h-16 object-cover rounded-md">
              <div class="flex-1 min-w-0">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $popularArticle->title }}</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $popularArticle->created_at->format('F d, Y') }}
                </p>
              </div>
            </a>
          </li>
          @endforeach
        </ul>
      </div>

      <!-- Categories Section -->
      <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <h3
          class="text-xl font-bold text-gray-900 dark:text-white px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          Categories
        </h3>
        <ul class="px-6 py-4 space-y-2">
          @foreach ($categories as $category)
          <li>
            <a href="{{ route('category.articles', $category->slug) }}"
              class="flex items-center text-sm text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition duration-150 ease-in-out">
              <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"></path>
              </svg>
              {{ $category->name }}
            </a>
          </li>
          @endforeach
        </ul>
      </div>
    </aside>
  </div>
</div>