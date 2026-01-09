@props(['article'])

<div class="space-y-6">
    <!-- SEO Input Fields -->
    <div class="bg-surface shadow-sm rounded-lg border border-border p-6">
        <h3 class="text-lg font-medium text-text mb-4">{{ __('admin.sidebar.seo_settings') }}
        </h3>

        <div class="space-y-4">
            <!-- SEO Title -->
            <div>
                <label for="seo_title" class="block text-sm font-medium text-text">
                    {{ __('admin.sidebar.seo_title') }}
                </label>
                <div class="mt-1">
                    <input type="text" name="seo_title" id="seo_title"
                        value="{{ old('seo_title', $article?->seo?->title ?? '') }}"
                        placeholder="{{ $article?->title ?? __('admin.articles.title_placeholder') }}"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-border bg-background text-text rounded-md placeholder-muted">
                </div>
                <p class="mt-1 text-xs text-muted">{{ __('admin.sidebar.seo_title_help') }}</p>
            </div>

            <!-- SEO Description -->
            <div>
                <label for="seo_description" class="block text-sm font-medium text-text">
                    {{ __('admin.sidebar.seo_description') }}
                </label>
                <div class="mt-1">
                    <textarea name="seo_description" id="seo_description" rows="3"
                        placeholder="{{ $article?->excerpt ?? __('admin.articles.excerpt_placeholder') }}"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-border bg-background text-text rounded-md placeholder-muted">{{ old('seo_description', $article?->seo?->description ?? '') }}</textarea>
                </div>
                <p class="mt-1 text-xs text-muted">{{ __('admin.sidebar.seo_description_help') }}
                </p>
            </div>

            <!-- Canonical URL -->
            <div>
                <label for="seo_canonical_url" class="block text-sm font-medium text-text">
                    {{ __('admin.sidebar.seo_canonical_url') }}
                </label>
                <div class="mt-1">
                    <input type="url" name="seo_canonical_url" id="seo_canonical_url"
                        value="{{ old('seo_canonical_url', $article?->seo?->canonical_url ?? '') }}"
                        placeholder="{{ $article ? route('articles.index', $article->slug) : '' }}"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-border bg-background text-text rounded-md placeholder-muted">
                </div>
            </div>

            <!-- Robots -->
            <div>
                <label for="seo_robots" class="block text-sm font-medium text-text">
                    {{ __('admin.sidebar.seo_robots') }}
                </label>
                <div class="mt-1">
                    <input type="text" name="seo_robots" id="seo_robots"
                        value="{{ old('seo_robots', $article?->seo?->robots ?? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1') }}"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-border bg-background text-text rounded-md placeholder-muted">
                </div>
            </div>
        </div>
    </div>

    <!-- SEO Analysis (Read-Only) -->
    @if($article && $article->exists)
        @php
            // Get SEO data for analysis (using stored data)
            $seoData = $article->getDynamicSEOData();
            $coverMedia = $article->media->firstWhere('is_cover', true);
            $imageUrl = $coverMedia
                ? url(asset('storage/' . $coverMedia->image_path))
                : url(asset('storage/brand/logo.png'));

            // Get SEO validation metrics
            $seoValidation = $article->getSEOValidation();
            $titleValidation = $seoValidation['title'];
            $descriptionValidation = $seoValidation['description'];
            $contentValidation = $seoValidation['content_length'];
            $readability = $seoValidation['readability'];

            // Keyword density
            $keywordDensity = $article->getKeywordDensity();
            $wordCount = str_word_count(strip_tags($article->content));
            $readingTime = ceil($wordCount / 200);
        @endphp

        <div class="bg-surface shadow-sm rounded-lg border border-border overflow-hidden"
            x-data="{ isOpen: localStorage.getItem('seo-analysis-expanded') === 'true' }"
            x-init="$watch('isOpen', value => localStorage.setItem('seo-analysis-expanded', value))">

            <div class="px-4 py-5 sm:px-6 flex justify-between items-center cursor-pointer bg-background"
                @click.prevent.stop="isOpen = !isOpen">
                <div class="flex items-center gap-2">
                    <x-lucide-bar-chart-2 class="w-5 h-5 text-indigo-500" />
                    <div>
                        <h3 class="text-base font-semibold text-text">
                            {{ __('admin.sidebar.seo_analysis') }}
                        </h3>
                        <p class="mt-1 text-sm text-muted">
                            {{ __('admin.sidebar.seo_analysis_description') }}
                        </p>
                    </div>
                </div>
                <button type="button" class="text-muted hover:text-text transition-transform duration-200"
                    :class="{ 'rotate-180': isOpen }">
                    <x-lucide-chevron-down class="w-5 h-5" />
                </button>
            </div>

            <div x-show="isOpen" x-collapse class="border-t border-border">
                <dl class="divide-y divide-border">
                    <!-- Validation status for saved Title -->
                    <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-muted">
                            {{ __('admin.sidebar.seo_title') }} (Saved)
                        </dt>
                        <dd class="text-sm text-text col-span-2">
                            <div class="space-y-1">
                                <div>{{ $seoData->title }}</div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-xs {{ $titleValidation['is_optimal'] ? 'text-green-600 dark:text-green-400' : ($titleValidation['is_valid'] ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                                        {{ $titleValidation['length'] }} chars
                                    </span>
                                    @if($titleValidation['is_optimal'])
                                        <x-lucide-check-circle class="w-4 h-4 text-green-600 dark:text-green-400" />
                                    @elseif($titleValidation['is_valid'])
                                        <x-lucide-alert-circle class="w-4 h-4 text-yellow-600 dark:text-yellow-400" />
                                    @else
                                        <x-lucide-x-circle class="w-4 h-4 text-red-600 dark:text-red-400" />
                                    @endif
                                </div>
                                <p class="text-xs text-muted">{{ $titleValidation['message'] }}</p>
                            </div>
                        </dd>
                    </div>

                    <!-- Validation status for saved Description -->
                    <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-muted">
                            {{ __('admin.sidebar.seo_description') }} (Saved)
                        </dt>
                        <dd class="text-sm text-text col-span-2">
                            <div class="space-y-1">
                                <div>{{ $seoData->description }}</div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-xs {{ $descriptionValidation['is_optimal'] ? 'text-green-600 dark:text-green-400' : ($descriptionValidation['is_valid'] ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                                        {{ $descriptionValidation['length'] }} chars
                                    </span>
                                    @if($descriptionValidation['is_optimal'])
                                        <x-lucide-check-circle class="w-4 h-4 text-green-600 dark:text-green-400" />
                                    @elseif($descriptionValidation['is_valid'])
                                        <x-lucide-alert-circle class="w-4 h-4 text-yellow-600 dark:text-yellow-400" />
                                    @else
                                        <x-lucide-x-circle class="w-4 h-4 text-red-600 dark:text-red-400" />
                                    @endif
                                </div>
                                <p class="text-xs text-muted">{{ $descriptionValidation['message'] }}
                                </p>
                            </div>
                        </dd>
                    </div>

                    <!-- Content Analysis -->
                    <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-muted">
                            {{ __('admin.sidebar.seo_content_analysis') }}
                        </dt>
                        <dd class="text-sm text-text col-span-2 space-y-2">
                            <div class="flex items-center justify-between">
                                <span>Word Count:</span>
                                <span>{{ number_format($wordCount) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Readability:</span>
                                <span
                                    class="{{ $readability['score'] >= 60 ? 'text-green-600 dark:text-green-400' : ($readability['score'] >= 50 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                                    {{ $readability['score'] }}/100 ({{ $readability['level'] }})
                                </span>
                            </div>
                        </dd>
                    </div>

                    <!-- SEO Image Preview -->
                    <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-muted">
                            {{ __('admin.sidebar.seo_image') }}
                        </dt>
                        <dd class="text-sm text-text col-span-2">
                            <img src="{{ $imageUrl }}" class="w-32 h-32 object-cover rounded-lg border border-border">
                            @if($coverMedia && isset($coverMedia->dimensions['width']) && $coverMedia->dimensions['width'] >= 1200)
                                <div class="mt-1 text-xs text-green-600 dark:text-green-400">✓ Google Discovery ready</div>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    @endif
</div>