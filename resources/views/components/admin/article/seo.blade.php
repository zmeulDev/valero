@props(['article'])

@if(!$article)
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-4 py-5 sm:px-6">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('admin.sidebar.seo_info_description') }}
            </p>
            <p class="mt-2 text-sm text-gray-400 dark:text-gray-500">
                No article data available.
            </p>
        </div>
    </div>
@else
@php
    // Get SEO data
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
    
    // Get keyword density
    $keywordDensity = $article->getKeywordDensity();
    
    // Calculate reading time and word count
    $wordCount = str_word_count(strip_tags($article->content));
    $readingTime = ceil($wordCount / 200);
    
    // Get canonical URL
    $canonicalUrl = url(route('articles.index', ['slug' => $article->slug]));
@endphp

<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden"
     x-data="{ isOpen: localStorage.getItem('seo-expanded') === 'true' }"
     x-init="$watch('isOpen', value => localStorage.setItem('seo-expanded', value))">
    <!-- Header -->
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center cursor-pointer"
         @click.prevent.stop="isOpen = !isOpen">
        <div class="flex items-center gap-2">
            <x-lucide-search class="w-5 h-5 text-indigo-500" />
            <div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                    {{ __('admin.sidebar.seo_info') }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                    {{ __('admin.sidebar.seo_info_description') }}
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
        <dl class="divide-y divide-gray-200 dark:divide-gray-700">
            <!-- SEO Title -->
            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ __('admin.sidebar.seo_title') }}
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2">
                    <div class="space-y-1">
                        <div>{{ $seoData->title }}</div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs {{ $titleValidation['is_optimal'] ? 'text-green-600 dark:text-green-400' : ($titleValidation['is_valid'] ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
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
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $titleValidation['message'] }}</p>
                    </div>
                </dd>
            </div>

            <!-- SEO Description -->
            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ __('admin.sidebar.seo_description') }}
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2">
                    <div class="space-y-1">
                        <div>{{ $seoData->description }}</div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs {{ $descriptionValidation['is_optimal'] ? 'text-green-600 dark:text-green-400' : ($descriptionValidation['is_valid'] ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
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
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $descriptionValidation['message'] }}</p>
                    </div>
                </dd>
            </div>

            <!-- SEO Image -->
            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ __('admin.sidebar.seo_image') }}
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2">
                    <div class="space-y-2">
                        <img src="{{ $imageUrl }}"
                             alt="{{ $coverMedia?->alt_text ?? $article->title }}"
                             class="w-32 h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                        @if($coverMedia)
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                @if($coverMedia->dimensions)
                                    {{ $coverMedia->dimensions['width'] ?? 'N/A' }}x{{ $coverMedia->dimensions['height'] ?? 'N/A' }}px
                                @endif
                                @if(isset($coverMedia->dimensions['width']) && $coverMedia->dimensions['width'] >= 1200)
                                    <span class="text-green-600 dark:text-green-400 ml-2">✓ Google Discovery ready</span>
                                @elseif(isset($coverMedia->dimensions['width']))
                                    <span class="text-yellow-600 dark:text-yellow-400 ml-2">⚠ Min 1200px recommended</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </dd>
            </div>

            <!-- Author -->
            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ __('admin.sidebar.seo_author') }}
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2">
                    {{ $seoData->author }}
                </dd>
            </div>

            <!-- Category/Section -->
            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Section
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2">
                    {{ $seoData->section ?? $article->category->name ?? __('admin.sidebar.not_set') }}
                </dd>
            </div>

            <!-- Tags -->
            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Tags
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2">
                    @if(count($article->tags_array ?? []) > 0)
                        <div class="flex flex-wrap gap-1">
                            @foreach($article->tags_array as $tag)
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                    {{ trim($tag) }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <span class="text-gray-400 dark:text-gray-500">{{ __('admin.sidebar.not_set') }}</span>
                    @endif
                </dd>
            </div>

            <!-- Canonical URL -->
            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ __('admin.sidebar.seo_canonical_url') }}
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2 break-all">
                    <a href="{{ $canonicalUrl }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                        {{ $canonicalUrl }}
                    </a>
                </dd>
            </div>

            <!-- Content Metrics -->
            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Content Metrics
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2 space-y-2">
                    <div class="flex items-center justify-between">
                        <span>Word Count:</span>
                        <span class="{{ $contentValidation['is_optimal'] ? 'text-green-600 dark:text-green-400' : ($contentValidation['is_valid'] ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                            {{ number_format($wordCount) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Reading Time:</span>
                        <span>{{ $readingTime }} {{ __('frontend.common.minutes') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Readability:</span>
                        <span class="{{ $readability['score'] >= 60 ? 'text-green-600 dark:text-green-400' : ($readability['score'] >= 50 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                            {{ $readability['score'] }}/100 ({{ $readability['level'] }})
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $contentValidation['message'] }}</p>
                </dd>
            </div>

            <!-- Keyword Density -->
            @if(isset($keywordDensity['keyword']) && !empty($keywordDensity['keyword']))
            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Keyword Density
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2 space-y-1">
                    <div class="flex items-center justify-between">
                        <span>Keyword: <strong>{{ $keywordDensity['keyword'] }}</strong></span>
                        <span class="{{ $keywordDensity['is_optimal'] ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                            {{ $keywordDensity['density'] }}% ({{ $keywordDensity['count'] }} occurrences)
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $keywordDensity['message'] }}</p>
                </dd>
            </div>
            @endif

            <!-- Published/Modified Dates -->
            <div class="px-4 py-4 sm:px-6 grid grid-cols-3 gap-4">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Dates
                </dt>
                <dd class="text-sm text-gray-900 dark:text-gray-300 col-span-2 space-y-1">
                    <div>Published: {{ $article->created_at->format('Y-m-d H:i') }}</div>
                    <div>Modified: {{ $article->updated_at->format('Y-m-d H:i') }}</div>
                </dd>
            </div>
        </dl>
    </div>
</div>
@endif