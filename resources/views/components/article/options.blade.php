@props(['article'])

@if($article->amazon_link || $article->ebay_link || $article->local_store_link || $article->lowest_price || $article->average_price)
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-xs overflow-hidden mb-8">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">For your convenience</h3>
            <div class="flex items-center space-x-2">
                <x-lucide-tag class="w-5 h-5 text-gray-400" />
                <span class="text-sm text-gray-500 dark:text-gray-400">Shop now</span>
            </div>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Store Options -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 flex-grow">
                <!-- YouTube Option --> 
                @if($article->youtube_link)
                <a href="{{ $article->youtube_link }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="group relative flex flex-col items-center justify-center p-6 bg-gradient-to-br from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-orange-500 dark:hover:border-orange-500 transition-all duration-200 shadow-sm hover:shadow-md h-full">
                    <div class="absolute top-2 right-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                            YouTube
                        </span>
                    </div>
                    <div class="flex flex-col items-center justify-center text-center">
                        <img src="{{ asset('storage/brand/youtube-logo.jpg') }}" 
                             alt="YouTube" 
                             class="h-10 mb-3 group-hover:scale-105 transition-transform duration-200">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-orange-600 dark:group-hover:text-orange-400">Watch on YouTube</span>
                    </div>
                </a>
                @endif

                <!-- Instagram Option -->
                @if($article->instagram_link)
                <a href="{{ $article->instagram_link }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="group relative flex flex-col items-center justify-center p-6 bg-gradient-to-br from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-red-500 dark:hover:border-red-500 transition-all duration-200 shadow-sm hover:shadow-md h-full">
                    <div class="absolute top-2 right-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                            Instagram
                        </span>
                    </div>
                    <div class="flex flex-col items-center justify-center text-center">
                        <img src="{{ asset('storage/brand/instagram-logo.jpg') }}" 
                             alt="Instagram" 
                             class="h-10 mb-3 group-hover:scale-105 transition-transform duration-200">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-red-600 dark:group-hover:text-red-400">Follow on Instagram</span>
                    </div>
                </a>
                @endif

                <!-- Local Store Option -->
                @if($article->local_store_link)
                <a href="{{ $article->local_store_link }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="group relative flex flex-col items-center justify-center p-6 bg-gradient-to-br from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md h-full">
                    <div class="absolute top-2 right-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                            Buy now
                        </span>
                    </div>
                    <div class="flex flex-col items-center justify-center text-center">
                        <x-lucide-store class="w-10 h-10 mb-3 text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 group-hover:scale-105 transition-all duration-200" />
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400">Local Store</span>
                    </div>
                </a>
                @endif
            </div>
        </div>

        <!-- Disclaimer -->
        <div class="mt-6 flex items-start space-x-2 text-xs text-gray-500 dark:text-gray-400">
            <x-lucide-info class="w-4 h-4 mt-0.5 flex-shrink-0" />
            <p>
                Prices and availability are subject to change. We may earn a commission from purchases made through these links. 
                Last updated: {{ now()->format('M d, Y') }}
            </p>
        </div>
    </div>
</div>
@endif 