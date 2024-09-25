<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
  <h3 class="text-xl font-bold text-gray-900 dark:text-white px-6 py-4 border-b border-gray-200 dark:border-gray-700">
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