<!-- Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8 m-4">
  @foreach ($articles as $article)
  <article class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-gray-100 dark:border-gray-700">
    <!-- Image Container -->
    <div class="relative aspect-[16/9] overflow-hidden border-b border-gray-100 dark:border-gray-700">
    @if($article->media->firstWhere('is_cover', true)->image_path ?? false)
      <x-article.has-image :article="$article" />
    @else
      <x-article.no-image />
    @endif
    </div>

    <!-- Content -->
    <div class="p-6">
      <!-- Meta Information -->
      <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400 mb-4 pb-3 border-b border-gray-50 dark:border-gray-700/50">
      <span class="flex items-center gap-1.5">
      {{ $article->user->name }}
      </span>
      <div class="h-4 w-px bg-gray-100 dark:bg-gray-700"></div>
      <time datetime="{{ $article->created_at }}" class="flex items-center gap-1.5">
          <x-lucide-calendar class="w-4 h-4" />
          {{ $article->created_at->format('M d, Y') }}
        </time>
        <div class="h-4 w-px bg-gray-100 dark:bg-gray-700"></div>
        <span class="flex items-center gap-1.5">
          <x-lucide-eye class="w-4 h-4" />
          {{ number_format($article->views) }} {{ __('frontend.common.views') }}
        </span>
      </div>

      <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-300">
        <a href="{{ route('articles.index', $article->slug) }}">
          {{ $article->title }}
        </a>
      </h3>

      <p class="text-gray-600 dark:text-gray-300 mb-6 line-clamp-2">
        {{ $article->excerpt }}
      </p>

      <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
        <div class="flex items-center gap-4">

          <!-- Category -->
          <a href="{{ route('category.index', $article->category->slug) }}" 
             class="group/category flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                   d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
            </svg>
            {{ $article->category->name }}
          </a>
        </div>

        <x-button-action href="{{ route('articles.index', $article->slug) }}"
            class="group/btn inline-flex items-center gap-2 text-sm font-semibold transition-colors duration-200">
            {{ __('frontend.article.read_more') }}
            <x-lucide-arrow-right class="w-4 h-4 transition-transform duration-300 group-hover/btn:translate-x-0.5" />
        </x-button-action>
      </div>
    </div>
  </article>
  @endforeach
</div>
