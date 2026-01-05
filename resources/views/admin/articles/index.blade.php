<x-admin-layout>
    <div x-data="{
        showDeleteModal: false,
        itemToDelete: null,
        items: {{ $articles->items() ? json_encode($articles->items()) : '[]' }},
        
        openDeleteModal(id) {
            $dispatch('open-delete-modal', id);
        }
    }">
        <x-slot name="header">
            <x-admin.page-header icon="book-open" title="{{ __('admin.articles.title') }}"
                description="{{ __('admin.articles.description') }}" :breadcrumbs="[['label' => __('admin.articles.breadcrumbs')]]">
                <x-slot:actions>
                    <a href="{{ route('admin.articles.scheduled') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200 mr-2">
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
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6 transition-all hover:shadow-md">
                    <div class="p-4 sm:p-6 flex flex-col sm:flex-row gap-4 justify-between items-center">

                        <!-- Status Filter -->
                        <div
                            class="flex items-center bg-gray-100 dark:bg-gray-700/50 rounded-lg p-1 self-start sm:self-center">
                            <a href="{{ route('admin.articles.index', array_merge(request()->except('status', 'page'))) }}"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-all {{ !request('status') ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">
                                {{ __('admin.common.all') ?? 'All' }}
                            </a>
                            <a href="{{ route('admin.articles.index', array_merge(request()->except('page'), ['status' => 'published'])) }}"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-all {{ request('status') === 'published' ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">
                                {{ __('admin.status.published') }}
                            </a>
                            <a href="{{ route('admin.articles.index', array_merge(request()->except('page'), ['status' => 'scheduled'])) }}"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-all {{ request('status') === 'scheduled' ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200' }}">
                                {{ __('admin.status.scheduled') }}
                            </a>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                            <!-- Category Filter -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="w-full sm:w-auto inline-flex items-center justify-between px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    <div class="flex items-center">
                                        <x-lucide-filter class="h-4 w-4 mr-2 text-gray-500 dark:text-gray-400" />
                                        <span>{{ $selectedCategory ? $categories->find($selectedCategory)->name : __('admin.articles.all_categories') }}</span>
                                    </div>
                                    <x-lucide-chevron-down class="h-4 w-4 ml-2 text-gray-400" />
                                </button>

                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute right-0 z-10 mt-2 w-56 rounded-lg shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1" role="menu">
                                        <a href="{{ route('admin.articles.index', request()->except('category', 'page')) }}"
                                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            {{ __('admin.articles.all_categories') }}
                                        </a>
                                        @foreach($categories as $category)
                                            <a href="{{ route('admin.articles.index', array_merge(request()->except('page'), ['category' => $category->id])) }}"
                                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 {{ $selectedCategory == $category->id ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300' : '' }}">
                                                {{ $category->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Search Bar -->
                            <form method="GET" action="{{ route('admin.articles.index') }}" x-data="{ 
                                        query: '{{ request('search') }}',
                                        updateSearch: function(value) {
                                            this.query = value;
                                            // Add debounce to prevent too many requests
                                            clearTimeout(this.timeout);
                                            this.timeout = setTimeout(() => {
                                                this.$refs.searchForm.submit();
                                            }, 300);
                                        }
                                    }" x-ref="searchForm" class="relative flex-1 w-full sm:w-64">
                                @foreach(request()->except('search', 'page') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach

                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-lucide-search class="h-4 w-4 text-gray-400" />
                                </div>
                                <input type="text" name="search" x-model="query"
                                    @input="updateSearch($event.target.value)"
                                    class="block w-full pl-10 pr-10 py-2 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent sm:text-sm transition-colors duration-200"
                                    placeholder="{{ __('admin.common.search') }}..." x-ref="searchInput">
                                @if(request('search'))
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <a href="{{ route('admin.articles.index', request()->except('search', 'page')) }}"
                                            class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors"
                                            title="{{ __('admin.common.clear') }}">
                                            <x-lucide-x class="h-4 w-4" />
                                        </a>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Articles Table -->
                @if($articles->count() > 0)
                    <div
                        class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden ring-1 ring-black ring-opacity-5">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('admin.common.title') }}
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('admin.common.category') }}
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('admin.common.status') }}
                                        </th>
                                        <th scope="col" class="relative px-6 py-3.5">
                                            <span class="sr-only">{{ __('admin.common.actions') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($articles as $article)
                                        <tr
                                            class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 group">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0 relative">
                                                        @if($article->media->firstWhere('is_cover', true)->image_path ?? false)
                                                            <img src="{{ asset('storage/' . $article->media->firstWhere('is_cover', true)->image_path) }}"
                                                                alt="{{ $article->title }}"
                                                                class="h-10 w-10 rounded-lg object-cover ring-2 ring-gray-100 dark:ring-gray-700 group-hover:ring-indigo-500/50 dark:group-hover:ring-indigo-400/50 transition-all">
                                                        @else
                                                            <div
                                                                class="h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center ring-2 ring-gray-100 dark:ring-gray-700">
                                                                <x-lucide-image class="h-5 w-5 text-gray-400" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4 min-w-0 flex-1">
                                                        <div
                                                            class="text-sm font-medium text-gray-900 dark:text-white line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                                            {{ $article->title }}
                                                        </div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                            {{ __('admin.articles.by') }} <span
                                                                class="text-gray-700 dark:text-gray-300">{{ $article->user->name }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $article->category ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                                    {{ $article->category?->name ?? __('admin.articles.uncategorized') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                @if($article->scheduled_at && $article->scheduled_at->isFuture())
                                                    <div class="flex flex-col">
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 ring-1 ring-inset ring-yellow-600/20 w-fit">
                                                            <x-lucide-clock class="w-3 h-3 mr-1" />
                                                            {{ __('admin.status.scheduled') }}
                                                        </span>
                                                        <span class="text-xs text-gray-400 mt-1 pl-1">
                                                            {{ $article->scheduled_at->format('M j, Y H:i') }}
                                                        </span>
                                                    </div>
                                                @else
                                                    <div class="flex flex-col">
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 ring-1 ring-inset ring-green-600/20 w-fit">
                                                            <x-lucide-check-circle class="w-3 h-3 mr-1" />
                                                            {{ __('admin.status.published') }}
                                                        </span>
                                                        <span class="text-xs text-gray-400 mt-1 pl-1">
                                                            {{ $article->created_at->format('M j, Y') }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end items-center space-x-2">
                                                    <a href="{{ route('admin.articles.show', $article) }}"
                                                        class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors p-1"
                                                        title="{{ __('admin.common.view') }}">
                                                        <x-lucide-eye class="h-5 w-5" />
                                                    </a>
                                                    <a href="{{ route('admin.articles.edit', $article) }}"
                                                        class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors p-1"
                                                        title="{{ __('admin.common.edit') }}">
                                                        <x-lucide-pencil class="h-5 w-5" />
                                                    </a>
                                                    <button @click="openDeleteModal({{ $article->id }})"
                                                        class="text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors p-1"
                                                        title="{{ __('admin.common.delete') }}">
                                                        <x-lucide-trash class="h-5 w-5" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <x-nothing-found />
                @endif

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <x-admin.modal-confirm-delete type="article" />
    </div>
</x-admin-layout>