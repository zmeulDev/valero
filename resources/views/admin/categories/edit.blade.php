<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header icon="folder" title="{{ __('admin.category.edit') }}"
            description="{{ __('admin.category.description') }}" :breadcrumbs="[
        ['label' => __('admin.common.categories'), 'route' => route('admin.categories.index')],
        ['label' => __('admin.category.edit')]
    ]">
            <x-slot:actions>
                <a href="{{ route('admin.categories.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-border rounded-md shadow-sm text-sm font-medium text-text bg-surface hover:bg-background focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                    {{ __('admin.common.back') }}
                </a>
            </x-slot:actions>
        </x-admin.page-header>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-surface overflow-hidden shadow-sm sm:rounded-lg border border-border">
                <div class="p-6">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div x-data="{ charCount: {{ strlen($category->name) }} }">
                                <label for="name" class="block text-sm font-medium text-text">
                                    {{ __('admin.category.name') }}
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                                        required maxlength="50" x-on:input="charCount = $event.target.value.length"
                                        class="block w-full rounded-md border-border bg-background text-text focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                                </div>
                                <p class="mt-1 text-xs"
                                    :class="{ 'text-red-500': charCount > 50, 'text-muted': charCount <= 50 }">
                                    <span x-text="charCount"></span>/50 characters
                                </p>
                            </div>

                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('admin.categories.index') }}"
                                    class="inline-flex items-center px-4 py-2 border border-border rounded-md shadow-sm text-sm font-medium text-text bg-surface hover:bg-background focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    {{ __('admin.common.cancel') }}
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    <x-lucide-save class="w-4 h-4 mr-2" />
                                    {{ __('admin.category.update_category') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>