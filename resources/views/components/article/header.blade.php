<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="relative w-full mb-8 mt-8 group">
    <div class="relative overflow-hidden rounded-2xl aspect-[16/9] bg-gray-100 dark:bg-gray-800">
        @if($article->media->firstWhere('is_cover', true)->image_path ?? false)
            <!-- Main Image -->
            <img 
                src="{{ asset('storage/' . $article->media->firstWhere('is_cover', true)->image_path) }}"
                alt="{{ $article->title }}"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                loading="lazy"
            >
            
            <!-- Subtle Gradient Overlay for Text Readability -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
        @else
            <!-- Fallback when no image -->
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900">
                <x-lucide-image class="w-16 h-16 text-gray-400 dark:text-gray-600" />
            </div>
        @endif
    </div>
</div>

<!-- Article Header Content -->
<header class="relative mx-auto pt-6 pb-6">
    <div class="flex flex-col md:flex-row gap-6">
        <!-- Author Card -->
        <div class="md:w-56 shrink-0">
            <!-- Like Button -->
            <div class="sticky top-8">
                <button 
                    data-article-id="{{ $article->id }}"
                    class="like-button group w-full inline-flex items-center justify-center gap-3 px-6 py-3 mb-2 bg-white dark:bg-gray-800 hover:bg-rose-50 dark:hover:bg-rose-900/10 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-rose-200 dark:hover:border-rose-700 transition-all duration-300 shadow-sm hover:shadow-md"
                >
                    <x-lucide-thumbs-up 
                        id="likeIcon-{{ $article->id }}"
                        class="w-5 h-5 text-gray-400 group-hover:text-rose-500 dark:text-gray-500 dark:group-hover:text-rose-400 transition-colors duration-300" 
                    />
                    <span id="likeCount-{{ $article->id }}" 
                            class="text-sm font-semibold text-gray-700 group-hover:text-rose-600 dark:text-gray-300 dark:group-hover:text-rose-400 transition-colors duration-300">
                        {{ number_format($article->likes_count ?? 0) }}
                    </span>
                </button>
            </div>
            <div class="sticky top-8">
                <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-100 dark:border-gray-700">
                <!-- Author Profile - Horizontal Layout -->
                    <div class="flex items-center gap-3 mb-4">
                        <div class="relative">
                            <img src="{{ $article->user->profile_photo_url }}" 
                                 alt="{{ $article->user->name }}" 
                                 class="w-12 h-12 rounded-full object-cover ring-2 ring-white dark:ring-gray-700">
                            <div class="absolute -bottom-0.5 -right-0.5 bg-green-500 w-3 h-3 rounded-full border-2 border-white dark:border-gray-800"></div>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                                {{ $article->user->name }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $article->author->title ?? 'Author' }}
                            </p>
                        </div>
                    </div>

                    <!-- Compact Meta Info -->
                    <div class="space-y-2.5 text-sm border-t border-gray-100 dark:border-gray-700 pt-4">
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <x-lucide-git-pull-request class="w-4 h-4 text-indigo-500 dark:text-indigo-400" />
                            <time datetime="{{ $article->created_at }}">
                                Create: {{ $article->created_at->format('M d, Y') }}
                            </time>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <x-lucide-git-merge class="w-4 h-4 text-indigo-500 dark:text-indigo-400" />
                            <time datetime="{{ $article->updated_at }}">
                               Update: {{ $article->updated_at->format('M d, Y') }}
                            </time>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content - More Compact -->
        <div class="flex-1 space-y-6">
            <!-- Title and Category -->
            <div class="space-y-3">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white tracking-tight leading-tight">
                    {{ $article->title }}
                </h1>
                <div class="flex items-center gap-3">
                    <a href="{{ route('category.index', $article->category->slug) }}" 
                       class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full text-sm font-medium">
                        <x-lucide-tag class="w-3.5 h-3.5" />
                        {{ $article->category->name }}
                    </a>

                    <a href="" 
                       class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full text-sm font-medium">
                        <x-lucide-eye class="w-3.5 h-3.5" />
                        {{ number_format($article->views) }} views
                    </a>

                    <a href="" 
                       class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-full text-sm font-medium">
                        <x-lucide-clock class="w-3.5 h-3.5" />
                        {{ $article->reading_time }}
                    </a>
                </div>
                
            </div>

            <!-- Compact Excerpt Box -->
            <blockquote class="relative p-6 text-base md:text-lg text-gray-600 dark:text-gray-300 leading-relaxed rounded-xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700">
                {{ $article->excerpt }}
            </blockquote>
        </div>
    </div>
</header>
