<!-- Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8 m-4">
  @foreach ($articles as $article)
  <div
    class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xs overflow-hidden  transition-shadow duration-300 transform hover:-translate-y-1">
    @if($article->featured_image)
    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
      class="w-full h-56 sm:h-64 md:h-56 lg:h-48 object-cover" loading="lazy">
    @else
    <img src="{{ asset('images/default-placeholder.png') }}" alt="Default Image"
      class="w-full h-56 sm:h-64 md:h-56 lg:h-48 object-cover bg-gray-200" loading="lazy">
    @endif
    <div class="p-6">
      <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
        <a href="{{ route('articles.show', $article->slug) }}"
          class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-150">{{ $article->title }}</a>
      </h3>
      <p class="text-gray-600 dark:text-gray-300 mb-4 flex-grow">{{ Str::limit($article->excerpt, 120) }}</p>
      <div class="flex items-center justify-between mt-auto">
        <div class="text-sm text-gray-500 dark:text-gray-400">
          <span>{{ $article->created_at->format('M d, Y') }}</span>
          <span class="mx-2">•</span>
          <span>{{ $article->views }} views</span>
        </div>
        <a href="{{ route('articles.show', $article->slug) }}"
          class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-full text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
          Read More
          <svg class="ml-2 -mr-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
          </svg>
        </a>
      </div>
    </div>
  </div>
  @endforeach
</div>