<!-- Search Form with Category Filter -->
<div x-data="sidebarSearch()" x-init="init()"
  class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-8 p-6">
  <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
    Search Articles
  </h3>
  <form @submit.prevent="search">
    <x-input type="text" x-model="query" placeholder="Search..." class="w-full mb-4" />

    <x-button type="submit" class="w-full">
      Search
    </x-button>
  </form>

  <div class="mt-6" x-show="articles.length > 0">
    <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Search Results</h4>
    <ul class="space-y-4">
      <template x-for="article in articles.slice(0, 5)" :key="article.id">
        <li class="bg-white dark:bg-gray-700 rounded-lg shadow-xs hover:shadow-md transition-shadow duration-300">
          <a :href="'/articles/' + article.slug" class="block p-4">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <img :src="article.featured_image ? '/storage/' + article.featured_image : '/images/default-placeholder.png'" :alt="article.title" class="w-16 h-16 object-cover rounded-md"> 
              </div>
              <div class="ml-4">
                <h5 class="text-sm font-medium text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300" x-text="article.title"></h5>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400" x-text="article.excerpt || 'No excerpt available'"></p>
              </div>
            </div>
          </a>
        </li>
      </template>
    </ul>
  </div>

  <p x-show="articles.length === 0 && hasSearched" class="text-gray-600 dark:text-gray-400 mt-4">
    No articles found.
  </p>
</div>

<script>
function sidebarSearch() {
  return {
    query: '',
    articles: [],
    paginationLinks: '',
    hasSearched: false,

    init() {
      // We don't need to fetch categories anymore
    },

    async search() {
      this.hasSearched = true;
      try {
        const response = await fetch(`/search?query=${this.query}`);
        if (!response.ok) throw new Error('Failed to fetch articles');
        const data = await response.json();
        this.articles = data.data;
        this.paginationLinks = data.links;
      } catch (error) {
        console.error('Error searching articles:', error);
      }
    }
  }
}
</script>