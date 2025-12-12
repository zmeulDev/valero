@if($relatedArticles->count() > 0)
<section class="mt-16 pt-10 border-t border-gray-200 dark:border-gray-700" aria-label="{{ __('frontend.article.related_articles') }}">
    {{-- Modern Section Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">
                {{ __('frontend.article.related_articles') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Continue exploring similar topics</p>
        </div>
        @if(isset($currentArticle) && $currentArticle->category)
            <a href="{{ route('category.index', $currentArticle->category->slug) }}" 
               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-colors"
               onclick="event.stopPropagation();">
                <span>{{ __('frontend.article.view_all_in') }} {{ $currentArticle->category->name }}</span>
                <x-lucide-arrow-right class="w-4 h-4" />
            </a>
        @endif
    </div>

    {{-- Clean 3-Column Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($relatedArticles->take(3) as $relatedArticle)
            <article class="group relative flex flex-col bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600 transition-all duration-300">
                <a href="{{ route('articles.index', $relatedArticle->slug) }}" class="absolute inset-0 z-10" aria-label="{{ $relatedArticle->title }}"></a>
                
                {{-- Image with Overlay --}}
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
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                            loading="lazy"
                        >
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <x-lucide-image class="w-16 h-16 text-gray-300 dark:text-gray-600" />
                        </div>
                    @endif
                    
                    {{-- Subtle Gradient --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    {{-- Category Badge --}}
                    <div class="absolute top-3 left-3 z-20">
                        <span class="inline-flex items-center px-3 py-1 text-xs font-medium bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm text-indigo-600 dark:text-indigo-400 rounded-full shadow-sm">
                            <x-lucide-tag class="w-3 h-3 mr-1.5" />
                            {{ $relatedArticle->category->name }}
                        </span>
                    </div>
                </div>

                {{-- Content Area --}}
                <div class="flex-1 p-5 flex flex-col">
                    {{-- Title --}}
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-tight mb-3 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        {{ $relatedArticle->title }}
                    </h3>

                    {{-- Excerpt --}}
                    @if($relatedArticle->excerpt)
                        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed mb-4 line-clamp-2 flex-grow">
                            {{ $relatedArticle->excerpt }}
                        </p>
                    @endif

                    {{-- Meta Information --}}
                    <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-gray-700 text-xs text-gray-500 dark:text-gray-400 mt-auto">
                        <time datetime="{{ $relatedArticle->created_at->toIso8601String() }}" class="flex items-center gap-1.5">
                            <x-lucide-calendar class="w-3.5 h-3.5" />
                            <span>{{ $relatedArticle->created_at->format('M d, Y') }}</span>
                        </time>
                        @if($relatedArticle->views > 0)
                            <span class="flex items-center gap-1.5">
                                <x-lucide-eye class="w-3.5 h-3.5" />
                                {{ number_format($relatedArticle->views) }}
                            </span>
                        @endif
                        <span class="flex items-center gap-1.5 ml-auto">
                            <x-lucide-clock class="w-3.5 h-3.5" />
                            {{ $relatedArticle->reading_time }}
                        </span>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
</section>
@endif
