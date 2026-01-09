<x-admin-layout>
    <div x-data="{
        showDeleteModal: false,
        itemToDelete: null,
        items: {{ $articles->items() ? json_encode($articles->items()) : '[]' }},
        isLoading: false,
        currentStatus: '{{ request('status') }}',
        currentCategory: '{{ request('category') }}',
        searchQuery: '{{ request('search') }}',

        openDeleteModal(id) {
            $dispatch('open-delete-modal', id);
        },

        init() {
            // Handle browser back/forward buttons
            window.addEventListener('popstate', (event) => {
                this.fetchArticles(window.location.search, false);
            });
        },

        async fetchArticles(params, updateUrl = true) {
            this.isLoading = true;
            try {
                // Determine params based on type
                let urlParams;
                if (typeof params === 'string' && params.startsWith('?')) {
                     urlParams = new URLSearchParams(params);
                } else if (typeof params === 'object') {
                    // Merge current state with new params
                    urlParams = new URLSearchParams(window.location.search);
                    Object.keys(params).forEach(key => {
                        if (params[key] === null || params[key] === '') {
                            urlParams.delete(key);
                        } else {
                            urlParams.set(key, params[key]);
                        }
                    });
                } else {
                     urlParams = new URLSearchParams(); // fallback
                }

                // Make the request
                const response = await axios.get(`{{ route('admin.articles.index') }}?${urlParams.toString()}`);
                
                // Update the DOM
                this.$refs.articlesContainer.innerHTML = response.data;
                
                // Update URL if requested
                if (updateUrl) {
                    const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
                    window.history.pushState({}, '', newUrl);
                }

                // Update local state for UI active states
                this.currentStatus = urlParams.get('status') || '';
                this.currentCategory = urlParams.get('category') || '';
                this.searchQuery = urlParams.get('search') || '';

                // Re-initialize any plugins if needed (e.g. tooltips) or re-bind events
                // For now, the delete modal works via global event dispatch which persists
                
            } catch (error) {
                console.error('Error fetching articles:', error);
                window.showToast('Failed to load articles', 'error');
            } finally {
                this.isLoading = false;
            }
        },
        
        applyStatus(status) {
            this.fetchArticles({ status: status, page: 1 }); // specific status, reset page
        },
        
        applyCategory(categoryId) {
            this.fetchArticles({ category: categoryId, page: 1 });
        },

        applySearch(query) {
             this.fetchArticles({ search: query, page: 1 });
        },

        clearSearch() {
            this.searchQuery = '';
            this.fetchArticles({ search: null, page: 1 });
        }

    }">
        <x-slot name="header">
            <x-admin.page-header icon="book-open" title="{{ __('admin.articles.title') }}"
                description="{{ __('admin.articles.description') }}" :breadcrumbs="[['label' => __('admin.articles.breadcrumbs')]]">
                <x-slot:actions>
                    <a href="{{ route('admin.articles.scheduled') }}"
                        class="inline-flex items-center px-4 py-2 border border-border rounded-lg shadow-sm text-sm font-medium text-text bg-surface hover:bg-background focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 mr-2">
                        <x-lucide-calendar class="w-4 h-4 mr-2" />
                        {{ __('admin.articles.scheduled') }}
                    </a>
                    <a href="{{ route('admin.articles.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        <x-lucide-plus-circle class="w-4 h-4 mr-2" />
                        {{ __('admin.articles.new_article') }}
                    </a>
                </x-slot:actions>


                <x-slot:stats>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <x-admin.stats-card icon="book-open" label="{{ __('admin.articles.total_articles') }}"
                            :value="$totalArticles" />
                        <x-admin.stats-card icon="check-circle" iconColor="green"
                            label="{{ __('admin.articles.published') }}" :value="$publishedArticles" />
                        <x-admin.stats-card icon="clock" iconColor="yellow" label="{{ __('admin.articles.scheduled') }}"
                            :value="$scheduledArticles" />
                    </div>
                </x-slot:stats>
            </x-admin.page-header>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Search and Filter Section -->
                <div class="bg-surface rounded-lg shadow-sm border border-border mb-6 transition-all hover:shadow-md">
                    <div class="p-4 sm:p-6 flex flex-col sm:flex-row gap-4 justify-between items-center">

                        <!-- Status Filter -->
                        <div
                            class="flex items-center bg-background rounded-lg p-1 self-start sm:self-center border border-border">
                            <button @click.prevent="applyStatus('')" type="button"
                                :class="!currentStatus ? 'bg-surface text-text shadow-sm border border-border' : 'text-muted hover:text-text'"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-all">
                                {{ __('admin.common.all') ?? 'All' }}
                            </button>
                            <button @click.prevent="applyStatus('published')" type="button"
                                :class="currentStatus === 'published' ? 'bg-surface text-text shadow-sm border border-border' : 'text-muted hover:text-text'"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-all">
                                {{ __('admin.status.published') }}
                            </button>
                            <button @click.prevent="applyStatus('scheduled')" type="button"
                                :class="currentStatus === 'scheduled' ? 'bg-surface text-text shadow-sm border border-border' : 'text-muted hover:text-text'"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-all">
                                {{ __('admin.status.scheduled') }}
                            </button>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                            <!-- Category Filter -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click.prevent="open = !open" type="button"
                                    class="w-full sm:w-auto inline-flex items-center justify-between px-4 py-2 border border-border rounded-lg text-sm font-medium text-text bg-background hover:bg-surface focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <x-lucide-filter class="h-4 w-4 mr-2 text-muted" />
                                        <span
                                            x-text="currentCategory ? '{{ __('Category Selected') }}' : '{{ __('admin.articles.all_categories') }}'"></span>
                                    </div>
                                    <x-lucide-chevron-down class="h-4 w-4 ml-2 text-muted" />
                                </button>

                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95" style="display: none;"
                                    class="absolute right-0 z-10 mt-2 w-56 rounded-lg shadow-lg bg-surface ring-1 ring-black ring-opacity-5 focus:outline-none border border-border">
                                    <div class="py-1" role="menu">
                                        <button @click.prevent="applyCategory(''); open = false" type="button"
                                            class="block w-full text-left px-4 py-2 text-sm text-text hover:bg-background">
                                            {{ __('admin.articles.all_categories') }}
                                        </button>
                                        @foreach($categories as $category)
                                            <button @click.prevent="applyCategory('{{ $category->id }}'); open = false"
                                                type="button"
                                                class="block w-full text-left px-4 py-2 text-sm text-text hover:bg-background"
                                                :class="currentCategory == '{{ $category->id }}' ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300' : ''">
                                                {{ $category->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Search Bar -->
                            <div class="relative flex-1 w-full sm:w-64">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-lucide-search class="h-4 w-4 text-muted" />
                                </div>
                                <input type="text" x-model="searchQuery"
                                    @input.debounce.300ms="applySearch($event.target.value)"
                                    class="block w-full pl-10 pr-10 py-2 border border-border rounded-lg leading-5 bg-background text-text placeholder-muted focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent sm:text-sm transition-colors duration-200"
                                    placeholder="{{ __('admin.common.search') }}...">
                                <template x-if="searchQuery">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button @click.prevent="clearSearch()" type="button"
                                            class="text-muted hover:text-text transition-colors"
                                            title="{{ __('admin.common.clear') }}">
                                            <x-lucide-x class="h-4 w-4" />
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Articles Table Container -->
                <div class="relative min-h-[200px]">
                    <!-- Loading Overlay -->
                    <div x-show="isLoading" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute inset-0 z-10 bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm flex items-center justify-center rounded-lg"
                        style="display: none;">
                        <div class="flex flex-col items-center">
                            <svg class="animate-spin h-8 w-8 text-indigo-600 dark:text-indigo-400 mb-2"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span class="text-sm font-medium text-text">Loading...</span>
                        </div>
                    </div>

                    <!-- AJAX Content Area -->
                    <div x-ref="articlesContainer">
                        <x-admin.articles-table :articles="$articles" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <x-admin.modal-confirm-delete type="article" />
    </div>
</x-admin-layout>