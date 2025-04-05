@if($popularArticles->count() > 0)
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200/50 dark:border-gray-700/50 overflow-hidden">
    <!-- Header with improved styling -->
    <div class="p-4 border-b border-gray-200/50 dark:border-gray-700/50 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800/80">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                    Popular Articles
                </h3>
                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300">
                    {{ $popularArticles->count() }}
                </span>
            </div>
            <x-lucide-trending-up class="w-4 h-4 text-indigo-500 dark:text-indigo-400" />
        </div>
    </div>

    <!-- Articles List with improved styling -->
    <div class="divide-y divide-gray-100/50 dark:divide-gray-700/50">
        @foreach ($popularArticles as $index => $popularArticle)
            <a href="{{ route('articles.index', $popularArticle->slug) }}" 
               class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 group">
                <!-- Number Badge with improved styling -->
                <div class="flex-none">
                    <div @class([
                        'w-8 h-8 rounded-full flex items-center justify-center text-md font-medium transition-all duration-200',
                        'bg-gradient-to-br from-indigo-500 to-purple-500 text-white shadow-sm shadow-indigo-200 dark:shadow-indigo-900/30' => $index === 0,
                        'bg-gradient-to-br from-indigo-100 to-purple-100 text-indigo-600 dark:from-indigo-900/30 dark:to-purple-900/30 dark:text-indigo-300' => $index === 1,
                        'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' => $index > 1,
                    ])>
                        {{ $index + 1 }}
                    </div>
                </div>

                <!-- Content with improved layout -->
                <div class="flex-1 min-w-0">
                    <!-- Category Badge -->
                    <div class="mb-1">
                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                            {{ $popularArticle->category->name }}
                        </span>
                    </div>
                    
                    <!-- Title with improved hover effect -->
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-1.5 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200">
                        {{ $popularArticle->title }}
                    </h4>
                    
                    <!-- Meta information with improved layout -->
                    <div class="flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                        <span class="flex items-center gap-1">
                            <x-lucide-eye class="w-3.5 h-3.5" />
                            {{ number_format($popularArticle->views) }}
                        </span>
                        <span class="flex items-center gap-1">
                            <x-lucide-clock class="w-3.5 h-3.5" />
                            {{ $popularArticle->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>

                <!-- Arrow Icon with improved animation -->
                <div class="flex-none text-gray-400 dark:text-gray-600 group-hover:text-indigo-500 dark:group-hover:text-indigo-400 transition-colors duration-200">
                    <x-lucide-chevron-right class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" />
                </div>
            </a>
        @endforeach
    </div>
    
    <!-- Footer with view all link -->
    <div class="p-3 border-t border-gray-100/50 dark:border-gray-700/50 bg-gray-50/50 dark:bg-gray-800/50">
        <a href="{{ route('home') }}" class="flex items-center justify-center gap-1.5 text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors duration-200">
            Go back to home
            <x-lucide-home class="w-3.5 h-3.5" />
        </a>
    </div>
</div>
@endif