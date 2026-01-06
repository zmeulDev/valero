<div x-data="{
    search: '',
    results: [],
    loading: false,
    showResults: false,
    
    async performSearch() {
        if (this.search.length < 2) {
            this.results = [];
            this.showResults = false;
            return;
        }
        
        this.loading = true;
        
        try {
            const response = await fetch(`{{ route('admin.articles.search-json') }}?search=${encodeURIComponent(this.search)}`);
            this.results = await response.json();
            this.showResults = true;
        } catch (error) {
            console.error('Search failed:', error);
        } finally {
            this.loading = false;
        }
    },
    
    copyLink(url) {
        // Use modern clipboard API if available
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url).then(() => {
                this.onCopySuccess();
            }).catch(err => {
                // If failed (e.g. permission), try fallback
                this.fallbackCopy(url);
            });
        } else {
            this.fallbackCopy(url);
        }
    },

    fallbackCopy(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        
        // Ensure it's not visible but part of DOM
        textArea.style.position = 'fixed';
        textArea.style.left = '-9999px';
        textArea.style.top = '0';
        document.body.appendChild(textArea);
        
        textArea.focus();
        textArea.select();
        
        try {
            const successful = document.execCommand('copy');
            if (successful) {
                this.onCopySuccess();
            } else {
                window.showToast("{{ __('admin.articles.link_copy_failed') }}", 'error');
            }
        } catch (err) {
            window.showToast("{{ __('admin.articles.link_copy_failed') }}", 'error');
            window.showToast('{{ __('admin.articles.failed_to_copy_link') }}', 'error');
        }
        
        document.body.removeChild(textArea);
    },

    onCopySuccess() {
        window.showToast(" {{ __('admin.articles.link_copied') }}", 'success' ); this.showResults=false; this.search=''
    ; this.results=[]; } }" @click.away="showResults = false" class="relative">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        {{ __('admin.articles.link_internal_article') }}
    </label>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <x-lucide-search class="h-5 w-5 text-gray-400" />
        </div>
        <input type="text" x-model="search" @input.debounce.300ms="performSearch()"
            class="w-full pl-10 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
            placeholder="{{ __('admin.articles.search_placeholder') }}">
        <div x-show="loading" class="absolute inset-y-0 right-0 pr-3 flex items-center">
            <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>
    </div>

    <!-- Results Dropdown -->
    <div x-show="showResults && results.length > 0" x-transition
        class="absolute z-50 mt-1 w-full bg-white dark:bg-gray-800 shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
        <template x-for="article in results" :key="article.id">
            <div @click="copyLink(article.canonical_url)"
                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100 group">
                <div class="flex flex-col flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <span class="font-medium truncate mr-2" x-text="article.title"></span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium"
                            :class="article.is_scheduled ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'"
                            x-text="article.status_label">
                        </span>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400 truncate"
                        x-text="article.canonical_url"></span>
                </div>
                <span
                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600 dark:text-indigo-400 opacity-0 group-hover:opacity-100">
                    <x-lucide-copy class="h-4 w-4" />
                </span>
            </div>
        </template>
    </div>

    <div x-show="showResults && results.length === 0 && search.length >= 2 && !loading"
        class="absolute z-50 mt-1 w-full bg-white dark:bg-gray-800 shadow-lg rounded-md py-2 px-3 text-sm text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-700">
        {{ __('admin.articles.no_articles_found') }}
    </div>
</div>