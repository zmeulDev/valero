@props(['article', 'categories', 'scheduledArticles'])

<div class="bg-white dark:bg-gray-800 overflow-hidden">
    <div class="p-4 sm:p-6">
       
        
        <div class="space-y-6">
            <!-- Category and Scheduled Date in a grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category Selection -->
                <div class="space-y-2">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="category_id" 
                                name="category_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white appearance-none pr-10"
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
                    <p class="text-xs text-gray-500 dark:text-gray-400">Select the category that best fits your article content</p>
                </div>

                <!-- Scheduled Publish Date -->
                <div class="space-y-2">
                    <label for="scheduled_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Scheduled Publish Date
                    </label>
                    <div class="relative">
                        <input type="datetime-local" 
                               id="scheduled_at"
                               name="scheduled_at" 
                               value="{{ old('scheduled_at', $article?->scheduled_at?->format('Y-m-d\TH:i')) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white pr-10">
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Leave empty to publish immediately, or set a future date to schedule</p>
                </div>
            </div>

            <!-- Scheduled Articles Calendar View -->
            <x-admin.article.schedule-option :scheduledArticles="$scheduledArticles" />
        </div>
    </div>
</div>
