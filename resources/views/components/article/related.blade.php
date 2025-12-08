@if($relatedArticles->count() > 0)
<section class="mt-16 pt-12 border-t-2 border-gray-200 dark:border-gray-700" aria-label="{{ __('frontend.article.related_articles') }}">
    {{-- Enhanced Section Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-10 gap-4">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-3">
                <x-lucide-book-open class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ __('frontend.article.related_articles') }}
                </h2>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300">
                {{ $relatedArticles->count() }}
            </span>
        </div>
        @if(isset($currentArticle) && $currentArticle->category)
            <a href="{{ route('category.index', $currentArticle->category->slug) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-colors"
               onclick="event.stopPropagation();">
                <span>More in {{ $currentArticle->category->name }}</span>
                <x-lucide-arrow-right class="w-4 h-4" />
            </a>
        @endif
    </div>

    {{-- Related Articles Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($relatedArticles as $relatedArticle)
            <article class="group relative flex flex-col bg-white dark:bg-gray-800 rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-indigo-100/50 dark:hover:shadow-indigo-900/20 border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600 hover:-translate-y-1">
                <a href="{{ route('articles.index', $relatedArticle->slug) }}" class="absolute inset-0 z-10" aria-label="{{ $relatedArticle->title }}"></a>
                
                {{-- Image Container --}}
                <div class="relative aspect-[16/9] overflow-hidden bg-gray-100 dark:bg-gray-700">
                    @php
                        $coverMedia = $relatedArticle->media->firstWhere('is_cover', true);
                    @endphp
                    @if($coverMedia?->image_path ?? false)
                        <img 
                            src="{{ asset('storage/' . $coverMedia->image_path) }}" 
                            alt="{{ $coverMedia->alt_text ?: $relatedArticle->title }}"
                            @if($coverMedia->dimensions)
                                width="{{ $coverMedia->dimensions['width'] ?? 600 }}"
                                height="{{ $coverMedia->dimensions['height'] ?? 338 }}"
                            @endif
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                            loading="lazy"
                        >
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <x-lucide-image class="w-16 h-16 text-gray-400 dark:text-gray-500" />
                        </div>
                    @endif
                    
                    {{-- Gradient Overlay on Hover --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    {{-- Category Badge --}}
                    <div class="absolute top-4 left-4 z-20">
                        <a href="{{ route('category.index', $relatedArticle->category->slug) }}" 
                           class="inline-flex items-center px-3 py-1.5 text-xs font-semibold bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm text-indigo-600 dark:text-indigo-400 rounded-full shadow-lg hover:bg-white dark:hover:bg-gray-900 transition-colors"
                           onclick="event.stopPropagation();">
                            <x-lucide-tag class="w-3 h-3 mr-1" />
                            {{ $relatedArticle->category->name }}
                        </a>
                    </div>

                    {{-- Views Badge --}}
                    @if($relatedArticle->views > 0)
                        <div class="absolute top-4 right-4 z-20">
                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium bg-black/50 backdrop-blur-sm text-white rounded-full">
                                <x-lucide-eye class="w-3 h-3 mr-1" />
                                {{ number_format($relatedArticle->views) }}
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Content --}}
                <div class="flex-1 p-6 flex flex-col">
                    {{-- Title --}}
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white leading-tight mb-3 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        {{ $relatedArticle->title }}
                    </h3>

                    {{-- Excerpt --}}
                    @if($relatedArticle->excerpt)
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-3 flex-grow">
                            {{ $relatedArticle->excerpt }}
                        </p>
                    @endif

                    {{-- Meta Information --}}
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700 mt-auto">
                        <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                            <time datetime="{{ $relatedArticle->created_at->toIso8601String() }}" class="flex items-center gap-1.5">
                                <x-lucide-calendar class="w-4 h-4" />
                                <span>{{ $relatedArticle->created_at->format('M d, Y') }}</span>
                            </time>
                            <span class="flex items-center gap-1.5">
                                <x-lucide-clock class="w-4 h-4" />
                                <span>{{ $relatedArticle->reading_time }}</span>
                            </span>
                        </div>
                        
                        @if($relatedArticle->likes_count > 0)
                            <div class="flex items-center gap-1 text-xs text-gray-500 dark:text-gray-400">
                                <x-lucide-thumbs-up class="w-4 h-4" />
                                <span>{{ number_format($relatedArticle->likes_count) }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Read More Link --}}
                    <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <span class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 dark:text-indigo-400 group-hover:text-indigo-700 dark:group-hover:text-indigo-300 transition-colors">
                            {{ __('frontend.article.read_more') }}
                            <x-lucide-arrow-right class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" />
                        </span>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif
