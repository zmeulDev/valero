@props(['article' => null])

<div x-data="mediaLibrary({{ $article?->id ?? 'null' }})" 
     x-show="open" 
     x-cloak
     @open-media-library.window="openLibrary()"
     @keydown.escape.window="closeLibrary()"
     class="fixed inset-0 z-50 overflow-y-auto"
     aria-labelledby="modal-title" 
     role="dialog" 
     aria-modal="true"
     style="display: none;">
    
    <!-- Backdrop -->
    <div x-show="open" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/75 backdrop-blur-sm transition-opacity"
         @click="closeLibrary()"></div>

    <!-- Modal Content -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-7xl max-h-[90vh] flex flex-col"
             @click.stop>
            
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <x-lucide-images class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                    <h2 id="modal-title" class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('admin.articles.media_library') }}
                    </h2>
                </div>
                
                <button type="button" 
                        @click="closeLibrary()"
                        class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                    <x-lucide-x class="w-6 h-6" />
                </button>
            </div>

            <!-- Search and Filters -->
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                <div class="flex items-center gap-3">
                    <div class="flex-1 relative">
                        <x-lucide-search class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" />
                        <input type="text" 
                               x-model="searchQuery"
                               @input.debounce.500ms="fetchMedia()"
                               placeholder="{{ __('admin.articles.search_media') }}"
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent">
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            <span x-text="selectedMedia.length"></span> {{ __('admin.articles.selected') }}
                        </span>
                        <button type="button" 
                                x-show="selectedMedia.length > 0"
                                @click="clearSelection()"
                                class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                            {{ __('admin.articles.clear') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Media Grid -->
            <div class="flex-1 overflow-y-auto p-6">
                <!-- Loading State -->
                <div x-show="loading" class="flex items-center justify-center py-12">
                    <div class="flex flex-col items-center gap-3">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 dark:border-indigo-400"></div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.articles.loading') }}</p>
                    </div>
                </div>

                <!-- Empty State -->
                <div x-show="!loading && mediaItems.length === 0" class="flex flex-col items-center justify-center py-12">
                    <x-lucide-image-off class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" />
                    <p class="text-gray-500 dark:text-gray-400">{{ __('admin.articles.no_media_found') }}</p>
                </div>

                <!-- Media Grid -->
                <div x-show="!loading && mediaItems.length > 0" 
                     class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <template x-for="media in mediaItems" :key="media.id">
                        <div @click="toggleSelection(media)" 
                             :class="{ 
                                 'ring-4 ring-indigo-500 dark:ring-indigo-400': isSelected(media.id),
                                 'ring-2 ring-transparent hover:ring-gray-300 dark:hover:ring-gray-600': !isSelected(media.id)
                             }"
                             class="relative group cursor-pointer rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900 aspect-square transition-all duration-200">
                            
                            <!-- Image -->
                            <img :src="media.url" 
                                 :alt="media.filename"
                                 class="w-full h-full object-cover">
                            
                            <!-- Selection Overlay -->
                            <div :class="{ 'opacity-100': isSelected(media.id), 'opacity-0 group-hover:opacity-100': !isSelected(media.id) }"
                                 class="absolute inset-0 bg-black/40 flex items-center justify-center transition-opacity">
                                <div x-show="isSelected(media.id)" 
                                     class="w-10 h-10 bg-indigo-600 dark:bg-indigo-500 rounded-full flex items-center justify-center">
                                    <x-lucide-check class="w-6 h-6 text-white" />
                                </div>
                            </div>
                            
                            <!-- Info Overlay (bottom) -->
                            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 to-transparent p-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <p class="text-xs text-white truncate" x-text="media.filename"></p>
                                <p class="text-xs text-gray-300" x-text="media.dimensions?.width + 'x' + media.dimensions?.height"></p>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Load More -->
                <div x-show="hasMorePages" class="mt-6 text-center">
                    <button type="button" 
                            @click="loadMore()"
                            :disabled="loading"
                            class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ __('admin.articles.load_more') }}
                    </button>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-between px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <span x-text="selectedMedia.length"></span> {{ __('admin.articles.images_selected') }}
                </p>
                
                <div class="flex items-center gap-3">
                    <button type="button" 
                            @click="closeLibrary()"
                            class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                        {{ __('admin.articles.cancel') }}
                    </button>
                    <button type="button" 
                            @click="attachSelectedMedia()"
                            :disabled="selectedMedia.length === 0 || attaching"
                            class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!attaching">{{ __('admin.articles.attach_selected') }}</span>
                        <span x-show="attaching">{{ __('admin.articles.attaching') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

