<div x-data="{ view: 'grid' }" class="bg-surface rounded-xl shadow-sm border border-border overflow-hidden">
  <div class="flex justify-between items-center px-6 py-4 border-b border-border bg-background/50">
    <h2 class="text-xl font-semibold text-text">
      <span class="inline-flex items-center gap-2">
        <x-lucide-newspaper class="w-5 h-5 text-muted" />
        {{ __('frontend.common.latest_articles') }}
      </span>
    </h2>

    <div class="flex items-center gap-2">
      <button @click="view = 'list'" :class="{'bg-background': view === 'list'}"
        class="p-2 rounded-lg hover:bg-background transition-colors duration-200">
        <x-lucide-list class="w-5 h-5 text-muted" />
      </button>
      <button @click="view = 'grid'" :class="{'bg-background': view === 'grid'}"
        class="p-2 rounded-lg hover:bg-background transition-colors duration-200">
        <x-lucide-grid class="w-5 h-5 text-muted" />
      </button>
    </div>
  </div>

  @if ($articles->isEmpty())
    <x-nothing-found />
  @else
    <div x-show="view === 'grid'" x-transition>
      <x-home.latest-grid :articles="$articles" />
    </div>
    <div x-show="view === 'list'" x-transition>
      <x-home.latest-list :articles="$articles" />
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-border bg-background/50">
      {{ $articles->links() }}
    </div>
  @endif
</div>