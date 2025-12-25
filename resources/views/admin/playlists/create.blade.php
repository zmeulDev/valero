<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header icon="plus-circle" title="{{ __('admin.playlists.create_playlist') }}"
            description="{{ __('admin.playlists.description') }}" :breadcrumbs="[
        ['label' => __('admin.playlists.title'), 'route' => route('admin.playlists.index')],
        ['label' => __('admin.common.create')]
    ]" />
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 p-6">

                <form action="{{ route('admin.playlists.store') }}" method="POST">
                    @csrf

                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('admin.common.title') }}</label>
                        <input type="text" name="title" id="title"
                            class="form-input block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
                            value="{{ old('title') }}" required>
                        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('admin.common.description') }}</label>
                        <textarea name="description" id="description" rows="3"
                            class="form-textarea block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">{{ old('description') }}</textarea>
                    </div>

                    <!-- Article Picker -->
                    <div class="mb-6"
                        x-data="articlePicker({{ $articles->map(fn($a) => ['id' => $a->id, 'title' => $a->title]) }})">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.playlists.articles_count') }}
                            (Ordered)</label>

                        <div class="flex flex-col md:flex-row gap-4 h-96">

                            <!-- Available -->
                            <div
                                class="flex-1 flex flex-col border border-gray-200 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800">
                                <div
                                    class="p-2 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 font-medium text-xs uppercase text-gray-500">
                                    {{ __('admin.playlists.select_articles') }}
                                </div>
                                <div class="p-2 border-b border-gray-200 dark:border-gray-700">
                                    <input type="text" x-model="search" placeholder="Filter..."
                                        class="w-full text-xs p-1 border rounded bg-white dark:bg-gray-700 text-gray-900 dark:text-white border-gray-300 dark:border-gray-600">
                                </div>
                                <div class="flex-1 overflow-y-auto p-2 space-y-1">
                                    <template x-for="article in filteredAvailable" :key="article.id">
                                        <div @click="add(article)"
                                            class="cursor-pointer p-2 hover:bg-indigo-50 dark:hover:bg-indigo-900 rounded flex justify-between items-center group transition-colors">
                                            <span x-text="article.title"
                                                class="text-sm text-gray-700 dark:text-gray-300"></span>
                                            <x-lucide-plus class="w-4 h-4 text-gray-400 group-hover:text-indigo-500" />
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Selected (Ordered) -->
                            <div
                                class="flex-1 flex flex-col border border-gray-200 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800">
                                <div
                                    class="p-2 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 font-medium text-xs uppercase text-gray-500">
                                    {{ __('admin.playlists.title') }}
                                </div>
                                <div class="flex-1 overflow-y-auto p-2 space-y-1">
                                    <template x-for="(article, index) in selected" :key="article.id">
                                        <div
                                            class="flex items-center p-2 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 rounded">
                                            <span x-text="index + 1"
                                                class="text-xs font-bold text-indigo-500 w-6"></span>
                                            <span x-text="article.title"
                                                class="text-sm flex-1 truncate text-gray-900 dark:text-white"></span>
                                            <div class="flex items-center space-x-1">
                                                <button type="button" @click="moveUp(index)"
                                                    class="p-1 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400"
                                                    :disabled="index === 0" :class="{'opacity-50': index === 0}">
                                                    <x-lucide-chevron-up class="w-4 h-4" />
                                                </button>
                                                <button type="button" @click="moveDown(index)"
                                                    class="p-1 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400"
                                                    :disabled="index === selected.length - 1"
                                                    :class="{'opacity-50': index === selected.length - 1}">
                                                    <x-lucide-chevron-down class="w-4 h-4" />
                                                </button>
                                                <button type="button" @click="remove(index)"
                                                    class="p-1 text-red-400 hover:text-red-600">
                                                    <x-lucide-x class="w-4 h-4" />
                                                </button>
                                            </div>
                                            <!-- Hidden Input -->
                                            <input type="hidden" name="articles[]" :value="article.id">
                                        </div>
                                    </template>
                                    <div x-show="selected.length === 0" class="text-center text-gray-400 text-sm py-4">
                                        {{ __('admin.playlists.no_articles_attached') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            {{ __('admin.playlists.create_playlist') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('articlePicker', (allArticles) => ({
                all: allArticles,
                selected: [],
                search: '',

                get filteredAvailable() {
                    return this.all.filter(a =>
                        !this.selected.find(s => s.id === a.id) &&
                        a.title.toLowerCase().includes(this.search.toLowerCase())
                    );
                },

                add(article) {
                    this.selected.push(article);
                },

                remove(index) {
                    this.selected.splice(index, 1);
                },

                moveUp(index) {
                    if (index > 0) {
                        const item = this.selected[index];
                        this.selected.splice(index, 1);
                        this.selected.splice(index - 1, 0, item);
                    }
                },

                moveDown(index) {
                    if (index < this.selected.length - 1) {
                        const item = this.selected[index];
                        this.selected.splice(index, 1);
                        this.selected.splice(index + 1, 0, item);
                    }
                }
            }));
        });
    </script>
</x-admin-layout>