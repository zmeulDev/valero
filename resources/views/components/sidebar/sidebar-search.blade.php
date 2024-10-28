<!-- Search Form with Category Filter -->
<div x-data="sidebarSearch()" x-init="init()"
  class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
  <!-- Search Header -->
  <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
    <h3 class="text-xl font-bold text-gray-900 dark:text-white">
      Search Articles
    </h3>
  </div>

  <!-- Search Form -->
  <div class="p-6">
    <form @submit.prevent="search" class="space-y-4">
      <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </div>
        <x-input type="text" 
                 x-model="query" 
                 placeholder="Search articles..." 
                 class="pl-10 w-full bg-gray-50 dark:bg-gray-900/50" />
      </div>

      <x-button type="submit" 
                class="w-full flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700">
        <span>Search Articles</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </x-button>
    </form>

    <!-- Search Results -->
    <div class="mt-6" x-show="articles.length > 0">
        <ul class="space-y-3">
            <template x-for="article in articles.slice(0, 5)" :key="article.id">
                <li>
                    <a :href="'/articles/' + article.slug" 
                       class="block relative pl-4 py-2 hover:pl-6 transition-all duration-300 group">
                        <!-- Accent Line -->
                        <div class="absolute left-0 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700 group-hover:bg-indigo-500 dark:group-hover:bg-indigo-400 transition-colors duration-300"></div>
                        
                        <!-- Content -->
                        <h5 class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200 line-clamp-1" 
                            x-text="article.title"></h5>
                        
                        <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            <span x-text="article.category.name"></span>
                        </div>
                    </a>
                </li>
            </template>
        </ul>
    </div>

    <div x-show="articles.length === 0 && hasSearched" 
         class="mt-6 text-center py-8 px-4">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      <p class="mt-4 text-gray-600 dark:text-gray-400">
        No articles found matching your search.
      </p>
    </div>
  </div>
</div>

<script>
function sidebarSearch() {
  return {
    query: '',
    articles: [],
    hasSearched: false,

    init() {
      // Initialize search
    },

    async search() {
      if (!this.query.trim()) return;
      
      this.hasSearched = true;
      try {
        const response = await fetch(`/search?query=${encodeURIComponent(this.query)}`);
        if (!response.ok) throw new Error('Search failed');
        const data = await response.json();
        this.articles = data.data;
      } catch (error) {
        console.error('Error searching articles:', error);
        this.articles = [];
      }
    }
  }
}
</script>
