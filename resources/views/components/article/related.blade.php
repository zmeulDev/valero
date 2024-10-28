<div class="bg-white dark:bg-gray-800 rounded-2xl mt-8 overflow-hidden">
    <div class="px-6 py-6 border-b border-gray-100 dark:border-gray-700">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
            Related Articles
        </h3>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($relatedArticles as $relatedArticle)
                <a href="{{ route('articles.index', $relatedArticle->slug) }}" 
                   class="group relative flex flex-col bg-gray-50 dark:bg-gray-900 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <!-- Image Container -->
                    <div class="relative aspect-[16/9] overflow-hidden">
                        <img src="{{ asset('storage/' . $relatedArticle->featured_image) }}" 
                             alt="{{ $relatedArticle->title }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 p-5">
                        <!-- Category -->
                        <div class="mb-3">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 rounded-full">
                                {{ $relatedArticle->category->name }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white leading-snug mb-2 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200">
                            {{ $relatedArticle->title }}
                        </h4>

                        <!-- Date and Reading Time -->
                        <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                            <time datetime="{{ $relatedArticle->created_at }}">
                                {{ $relatedArticle->created_at->format('M d, Y') }}
                            </time>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $relatedArticle->reading_time ?? '5 min read' }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
