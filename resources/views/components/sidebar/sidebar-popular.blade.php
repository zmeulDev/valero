@if($popularArticles->count() > 0)
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
  <h3 class="text-xl font-bold text-gray-900 dark:text-white px-6 py-4 border-b border-gray-200 dark:border-gray-700">
    Popular Articles
  </h3>
  <ul class="divide-y divide-gray-100 dark:divide-gray-700">
    @foreach ($popularArticles as $popularArticle)
    <li class="group hover:bg-gray-50 dark:hover:bg-gray-750/50 transition-all duration-300">
      <a href="{{ route('articles.index', $popularArticle->slug) }}" 
         class="flex items-start gap-4 p-4">
        <!-- Image Container -->
        <div class="relative w-20 h-20 rounded-xl overflow-hidden flex-shrink-0">
          <img src="{{ asset('storage/' . $popularArticle->featured_image) }}" 
               alt="{{ $popularArticle->title }}"
               class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
          <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
        </div>

        <!-- Content -->
        <div class="flex-1 min-w-0 py-1">
          <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-1.5 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200">
            {{ $popularArticle->title }}
          </h4>
          
          <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
            <time datetime="{{ $popularArticle->created_at }}">
              {{ $popularArticle->created_at->format('M d, Y') }}
            </time>
            <span class="flex items-center gap-1">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              {{ number_format($popularArticle->views) }} views
            </span>
          </div>
        </div>
      </a>
    </li>
    @endforeach
  </ul>
</div>
@endif