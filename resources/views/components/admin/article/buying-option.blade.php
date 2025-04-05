@props(['article'])

<div class="space-y-6">
    <!-- Amazon Link -->
    <div>
        <label for="amazon_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Amazon Link
        </label>
        <input type="url" 
               id="amazon_link" 
               name="amazon_link" 
               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
               value="{{ old('amazon_link', $article?->amazon_link) }}"
               placeholder="https://amazon.com/...">
    </div>

    <!-- eBay Link -->
    <div>
        <label for="ebay_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            eBay Link
        </label>
        <input type="url" 
               id="ebay_link" 
               name="ebay_link" 
               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
               value="{{ old('ebay_link', $article?->ebay_link) }}"
               placeholder="https://ebay.com/...">
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

    <!-- Price Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Lowest Price -->
        <div>
            <label for="lowest_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Lowest Price ($)
            </label>
            <input type="number" 
                   id="lowest_price" 
                   name="lowest_price" 
                   step="0.01"
                   min="0"
                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
                   value="{{ old('lowest_price', $article?->lowest_price) }}"
                   placeholder="0.00">
        </div>

        <!-- Average Price -->
        <div>
            <label for="average_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Average Price ($)
            </label>
            <input type="number" 
                   id="average_price" 
                   name="average_price" 
                   step="0.01"
                   min="0"
                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
                   value="{{ old('average_price', $article?->average_price) }}"
                   placeholder="0.00">
        </div>
    </div>
</div>
