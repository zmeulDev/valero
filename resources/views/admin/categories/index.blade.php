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
            <x-slot:actions>
                <button type="button" 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
                        onclick="document.getElementById('name').focus()">
                    <x-lucide-plus-circle class="w-4 h-4 mr-2" />
                    {{ __('admin.category.create') }}
                </button>
            </x-slot:actions>

            <x-slot:stats>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <x-admin.stats-card
                        icon="folder"
                        label="{{ __('admin.category.total_categories') }}"
                        :value="$categories->count()"
                    />
                    <x-admin.stats-card
                        icon="book-open"
                        label="{{ __('admin.category.total_articles') }}"
                        :value="$categories->sum('articles_count')"
                    />
                    <x-admin.stats-card
                        icon="bar-chart-2"
                        label="{{ __('admin.category.avg_articles_per_category') }}"
                        :value="$categories->count() ? round($categories->sum('articles_count') / $categories->count(), 1) : 0"
                    />
                </div>
            </x-slot:stats>
        </x-admin.page-header>
    </x-slot>

    <div x-data="{ 
        items: {{ $categories->toJson() }},
        charCount: 0,
        
        openDeleteModal(id) {
            $dispatch('open-delete-modal', id);
        }
    }" class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Categories List -->
                <div class="lg:col-span-3">
                    <div class="bg-surface shadow-sm sm:rounded-lg border border-border">
                        <div class="p-6">
                            <div class="sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-lg font-medium leading-6 text-text">{{ __('admin.category.title') }}</h3>
                                    <p class="mt-1 text-sm text-muted">
                                        {{ __('admin.category.categories_description') }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                @if ($categories->isEmpty())
                                    <x-nothing-found />
                                @else
                                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg border border-border">
                                        <table class="min-w-full divide-y divide-border">
                                            <thead class="bg-background">
                                                <tr>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-text sm:pl-6">{{ __('admin.category.name') }}</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-text">{{ __('admin.category.slug') }}</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-text">{{ __('admin.category.articles_count') }}</th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                        <span class="sr-only">{{ __('admin.common.actions') }}</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-border bg-surface">
                                                @foreach ($categories as $category)
                                                    <tr class="hover:bg-background transition-colors duration-200">
                                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-text sm:pl-6">
                                                            {{ $category->name }}
                                                        </td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-muted">
                                                            {{ $category->slug }}
                                                        </td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-muted">
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->articles_count > 0 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200' }}">
                                                                {{ $category->articles_count }}
                                                            </span>
                                                        </td>
                                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                    <div class="flex justify-end items-center space-x-2">
                                                        <a href="{{ route('admin.categories.edit', $category) }}" 
                                                           class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-md"
                                                           title="{{ __('admin.category.edit') }}">
                                                            <x-lucide-edit class="w-5 h-5" />
                                                            <span class="sr-only">{{ __('admin.category.edit') }}</span>
                                                        </a>
                                                        <button @click="openDeleteModal({{ $category->id }})"
                                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 rounded-md"
                                                                title="Delete category">
                                                            <x-lucide-trash-2 class="w-5 h-5" />
                                                            <span class="sr-only">Delete {{ $category->name }}</span>
                                                        </button>
                                                    </div>
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
            
                <!-- Create Category Form -->
                <div class="lg:col-span-1">
                    <div class="bg-surface overflow-hidden shadow-sm sm:rounded-lg border border-border">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium leading-6 text-text">
                                    {{ __('admin.category.create') }}
                                </h3>
                                <x-lucide-plus-circle class="h-5 w-5 text-muted" />
                            </div>
                            <form action="{{ route('admin.categories.store') }}" method="POST">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-text">
                                            {{ __('admin.category.name') }}
                                        </label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input type="text"
                                                name="name"
                                                id="name"
                                                required
                                                maxlength="50"
                                                x-on:input="charCount = $event.target.value.length"
                                                placeholder="{{ __('admin.category.name_placeholder') }}"
                                                class="block w-full rounded-md border-border bg-background text-text focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                                        </div>
                                        <p class="mt-1 text-xs" :class="{ 'text-red-500': charCount > 50, 'text-muted': charCount <= 50 }">
                                            <span x-text="charCount"></span>/50 characters
                                        </p>
                                    </div>
                                    <button type="submit"
                                            class="w-full flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                        {{ __('admin.category.create') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>