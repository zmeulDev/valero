@props(['article'])

<div class="space-y-6">
    <!-- YouTube Link -->
    <div>
        <label for="youtube_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            YouTube Link
        </label>
        <input type="url" 
               id="youtube_link" 
               name="youtube_link" 
               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
               value="{{ old('youtube_link', $article?->youtube_link) }}"
               placeholder="https://youtube.com/...">
    </div>

    <!-- Instagram Link -->
    <div>
        <label for="instagram_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Instagram Link
        </label>
        <input type="url" 
               id="instagram_link" 
               name="instagram_link" 
               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
               value="{{ old('instagram_link', $article?->instagram_link) }}"
               placeholder="https://instagram.com/...">
    </div>

    <!-- Local Store Link -->
    <div>
        <label for="local_store_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Local Store Link
        </label>
        <input type="url" 
               id="local_store_link" 
               name="local_store_link" 
               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
               value="{{ old('local_store_link', $article?->local_store_link) }}"
               placeholder="https://...">
    </div>
</div>
