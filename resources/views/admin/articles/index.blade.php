<x-admin-layout>
    <div x-data="dataManager()">
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
                    <x-admin.stats-card icon="book-open" label="Total Articles" :value="$totalArticles" />
                    <x-admin.stats-card icon="check-circle" iconColor="green" label="Published" :value="$publishedArticles" />
                    <x-admin.stats-card icon="clock" iconColor="yellow" label="Scheduled" :value="$scheduledArticles" />
                </x-slot:stats>
            </x-admin.page-header>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Search and Filter Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
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
                                    <a href="{{ route('admin.articles.index') }}" 
                                       class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                        All Categories
                                    </a>
                                    @foreach($categories as $category)
                                        <a href="{{ route('admin.articles.index', ['category' => $category->id]) }}" 
                                           class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 {{ $selectedCategory == $category->id ? 'bg-gray-100 dark:bg-gray-600' : '' }}">
                                            {{ $category->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Search Bar -->
                        <div class="relative flex-1 max-w-md ml-0 sm:ml-4">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-lucide-search class="h-5 w-5 text-gray-400" />
                            </div>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent sm:text-sm transition-colors duration-200"
                                   placeholder="Search articles...">
                        </div>
                    </div>
                </div>

                <!-- Articles Table -->
                <x-admin.table :headers="['Thumbnail', 'Title', 'Category', 'Status', 'Date', 'Actions']">
                    @foreach($articles as $article)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="h-10 w-10 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-600">
                                    @if($article->featured_image)
                                        <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                             alt="{{ $article->title }}"
                                             class="h-full w-full object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center">
                                            <x-lucide-image class="h-6 w-6 text-gray-400" />
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $article->title }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">By {{ $article->user->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $article->category ? 'bg-blue-100 text-blue-800 dark:bg-blue-800/20 dark:text-blue-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-800/20 dark:text-gray-400' }}">
                                    {{ $article->category?->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $article->scheduled_at ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800/20 dark:text-yellow-400' : 'bg-green-100 text-green-800 dark:bg-green-800/20 dark:text-green-400' }}">
                                    {{ $article->scheduled_at ? 'Scheduled' : 'Published' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $article->scheduled_at ? $article->scheduled_at : $article->created_at }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center space-x-3">
                                    <a href="{{ route('admin.articles.show', $article) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        <x-lucide-eye class="h-5 w-5" />
                                    </a>
                                    <a href="{{ route('admin.articles.edit', $article) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                        <x-lucide-pencil class="h-5 w-5" />
                                    </a>
                                    <button @click="openDeleteModal({{ $article->id }})"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                        <x-lucide-trash class="h-5 w-5" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-admin.table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <x-admin.modal-confirm-delete type="article" />
    </div>

    <x-admin.data-manager :items="$articles->items()" />
</x-admin-layout>