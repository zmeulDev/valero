<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header
            icon="folder"
            title="{{ __('Categories') }}"
            description="Manage and organize your content categories"
            :breadcrumbs="[
                ['label' => 'Categories']
            ]"
        >
            <x-slot:stats>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <x-admin.stats-card
                        icon="folder"
                        label="Total Categories"
                        :value="$categories->count()"
                    />
                    <x-admin.stats-card
                        icon="book-open"
                        label="Total Articles"
                        :value="$categories->sum('articles_count')"
                    />
                    <x-admin.stats-card
                        icon="bar-chart-2"
                        label="Avg. Articles/Category"
                        :value="$categories->count() ? round($categories->sum('articles_count') / $categories->count(), 1) : 0"
                    />
                </div>
            </x-slot:stats>
        </x-admin.page-header>
    </x-slot>

    <div x-data="{ 
        showDeleteModal: false,
        itemToDelete: null,
        items: {{ $categories->toJson() }},
        charCount: 0,
        
        openDeleteModal(id) {
            this.itemToDelete = id;
            this.showDeleteModal = true;
        }
    }" class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Create Category Form -->
                <div class="md:col-span-1">
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-4 py-5 sm:p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                Create New Category
                            </h3>
                            <form action="{{ route('admin.categories.store') }}" method="POST">
                                @csrf
                                <div class="space-y-1">
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Category Name
                                    </label>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           required
                                           maxlength="50"
                                           x-on:input="charCount = $event.target.value.length"
                                           placeholder="Enter category name"
                                           class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                                    <p class="text-sm mt-1" :class="{ 'text-red-500': charCount > 50, 'text-gray-500': charCount <= 50 }">
                                        <span x-text="charCount"></span>/50 characters
                                    </p>
                                </div>
                                <div class="mt-4">
                                    <button type="submit"
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                        <x-lucide-plus class="w-5 h-5 mr-2" />
                                        Create Category
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Categories List -->
                <div class="md:col-span-3">
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="sm:flex sm:items-center">
                                <div class="sm:flex-auto">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        All Categories
                                    </h3>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                @if ($categories->isEmpty())
                                    <x-nothing-found />
                                @else
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">Name</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">Slug</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">Articles</th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                        <span class="sr-only">Actions</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                @foreach ($categories as $category)
                                                    <tr>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                            {{ $category->name }}
                                                        </td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $category->slug }}
                                                        </td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $category->articles_count }}
                                                        </td>
                                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                            <button @click="openDeleteModal({{ $category->id }})"
                                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                                    title="Delete category">
                                                                <x-lucide-trash-2 class="w-5 h-5" />
                                                                <span class="sr-only">Delete {{ $category->name }}</span>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <x-admin.modal-confirm-delete type="category" />
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>