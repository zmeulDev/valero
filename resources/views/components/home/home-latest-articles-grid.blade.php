<!-- Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8 m-4">
  @foreach ($articles as $article)
  <div
    class="bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded-xl shadow-xs overflow-hidden ">
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
        <x-button-action href="{{ route('articles.show', $article->slug) }}">
          Read More
          <x-lucide-arrow-right class="ml-2 -mr-1 w-4 h-4" />
        </x-button-action>
      </div>
    </div>
  </div>
  @endforeach
</div>