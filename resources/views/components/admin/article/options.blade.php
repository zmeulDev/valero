@props(['article'])

<div class="space-y-6">
    <!-- External Links Section -->
    <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-lg p-6 border border-blue-100 dark:border-blue-800/50">
        <div class="flex items-center mb-4">
            <div class="bg-blue-100 dark:bg-blue-900/50 p-2 rounded-lg">
                <x-lucide-link class="w-5 h-5 text-blue-600 dark:text-blue-400" />
            </div>
            <div class="ml-3">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                    {{ __('admin.articles.external_links') }}
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('admin.articles.external_links_description') }}
                </p>
            </div>
        </div>

        <div class="space-y-4">
            <!-- YouTube Link -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 hover:border-red-300 dark:hover:border-red-700 transition-colors duration-200">
                <label for="youtube_link" class="flex items-center text-sm font-medium text-gray-900 dark:text-white mb-2">
                    <div class="bg-red-100 dark:bg-red-900/30 p-1.5 rounded mr-2">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </div>
                    YouTube
                    <span class="ml-auto text-xs text-gray-500 dark:text-gray-400 font-normal">{{ __('admin.common.optional') }}</span>
                </label>
                <div class="relative">
                    <input type="url" 
                           id="youtube_link" 
                           name="youtube_link" 
                           class="w-full pl-4 pr-10 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors" 
                           value="{{ old('youtube_link', $article?->youtube_link) }}"
                           placeholder="https://youtube.com/watch?v=...">
                    @if(old('youtube_link', $article?->youtube_link))
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <x-lucide-check-circle class="w-5 h-5 text-green-500" />
                        </div>
                    @endif
                </div>
                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                    {{ __('admin.articles.youtube_help') }}
                </p>
            </div>

            <!-- Instagram Link -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 hover:border-pink-300 dark:hover:border-pink-700 transition-colors duration-200">
                <label for="instagram_link" class="flex items-center text-sm font-medium text-gray-900 dark:text-white mb-2">
                    <div class="bg-gradient-to-br from-purple-500 via-pink-500 to-orange-500 p-1.5 rounded mr-2">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>
                    Instagram
                    <span class="ml-auto text-xs text-gray-500 dark:text-gray-400 font-normal">{{ __('admin.common.optional') }}</span>
                </label>
                <div class="relative">
                    <input type="url" 
                           id="instagram_link" 
                           name="instagram_link" 
                           class="w-full pl-4 pr-10 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors" 
                           value="{{ old('instagram_link', $article?->instagram_link) }}"
                           placeholder="https://instagram.com/p/...">
                    @if(old('instagram_link', $article?->instagram_link))
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <x-lucide-check-circle class="w-5 h-5 text-green-500" />
                        </div>
                    @endif
                </div>
                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                    {{ __('admin.articles.instagram_help') }}
                </p>
            </div>

            <!-- Local Store Link -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 hover:border-green-300 dark:hover:border-green-700 transition-colors duration-200">
                <label for="local_store_link" class="flex items-center text-sm font-medium text-gray-900 dark:text-white mb-2">
                    <div class="bg-green-100 dark:bg-green-900/30 p-1.5 rounded mr-2">
                        <x-lucide-shopping-bag class="w-4 h-4 text-green-600 dark:text-green-400" />
                    </div>
                    {{ __('admin.articles.local_store_link') }}
                    <span class="ml-auto text-xs text-gray-500 dark:text-gray-400 font-normal">{{ __('admin.common.optional') }}</span>
                </label>
                <div class="relative">
                    <input type="url" 
                           id="local_store_link" 
                           name="local_store_link" 
                           class="w-full pl-4 pr-10 py-2.5 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors" 
                           value="{{ old('local_store_link', $article?->local_store_link) }}"
                           placeholder="https://example.com/product/...">
                    @if(old('local_store_link', $article?->local_store_link))
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <x-lucide-check-circle class="w-5 h-5 text-green-500" />
                        </div>
                    @endif
                </div>
                <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                    {{ __('admin.articles.local_store_help') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Bookmarks Section -->
    <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700"
         x-data="{
             bookmarks: [],
             allCategories: [],
             selectedCategory: '',
             searchQuery: '',
             loading: true,
             copiedId: null,
             expandedNotes: {},
             currentPage: 1,
             lastPage: 1,
             total: 0,
             perPage: 6,
             from: 0,
             to: 0,
             
             async init() {
                 await this.loadCategories();
                 await this.loadBookmarks();
             },
             
             async loadCategories() {
                 try {
                     const response = await fetch('{{ route('admin.bookmarks.all') }}?per_page=1000');
                     const data = await response.json();
                     const cats = [...new Set(data.data.map(b => b.category).filter(c => c))];
                     this.allCategories = cats.sort();
                 } catch (error) {
                     console.error('Error loading categories:', error);
                 }
             },
             
             async loadBookmarks(page = 1) {
                 this.loading = true;
                 try {
                     const params = new URLSearchParams({
                         page: page,
                         per_page: this.perPage
                     });
                     
                     if (this.selectedCategory) {
                         params.append('category', this.selectedCategory);
                     }
                     
                     if (this.searchQuery.trim()) {
                         params.append('search', this.searchQuery.trim());
                     }
                     
                     const response = await fetch(`{{ route('admin.bookmarks.all') }}?${params}`);
                     const data = await response.json();
                     
                     this.bookmarks = data.data;
                     this.currentPage = data.current_page;
                     this.lastPage = data.last_page;
                     this.total = data.total;
                     this.from = data.from || 0;
                     this.to = data.to || 0;
                     this.loading = false;
                 } catch (error) {
                     console.error('Error loading bookmarks:', error);
                     this.loading = false;
                 }
             },
             
             async changePage(page) {
                 if (page < 1 || page > this.lastPage || page === this.currentPage) return;
                 await this.loadBookmarks(page);
                 // Scroll to top of bookmarks section
                 this.$el.scrollIntoView({ behavior: 'smooth', block: 'start' });
             },
             
             async applyFilters() {
                 this.currentPage = 1;
                 await this.loadBookmarks(1);
             },
             
             get filteredBookmarks() {
                 return this.bookmarks;
             },
             
             copyToClipboard(text, id) {
                 if (!text) return;
                 
                 // Try modern Clipboard API first (requires HTTPS)
                 if (navigator.clipboard && navigator.clipboard.writeText) {
                     navigator.clipboard.writeText(text).then(() => {
                         this.copiedId = id;
                         setTimeout(() => this.copiedId = null, 2000);
                     }).catch(err => {
                         console.error('Clipboard API failed:', err);
                         this.fallbackCopy(text, id);
                     });
                 } else {
                     // Fallback for HTTP or unsupported browsers
                     this.fallbackCopy(text, id);
                 }
             },
             
             fallbackCopy(text, id) {
                 // Create temporary textarea
                 const textarea = document.createElement('textarea');
                 textarea.value = text;
                 textarea.style.position = 'fixed';
                 textarea.style.opacity = '0';
                 document.body.appendChild(textarea);
                 textarea.select();
                 
                 try {
                     document.execCommand('copy');
                     this.copiedId = id;
                     setTimeout(() => this.copiedId = null, 2000);
                 } catch (err) {
                     console.error('Fallback copy failed:', err);
                 } finally {
                     document.body.removeChild(textarea);
                 }
             },
             
             toggleNotes(id) {
                 this.expandedNotes[id] = !this.expandedNotes[id];
             },
             
             isNoteExpanded(id) {
                 return this.expandedNotes[id] || false;
             }
         }"
         x-init="init()"
         @category-changed.window="applyFilters()"
         @search-changed.window="applyFilters()">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-lg p-4 mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-indigo-100 dark:bg-indigo-900/50 p-2 rounded-lg">
                        <x-lucide-bookmark class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ __('admin.bookmarks.bookmarks_library') }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('admin.bookmarks.quick_access_description') }}
                        </p>
                    </div>
                </div>
                <a href="{{ route('admin.bookmarks.create') }}" 
                   target="_blank"
                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-colors duration-200">
                    <x-lucide-plus class="w-4 h-4 mr-1.5" />
                    {{ __('admin.common.create') }}
                </a>
            </div>
        </div>

        <!-- Loading State -->
        <div x-show="loading" x-cloak class="flex flex-col items-center justify-center py-12">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-indigo-500 mb-3"></div>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.common.loading') }}</p>
        </div>

        <!-- Empty State -->
        <div x-show="!loading && bookmarks.length === 0" x-cloak class="text-center py-12 bg-gray-50 dark:bg-gray-800/50 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-700">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                <x-lucide-bookmark class="w-8 h-8 text-gray-400" />
            </div>
            <h3 class="text-base font-medium text-gray-900 dark:text-white mb-2">{{ __('admin.bookmarks.no_bookmarks') }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 max-w-sm mx-auto">
                {{ __('admin.bookmarks.create_first_bookmark_description') }}
            </p>
            <a href="{{ route('admin.bookmarks.create') }}" 
               target="_blank"
               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200">
                <x-lucide-plus-circle class="w-5 h-5 mr-2" />
                {{ __('admin.bookmarks.new_bookmark') }}
            </a>
        </div>

        <!-- Bookmarks Interface -->
        <div x-show="!loading && bookmarks.length > 0" x-cloak>
            <!-- Search and Filters -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 mb-4">
                <div class="flex flex-col sm:flex-row gap-3">
                    <!-- Search -->
                    <div class="flex-1">
                        <div class="relative">
                            <x-lucide-search class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" />
                            <input type="text" 
                                   x-model.debounce.500ms="searchQuery"
                                   @input="applyFilters()"
                                   placeholder="{{ __('admin.bookmarks.search_bookmarks') }}"
                                   class="w-full pl-10 pr-10 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors">
                            <button x-show="searchQuery" 
                                    @click="searchQuery = ''; applyFilters()"
                                    type="button"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <x-lucide-x class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                    
                    <!-- Category Pills -->
                    <div class="flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0">
                        <button @click="selectedCategory = ''; applyFilters()"
                                :class="!selectedCategory ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                                class="px-3 py-1.5 text-xs font-medium rounded-full whitespace-nowrap transition-colors duration-200">
                            {{ __('admin.bookmarks.all') }} (<span x-text="total"></span>)
                        </button>
                        <template x-for="category in allCategories" :key="category">
                            <button @click="selectedCategory = category; applyFilters()"
                                    :class="selectedCategory === category ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600'"
                                    class="px-3 py-1.5 text-xs font-medium rounded-full whitespace-nowrap transition-colors duration-200">
                                <span x-text="category"></span>
                            </button>
                        </template>
                    </div>
                </div>
                
                <!-- Results Count -->
                <div x-show="total > 0" class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ __('admin.bookmarks.showing') }} <span class="font-semibold text-gray-900 dark:text-white" x-text="from"></span> 
                        {{ __('admin.bookmarks.to') }} <span class="font-semibold text-gray-900 dark:text-white" x-text="to"></span> 
                        {{ __('admin.bookmarks.of') }} <span class="font-semibold text-gray-900 dark:text-white" x-text="total"></span> 
                        {{ __('admin.bookmarks.bookmarks') }}
                    </p>
                </div>
            </div>

            <!-- No Results -->
            <div x-show="filteredBookmarks.length === 0" x-cloak class="text-center py-8 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                <x-lucide-search class="mx-auto h-10 w-10 text-gray-400 mb-3" />
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.bookmarks.no_results') }}</p>
            </div>

            <!-- Bookmarks Grid -->
            <div x-show="filteredBookmarks.length > 0" class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                <template x-for="bookmark in filteredBookmarks" :key="bookmark.id">
                    <div class="group bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600 hover:shadow-lg transition-all duration-200">
                        <div class="p-4">
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h5 class="text-sm font-semibold text-gray-900 dark:text-white truncate" x-text="bookmark.title"></h5>
                                        <span x-show="bookmark.category" 
                                              class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 whitespace-nowrap">
                                            <x-lucide-tag class="w-3 h-3 mr-1" />
                                            <span x-text="bookmark.category"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Link Section -->
                            <div x-show="bookmark.link" class="mb-3">
                                <div class="flex items-center gap-2 bg-gray-50 dark:bg-gray-900/50 rounded-lg p-2.5 group/link">
                                    <x-lucide-link class="w-4 h-4 text-gray-400 flex-shrink-0" />
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs text-gray-600 dark:text-gray-400 truncate" x-text="bookmark.link"></p>
                                    </div>
                                    <button @click="copyToClipboard(bookmark.link, 'link-' + bookmark.id)"
                                            type="button"
                                            class="flex-shrink-0 p-1.5 rounded-md text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:text-indigo-400 dark:hover:bg-indigo-900/30 transition-colors duration-150">
                                        <x-lucide-copy class="w-4 h-4" x-show="copiedId !== 'link-' + bookmark.id" />
                                        <x-lucide-check class="w-4 h-4 text-green-600 dark:text-green-400" x-show="copiedId === 'link-' + bookmark.id" />
                                    </button>
                                </div>
                                <div x-show="copiedId === 'link-' + bookmark.id" 
                                     x-transition
                                     class="mt-1 text-xs text-green-600 dark:text-green-400 font-medium flex items-center">
                                    <x-lucide-check-circle class="w-3 h-3 mr-1" />
                                    {{ __('admin.bookmarks.copied') }}
                                </div>
                            </div>
                            
                            <!-- Notes Section -->
                            <div x-show="bookmark.notes" class="mb-3">
                                <div class="bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-800/50 rounded-lg p-2.5">
                                    <div class="flex items-start gap-2">
                                        <x-lucide-sticky-note class="w-4 h-4 text-yellow-600 dark:text-yellow-500 flex-shrink-0 mt-0.5" />
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed"
                                               :class="!isNoteExpanded(bookmark.id) ? 'line-clamp-2' : ''"
                                               x-text="bookmark.notes"></p>
                                            <button x-show="bookmark.notes && bookmark.notes.length > 100"
                                                    @click="toggleNotes(bookmark.id)"
                                                    type="button"
                                                    class="mt-1 text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium">
                                                <span x-show="!isNoteExpanded(bookmark.id)">{{ __('admin.bookmarks.show_more') }}</span>
                                                <span x-show="isNoteExpanded(bookmark.id)">{{ __('admin.bookmarks.show_less') }}</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center gap-2 pt-3 border-t border-gray-100 dark:border-gray-700">
                                <button x-show="bookmark.link"
                                        @click="copyToClipboard(bookmark.link, bookmark.id)"
                                        type="button"
                                        class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-medium text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 rounded-lg transition-colors duration-150">
                                        <x-lucide-clipboard class="w-3.5 h-3.5 mr-1.5" x-show="copiedId !== bookmark.id" />
                                        <x-lucide-check class="w-3.5 h-3.5 mr-1.5 text-green-600" x-show="copiedId === bookmark.id" />
                                        <span x-show="copiedId !== bookmark.id">{{ __('admin.bookmarks.copy_link') }}</span>
                                        <span x-show="copiedId === bookmark.id">{{ __('admin.bookmarks.copied') }}!</span>
                                    </button>
                                    <a :href="`{{ route('admin.bookmarks.index') }}/${bookmark.id}/edit`"
                                       target="_blank"
                                       class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-150"
                                       title="{{ __('admin.common.edit') }}">
                                        <x-lucide-pencil class="w-4 h-4" />
                                    </a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            
            <!-- Pagination -->
            <div x-show="lastPage > 1" class="mt-6 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <button @click="changePage(1)" 
                            :disabled="currentPage === 1"
                            :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-700'"
                            class="p-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 transition-colors duration-150">
                        <x-lucide-chevrons-left class="w-4 h-4" />
                    </button>
                    <button @click="changePage(currentPage - 1)" 
                            :disabled="currentPage === 1"
                            :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-700'"
                            class="p-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 transition-colors duration-150">
                        <x-lucide-chevron-left class="w-4 h-4" />
                    </button>
                </div>
                
                <div class="flex items-center gap-1">
                    <template x-for="page in Array.from({length: lastPage}, (_, i) => i + 1).filter(p => {
                        if (lastPage <= 7) return true;
                        if (p === 1 || p === lastPage) return true;
                        if (p >= currentPage - 1 && p <= currentPage + 1) return true;
                        if (p === 2 && currentPage <= 3) return true;
                        if (p === lastPage - 1 && currentPage >= lastPage - 2) return true;
                        return false;
                    })" :key="page">
                        <div>
                            <span x-show="page > 1 && !Array.from({length: lastPage}, (_, i) => i + 1).filter(p => {
                                if (lastPage <= 7) return true;
                                if (p === 1 || p === lastPage) return true;
                                if (p >= currentPage - 1 && p <= currentPage + 1) return true;
                                if (p === 2 && currentPage <= 3) return true;
                                if (p === lastPage - 1 && currentPage >= lastPage - 2) return true;
                                return false;
                            }).includes(page - 1)" class="px-2 text-gray-400">...</span>
                            <button @click="changePage(page)"
                                    :class="currentPage === page ? 'bg-indigo-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'"
                                    class="min-w-[2rem] px-3 py-2 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 transition-colors duration-150"
                                    x-text="page"></button>
                        </div>
                    </template>
                </div>
                
                <div class="flex items-center gap-2">
                    <button @click="changePage(currentPage + 1)" 
                            :disabled="currentPage === lastPage"
                            :class="currentPage === lastPage ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-700'"
                            class="p-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 transition-colors duration-150">
                        <x-lucide-chevron-right class="w-4 h-4" />
                    </button>
                    <button @click="changePage(lastPage)" 
                            :disabled="currentPage === lastPage"
                            :class="currentPage === lastPage ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-700'"
                            class="p-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 transition-colors duration-150">
                        <x-lucide-chevrons-right class="w-4 h-4" />
                    </button>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="mt-4 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                <div class="flex items-center gap-1">
                    <x-lucide-info class="w-3.5 h-3.5" />
                    <span>{{ __('admin.bookmarks.click_to_copy_hint') }}</span>
                </div>
                <a href="{{ route('admin.bookmarks.index') }}" 
                   target="_blank"
                   class="inline-flex items-center gap-1 text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">
                    {{ __('admin.bookmarks.manage_all') }}
                    <x-lucide-external-link class="w-3.5 h-3.5" />
                </a>
            </div>
        </div>
    </div>
</div>
