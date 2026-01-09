@props(['article', 'categories', 'scheduledArticles'])

<div class="bg-surface overflow-hidden border border-border rounded-lg shadow-sm">
    <div class="p-4 sm:p-6">
       
        
        <div class="space-y-6">
            <!-- Category and Scheduled Date in a grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category Selection -->
                <div class="space-y-2">
                    <label for="category_id" class="block text-sm font-medium text-text">
                        {{ __('admin.articles.category') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="category_id" 
                                name="category_id"
                                class="w-full px-3 py-2 border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-background text-text appearance-none pr-10 @error('category_id') border-red-500 dark:border-red-500 @else border-border @enderror">
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
                    <p class="text-xs text-muted">{{ __('admin.articles.select_category_description') }}</p>
                    @enderror
                </div>

                <!-- Scheduled Publish Date -->
                <div class="space-y-2">
                    <label for="scheduled_at" class="block text-sm font-medium text-text">
                        {{ __('admin.articles.scheduled_publish_date') }}
                    </label>
                    <div class="relative">
                        <input type="datetime-local" 
                               id="scheduled_at"
                               name="scheduled_at" 
                               value="{{ old('scheduled_at', $article?->scheduled_at?->format('Y-m-d\TH:i')) }}"
                               class="w-full px-3 py-2 border border-border rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 bg-background text-text pr-10">
                    </div>
                    <p class="text-xs text-muted">{{ __('admin.articles.scheduled_publish_date_description') }}</p>
                </div>
            </div>

            <!-- Scheduled Articles Calendar View -->
            <x-admin.article.schedule-option :scheduledArticles="$scheduledArticles" />

        </div>
    </div>
</div>
