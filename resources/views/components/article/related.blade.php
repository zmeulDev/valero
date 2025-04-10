<div class="mt-16">
    {{-- Section Header with improved styling --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-3">
            <h3 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">
                {{ __('frontend.article.related_articles') }}
            </h3>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                {{ $relatedArticles->count() }} {{ __('frontend.article.articles') }}
            </span>
        </div>
        <div class="h-[2px] flex-1 bg-gradient-to-r from-gray-200 to-transparent dark:from-gray-700 ml-6"></div>
    </div>

    @if($relatedArticles->isEmpty())
        <div class="p-8 text-center bg-gray-50 dark:bg-gray-800/50 rounded-xl border border-gray-100 dark:border-gray-700">
            <x-lucide-newspaper class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500 mb-4" />
            <p class="text-gray-500 dark:text-gray-400">{{ __('frontend.article.no_related_articles_found_in_this_category') }}</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($relatedArticles as $relatedArticle)
                <a href="{{ route('articles.index', $relatedArticle->slug) }}" 
                   class="group relative flex flex-col bg-white dark:bg-gray-800 rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-gray-200/50 dark:hover:shadow-black/30 border border-gray-100 dark:border-gray-700 hover:border-indigo-200 dark:hover:border-indigo-800">
                    <!-- Image Container with improved hover effect -->
                    <div class="relative aspect-[16/9] overflow-hidden">
                        @if($relatedArticle->media->firstWhere('is_cover', true)->image_path ?? false)
                            <x-article.has-image :article="$relatedArticle" />
                        @else
                            <x-article.no-image />
                        @endif
                        <!-- Enhanced Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        
                        <!-- Category Badge - Moved to overlay for better visibility -->
                        <div class="absolute top-3 left-3 z-10">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-white/90 dark:bg-gray-900/90 text-indigo-600 dark:text-indigo-400 rounded-full shadow-sm">
                                {{ $relatedArticle->category->name }}
                            </span>
                        </div>
                    </div>

                    <!-- Content with improved spacing and typography -->
                    <div class="flex-1 p-5">
                        <!-- Title with improved hover effect -->
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white leading-snug mb-3 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200">
                            {{ $relatedArticle->title }}
                        </h4>

                        <!-- Excerpt if available -->
                        @if($relatedArticle->excerpt)
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">
                                {{ $relatedArticle->excerpt }}
                            </p>
                        @endif

                        <!-- Meta information with improved layout -->
                        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 pt-3 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-3">
                                <time datetime="{{ $relatedArticle->created_at }}" class="flex items-center gap-1">
                                    <x-lucide-calendar class="w-3.5 h-3.5" />
                                    {{ $relatedArticle->created_at->format('M d, Y') }}
                                </time>
                                <span class="flex items-center gap-1">
                                    <x-lucide-clock class="w-3.5 h-3.5" />
                                    {{ $relatedArticle->reading_time ?? __('frontend.article.5_min_read') }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-3">
                            <span class="flex items-center gap-1 text-indigo-600 dark:text-indigo-400 font-medium">
                                {{ __('frontend.article.read_more') }}
                                <x-lucide-arrow-right class="w-3.5 h-3.5 transition-transform duration-300 group-hover:translate-x-1" />
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
