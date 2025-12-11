@props(['article', 'categories', 'scheduledArticles'])

<div class="bg-white dark:bg-gray-800 overflow-hidden">
    <div class="p-4 sm:p-6">
       
        
        <div class="space-y-6">
            <!-- Category and Scheduled Date in a grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category Selection -->
                <div class="space-y-2">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('admin.articles.category') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="category_id" 
                                name="category_id"
                                class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white appearance-none pr-10 @error('category_id') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror">
                            <option value="">{{ __('admin.articles.select_category') }}</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                    {{ old('category_id', $article?->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @error('category_id')
                        <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @else
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.articles.select_category_description') }}</p>
                    @enderror
                </div>

                <!-- Scheduled Publish Date -->
                <div class="space-y-2">
                    <label for="scheduled_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('admin.articles.scheduled_publish_date') }}
                    </label>
                    <div class="relative">
                        <input type="datetime-local" 
                               id="scheduled_at"
                               name="scheduled_at" 
                               value="{{ old('scheduled_at', $article?->scheduled_at?->format('Y-m-d\TH:i')) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white pr-10">
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin.articles.scheduled_publish_date_description') }}</p>
                </div>
            </div>

            <!-- Scheduled Articles Calendar View -->
            <x-admin.article.schedule-option :scheduledArticles="$scheduledArticles" />

            <!-- Publish/Update Button Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 sticky top-6">
                <div class="p-6">
                    @if($article)
                        <!-- Edit View: Show status and View Live button -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('admin.articles.last_updated') }}: {{ $article->updated_at->diffForHumans() }}
                            </span>
                            <span class="px-3 py-1 text-xs font-medium {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} rounded-full">
                                {{ ucfirst($article->status) }}
                            </span>
                        </div>
                        <div class="flex gap-3">
                            <!-- View Live Button -->
                            <a href="{{ $article->scheduled_at && $article->scheduled_at->isFuture() ? route('articles.preview', $article->slug) : route('articles.index', $article->slug) }}" 
                               target="_blank" 
                               class="flex-1 inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 dark:text-indigo-300 dark:bg-indigo-900/30 dark:hover:bg-indigo-900/50 transition duration-150 ease-in-out">
                                <x-lucide-external-link class="w-4 h-4 mr-1.5" />
                                {{ __('admin.articles.preview_article') }}
                            </a>
                            
                            <!-- Submit Button -->
                            <button type="submit"
                                    :disabled="submitting"
                                    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2.5 rounded-lg shadow-sm transition duration-150 ease-in-out flex items-center justify-center disabled:opacity-75 disabled:cursor-not-allowed">
                                <template x-if="!submitting">
                                    <div class="flex items-center">
                                        <x-lucide-save class="w-5 h-5 mr-2" />
                                        {{ __('admin.articles.update_article') }}
                                    </div>
                                </template>
                                <template x-if="submitting">
                                    <div class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        {{ __('admin.articles.updating') }}
                                    </div>
                                </template>
                            </button>
                        </div>
                    @else
                        <!-- Create View: Show only Create button -->
                        <button type="submit"
                                :disabled="submitting"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-sm transition duration-150 ease-in-out flex items-center justify-center disabled:opacity-75 disabled:cursor-not-allowed">
                            <template x-if="!submitting">
                                <div class="flex items-center">
                                    <x-lucide-plus class="w-5 h-5 mr-2" />
                                    {{ __('admin.articles.create_article') }}
                                </div>
                            </template>
                            <template x-if="submitting">
                                <div class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    {{ __('admin.articles.creating') }}...
                                </div>
                            </template>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
