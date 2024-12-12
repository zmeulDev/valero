@props(['categories', 'article'])

<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden"
     x-data="{ isOpen: localStorage.getItem('options-expanded') === 'true' }"
     x-init="$watch('isOpen', value => localStorage.setItem('options-expanded', value))">
    <!-- Header -->
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center cursor-pointer"
         @click.prevent.stop="isOpen = !isOpen">
        <div class="flex items-center gap-2">
            <x-lucide-settings class="w-5 h-5 text-indigo-500" />
            <div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                    Article Options
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                    Category and scheduling settings
                </p>
            </div>
        </div>
        <button type="button" 
                @click.prevent.stop="isOpen = !isOpen"
                class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-transform duration-200"
                :class="{ 'rotate-180': isOpen }">
            <x-lucide-chevron-down class="w-5 h-5" />
        </button>
    </div>

    <!-- Content -->
    <div class="border-t border-gray-200 dark:border-gray-700"
         x-show="isOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2">
        
        <!-- Category Selection -->
        <div class="p-4 sm:p-6 space-y-6">
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Category <span class="text-red-500">*</span>
                </label>
                <select name="category_id"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                        required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                            {{ old('category_id', $article?->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Scheduled Date -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Scheduled Publish Date
                </label>
                <input type="datetime-local" 
                       name="scheduled_at"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                       value="{{ old('scheduled_at', $article?->scheduled_at ? $article->scheduled_at : now()) }}">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Leave empty to publish immediately
                </p>
            </div>
        </div>
    </div>
</div>
