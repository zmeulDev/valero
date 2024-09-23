@props(['articles', 'query', 'category'])

@php
use Illuminate\Support\Str;

function highlight($text, $term) {
return preg_replace("/({$term})/i", '<mark class="bg-yellow-300 dark:bg-yellow-500 rounded px-1">$1</mark>', $text);
}
@endphp

<x-app-layout>
  <x-slot name="title">Search Results for "{{ $query }}"</x-slot>

  <div class="container mx-auto px-4 lg:px-8 py-12">
    <!-- Search Results Header -->
    <div class="flex flex-col md:flex-row items-center justify-between mb-8">
      <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
        Search Results for "{{ $query }}"
        @if($category)
        in "{{ $articles->first()->category->name ?? 'Selected Category' }}"
        @endif
      </h1>
      <!-- Optional: Sorting Dropdown -->
      <div class="mt-4 md:mt-0">
        <label for="sort" class="mr-2 text-gray-700 dark:text-gray-300">Sort by:</label>
        <select id="sort" name="sort" onchange="location = this.value;"
          class="px-8 py-2 border dark:text-gray-700 border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="{{ request()->fullUrlWithQuery(['sort' => 'relevance']) }}"
            {{ request('sort') == 'relevance' ? 'selected' : '' }}>Relevance</option>
          <option value="{{ request()->fullUrlWithQuery(['sort' => 'date_asc']) }}"
            {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Oldest</option>
          <option value="{{ request()->fullUrlWithQuery(['sort' => 'date_desc']) }}"
            {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Newest</option>
        </select>
      </div>
    </div>

    <!-- Search Results Grid -->
    @if ($articles->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach ($articles as $article)
      <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-1">
        @if($article->featured_image)
        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
          class="w-full h-56 sm:h-64 md:h-56 lg:h-48 object-cover" loading="lazy">
        @else
        <img src="{{ asset('images/default-placeholder.png') }}" alt="Default Image"
          class="w-full h-56 sm:h-64 md:h-56 lg:h-48 object-cover bg-gray-200" loading="lazy">
        @endif
        <div class="p-6">
          <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-2">
            <a href="{{ route('articles.show', $article->slug) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
              {!! highlight($article->title, $query) !!}
            </a>
          </h2>
          <div class="flex items-center text-gray-600 dark:text-gray-400 mb-4">
            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M6 2a1 1 0 000 2v1H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V6a2 2 0 00-2-2h-1V4a1 1 0 10-2 0v1H8V4a1 1 0 00-2 0V2a1 1 0 10-2 0v1z"
                clip-rule="evenodd" />
            </svg>
            <span>{{ $article->created_at->format('M d, Y') }}</span>
          </div>
          <p class="text-gray-700 dark:text-gray-300 mb-4">
            {!! highlight(Str::limit($article->content, 100, '...'), $query) !!}
          </p>
          <a href="{{ route('articles.show', $article->slug) }}"
            class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-colors">
            Read More
          </a>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Pagination Links -->
    <div class="mt-12 flex justify-center">
      {{ $articles->links() }}
    </div>
    @else
    <div class="text-center mt-20">
      <svg class="mx-auto mb-4 w-12 h-12 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor"
        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M8 16h.01M12 16h.01M16 16h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
      <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-2">No Results Found</h2>
      <p class="text-gray-600 dark:text-gray-300">Try adjusting your search or use different keywords.</p>
      <!-- Optional: Link to Home or Advanced Search -->
      <div class="mt-6">
        <a href="{{ url()->previous() }}" class="text-blue-600 dark:text-blue-400 hover:underline">
          Go Back
        </a>
      </div>
    </div>
    @endif
  </div>
</x-app-layout>