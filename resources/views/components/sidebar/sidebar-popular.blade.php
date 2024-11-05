@if($popularArticles->count() > 0)
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200/50 dark:border-gray-700/50">
    <!-- Header -->
    <div class="p-4 border-b border-gray-200/50 dark:border-gray-700/50">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                Popular Articles
            </h3>
            <x-lucide-trending-up class="w-4 h-4 text-gray-400" />
        </div>
    </div>

    <!-- Articles List -->
    <div class="divide-y divide-gray-100/50 dark:divide-gray-700/50">
        @foreach ($popularArticles as $index => $popularArticle)
            <a href="{{ route('articles.index', $popularArticle->slug) }}" 
               class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                <!-- Number Badge -->
                <div class="flex-none">
                    <div @class([
                        'w-8 h-8 rounded-full flex items-center justify-center text-md font-medium',
                        'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400' => $index === 0,
                        'bg-gray-50 text-gray-600 dark:bg-gray-700 dark:text-gray-400' => $index !== 0,
                    ])>
                        {{ $index + 1 }}
                    </div>
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-1 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        {{ $popularArticle->title }}
                    </h4>
                    
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

                <!-- Arrow Icon -->
                <div class="flex-none text-gray-400 dark:text-gray-600">
                    <x-lucide-chevron-right class="w-4 h-4 transition-transform group-hover:translate-x-0.5" />
                </div>
            </a>
        @endforeach
    </div>
</div>
@endif