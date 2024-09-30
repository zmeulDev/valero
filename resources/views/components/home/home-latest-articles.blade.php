<div x-data="{ view: 'grid' }"
  class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
  <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 dark:border-gray-700">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Latest Articles</h2>
    <button @click="view = view === 'grid' ? 'list' : 'grid'"
      class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
      <svg x-show="view === 'list'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16">
        </path>
      </svg>
      <svg x-show="view === 'grid'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
        </path>
      </svg>
    </button>
  </div>

  @if ($articles->isEmpty())
  <x-nothing-found />
  @else
  <div x-show="view === 'grid'">
    <x-home.home-latest-articles-grid :articles="$articles" />
  </div>
  <div x-show="view === 'list'">
    <x-home.home-latest-articles-list :articles="$articles" />
  </div>

  <!-- Pagination -->
  <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
    {{ $articles->links() }}
  </div>
  @endif
</div>