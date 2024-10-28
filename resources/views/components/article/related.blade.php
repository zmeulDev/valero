<div class="bg-white dark:bg-gray-800/50 backdrop-blur-xl rounded-3xl mt-8 border border-gray-100 dark:border-gray-700/50">
    <div class="px-8 py-6 border-b border-gray-100 dark:border-gray-700/50">
        <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
            Related Articles
        </h3>
    </div>

    <div class="p-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($relatedArticles as $relatedArticle)
                <a href="{{ route('articles.index', $relatedArticle->slug) }}" 
                   class="group relative flex flex-col bg-gray-50 dark:bg-gray-900/50 rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-gray-200/50 dark:hover:shadow-black/30 border border-gray-100 dark:border-gray-800">
                    <!-- Image Container -->
                    <div class="relative aspect-[16/9] overflow-hidden">
                        <img src="{{ asset('storage/' . $relatedArticle->featured_image) }}" 
                             alt="{{ $relatedArticle->title }}"
                             class="w-full h-full object-cover transition-all duration-500 group-hover:scale-110 group-hover:saturate-150">
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 p-6">
                        <!-- Category -->
                        <div class="mb-4">
                            <span class="inline-flex items-center px-3 py-1.5 text-xs font-medium bg-gradient-to-r from-indigo-500 to-purple-500 dark:from-indigo-400 dark:to-purple-400 text-white dark:text-gray-900 rounded-full">
                                {{ $relatedArticle->category->name }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white leading-snug mb-3 line-clamp-2 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-indigo-500 group-hover:to-purple-500 dark:group-hover:from-indigo-400 dark:group-hover:to-purple-400 transition-all duration-200">
                            {{ $relatedArticle->title }}
                        </h4>

                        <!-- Date and Reading Time -->
                        <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                            <time datetime="{{ $relatedArticle->created_at }}" class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $relatedArticle->created_at->format('M d, Y') }}
                            </time>
                            <span class="flex items-center gap-1.5">
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
