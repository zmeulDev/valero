<div x-data="{ view: 'grid' }"
  class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200/80 dark:border-gray-700/80 overflow-hidden">
  <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200/80 dark:border-gray-700/80 bg-gray-50/50 dark:bg-gray-800/50">
    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
      <span class="inline-flex items-center gap-2">
        <x-lucide-newspaper class="w-5 h-5 text-gray-500 dark:text-gray-400" />
        {{ __('frontend.common.latest_articles') }}  
      </span>
    </h2>
    
    <div class="flex items-center gap-2">
      <button @click="view = 'list'"
        :class="{'bg-white dark:bg-gray-700': view === 'list'}"
        class="p-2 rounded-lg hover:bg-white dark:hover:bg-gray-700 transition-colors duration-200">
        <x-lucide-list class="w-5 h-5 text-gray-500 dark:text-gray-400" />
      </button>
      <button @click="view = 'grid'"
        :class="{'bg-white dark:bg-gray-700': view === 'grid'}"
        class="p-2 rounded-lg hover:bg-white dark:hover:bg-gray-700 transition-colors duration-200">
        <x-lucide-grid class="w-5 h-5 text-gray-500 dark:text-gray-400" />
      </button>
    </div>
  </div>

  @if ($articles->isEmpty())
    <x-nothing-found />
  @else
    <div x-show="view === 'grid'" x-transition>
      <x-home.home-latest-articles-grid :articles="$articles" />
    </div>
    <div x-show="view === 'list'" x-transition>
      <x-home.home-latest-articles-list :articles="$articles" />
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200/80 dark:border-gray-700/80 bg-gray-50/50 dark:bg-gray-800/50">
      {{ $articles->links() }}
    </div>
  @endif
</div>
