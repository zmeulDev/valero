<x-admin-layout>
    <div x-data="{
        showDeleteModal: false,
        itemToDelete: null,
        items: {{ $articles->items() ? json_encode($articles->items()) : '[]' }},
        
        openDeleteModal(id) {
            this.itemToDelete = id;
            this.showDeleteModal = true;
        }
    }">
        <x-slot name="header">
            <x-admin.page-header
                icon="book-open"
                title="{{ __('Articles') }}"
                description="Manage and organize your articles"
                :breadcrumbs="[['label' => 'Articles']]"
            >
                <x-slot:actions>
                    <a href="{{ route('admin.articles.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        <x-lucide-plus-circle class="w-4 h-4 mr-2" />
                        New Article
                    </a>
                </x-slot:actions>

                <x-slot:stats>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <x-admin.stats-card 
                            icon="book-open" 
                            label="Total Articles" 
                            :value="$totalArticles" 
                        />
                        <x-admin.stats-card 
                            icon="check-circle" 
                            iconColor="green" 
                            label="Published" 
                            :value="$publishedArticles" 
                        />
                        <x-admin.stats-card 
                            icon="clock" 
                            iconColor="yellow" 
                            label="Scheduled" 
                            :value="$scheduledArticles" 
                        />
                    </div>
                </x-slot:stats>
            </x-admin.page-header>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Search and Filter Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
                    <div class="p-4 sm:p-6 space-y-4 sm:space-y-0 sm:flex sm:items-center sm:justify-between">
                        <!-- Category Filter -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                <x-lucide-filter class="h-5 w-5 mr-2 text-gray-400" />
                                <span>{{ $selectedCategory ? $categories->find($selectedCategory)->name : 'All Categories' }}</span>
                                <x-lucide-chevron-down class="h-5 w-5 ml-2 text-gray-400" />
                            </button>

                            <div x-show="open" 
                                 @click.away="open = false"
                                 class="absolute z-10 mt-2 w-56 rounded-lg shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5">
                                <div class="py-1" role="menu">
                                    <a href="{{ route('admin.articles.index', ['search' => request('search')]) }}" 
                                       class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        All Categories
                                    </a>
                                    @foreach($categories as $category)
                                        <a href="{{ route('admin.articles.index', ['category' => $category->id, 'search' => request('search')]) }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 {{ $selectedCategory == $category->id ? 'bg-gray-100 dark:bg-gray-600' : '' }}">
                                            {{ $category->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Search Bar -->
                        <form method="GET" action="{{ route('admin.articles.index') }}" class="relative flex-1 max-w-md ml-0 sm:ml-4">
                            @if($selectedCategory)
                                <input type="hidden" name="category" value="{{ $selectedCategory }}">
                            @endif
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-lucide-search class="h-5 w-5 text-gray-400" />
                            </div>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent sm:text-sm transition-colors duration-200"
                                   placeholder="Search articles..."
                                   x-ref="searchInput"
                                   @keydown.enter="$event.target.form.submit()">
                            @if(request('search'))
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <a href="{{ route('admin.articles.index', array_filter(['category' => $selectedCategory])) }}" 
                                       class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"
                                       title="Clear search">
                                        <x-lucide-x class="h-5 w-5" />
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Articles Table -->
                @if($articles->count() > 0)
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Article</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($articles as $article)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    @if($article->featured_image)
                                                        <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                                             alt="{{ $article->title }}"
                                                             class="h-10 w-10 rounded-lg object-cover">
                                                    @else
                                                        <div class="h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                            <x-lucide-image class="h-6 w-6 text-gray-400" />
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $article->title }}</div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">By {{ $article->user->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $article->category ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                                {{ $article->category?->name ?? 'Uncategorized' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($article->scheduled_at && $article->scheduled_at->isFuture())
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                    <x-lucide-clock class="w-4 h-4 mr-1" />
                                                    Scheduled
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                    <x-lucide-check-circle class="w-4 h-4 mr-1" />
                                                    Published
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $article->scheduled_at ? $article->scheduled_at->format('M j, Y') : $article->created_at->format('M j, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end items-center space-x-3">
                                                <a href="{{ route('admin.articles.show', $article) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                                   title="View article">
                                                    <x-lucide-eye class="h-5 w-5" />
                                                </a>
                                                <a href="{{ route('admin.articles.edit', $article) }}" 
                                                   class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                                   title="Edit article">
                                                    <x-lucide-pencil class="h-5 w-5" />
                                                </a>
                                                <button @click="openDeleteModal({{ $article->id }})"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                        title="Delete article">
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
        <x-admin.modal-confirm-delete 
            type="article"
            x-show="showDeleteModal"
            @click.away="showDeleteModal = false"
        />
    </div>
</x-admin-layout>