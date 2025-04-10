<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header
            icon="book-open"
            title="{{ __('admin.articles.preview_article') }}"
            description="{{ __('admin.articles.description') }}"
            :breadcrumbs="[
                ['label' => __('admin.articles.breadcrumbs'), 'url' => route('admin.articles.index')],
                ['label' => __('admin.articles.preview')]
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('admin.articles.edit', $article->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <x-lucide-pencil class="w-4 h-4 mr-2" />
                    {{ __('admin.articles.edit_article') }}
                </a>
                <a href="{{ route('admin.articles.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                    {{ __('admin.articles.back_to_articles') }}
                </a>
            </x-slot:actions>
        </x-admin.page-header>
    </x-slot>

    <div class="min-h-screen dark:bg-gray-900">
        <div class="container mx-auto px-4 py-8">
            <!-- Preview Mode Toggle -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <x-lucide-eye class="w-5 h-5 text-indigo-500" />
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('admin.articles.preview_mode') }}</h3>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.common.view') }}:</span>
                            <div class="flex rounded-md shadow-sm">
                                <button type="button" class="px-3 py-1.5 text-sm font-medium rounded-l-md bg-indigo-600 text-white">
                                    {{ __('admin.articles.desktop') }}
                                </button>
                                <button type="button" class="px-3 py-1.5 text-sm font-medium border-t border-b border-r border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                    {{ __('admin.articles.tablet') }}
                                </button>
                                <button type="button" class="px-3 py-1.5 text-sm font-medium border-t border-b border-r border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-r-md">
                                    {{ __('admin.articles.mobile') }}
                                </button>
                            </div>
                        </div>
                        <a href="{{ $article->scheduled_at && $article->scheduled_at->isFuture() ? route('articles.preview', $article->slug) : route('articles.index', $article->slug) }}" target="_blank" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 dark:text-indigo-300 dark:bg-indigo-900/30 dark:hover:bg-indigo-900/50">
                            <x-lucide-external-link class="w-4 h-4 mr-1.5" />
                            {{ __('admin.articles.view_live') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Main Content Column -->
                <div class="lg:col-span-3">
                    <article class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                        <div class="px-6 pb-8">
                            <!-- Article Header -->
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
                                                            {{ $article->author->title ?? __('admin.articles.author') }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Compact Meta Info -->
                                                <div class="space-y-2.5 text-sm border-t border-gray-100 dark:border-gray-700 pt-4">
                                                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                                        <x-lucide-git-pull-request class="w-4 h-4 text-indigo-500 dark:text-indigo-400" />
                                                        <time datetime="{{ $article->created_at }}">
                                                            {{ __('admin.status.created_at') }}: {{ $article->created_at->format('M d, Y') }}
                                                        </time>
                                                    </div>
                                                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                                        <x-lucide-git-merge class="w-4 h-4 text-indigo-500 dark:text-indigo-400" />
                                                        <time datetime="{{ $article->updated_at }}">
                                                            {{ __('admin.status.updated_at') }}: {{ $article->updated_at->format('M d, Y') }}
                                                        </time>
                                                    </div>
                                                    @if($article->scheduled_at)
                                                    <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                                                        <x-lucide-calendar class="w-4 h-4 text-indigo-500 dark:text-indigo-400" />
                                                        <time datetime="{{ $article->scheduled_at }}">
                                                            {{ __('admin.status.scheduled_at') }}: {{ \Carbon\Carbon::parse($article->scheduled_at)->format('M d, Y') }}
                                                        </time>
                                                    </div>
                                                    @endif
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
                                            </div>
                                        </div>

                                        <!-- Excerpt -->
                                        @if($article->excerpt)
                                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg border border-gray-100 dark:border-gray-600">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <x-lucide-quote class="w-5 h-5 text-gray-400" />
                                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin.articles.article_excerpt') }}</h3>
                                                </div>
                                                <p class="text-lg font-light text-gray-700 dark:text-gray-300">
                                                    {{ $article->excerpt }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </header>

                            <!-- Article Content -->
                            <div class="prose prose-lg max-w-none dark:prose-invert mb-12">
                                {!! $article->content !!}
                            </div>

                            <!-- Gallery -->
                            @if($article->media->count() > 0)
                                <div class="mt-12">
                                    {{-- Section Header --}}
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
                                            {{ __('admin.articles.gallery') }}
                                        </h3>
                                        <div class="h-[2px] flex-1 bg-gradient-to-r from-gray-200 to-transparent dark:from-gray-700 ml-6"></div>
                                    </div>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($article->media as $index => $image)
                                            <div class="relative aspect-square overflow-hidden rounded-lg">
                                                <img 
                                                    src="{{ asset('storage/' . $image->image_path) }}" 
                                                    alt="{{ $image->alt_text ?? __('admin.articles.gallery_image') }}"
                                                    class="w-full h-full object-cover cursor-pointer gallery-image hover:opacity-90 transition-opacity duration-300"
                                                    data-index="{{ $index }}"
                                                    loading="lazy"
                                                >
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </article>
                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="sticky top-8 space-y-6">
                        <!-- Article Details Card -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                            <div class="p-6">
                                <div class="flex items-center gap-2 mb-4">
                                    <x-lucide-info class="w-5 h-5 text-gray-400" />
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('admin.articles.article_details') }}</h3>
                                </div>
                                <dl class="space-y-4 divide-y dark:divide-gray-700">
                                    <div class="text-xs pt-4 flex justify-between items-center">
                                        <dt class="font-medium text-gray-500 dark:text-gray-400">{{ __('admin.articles.author') }}</dt>
                                        <dd class="text-gray-900 dark:text-white">{{ $article->user->name ?? __('admin.common.unknown') }}</dd>
                                    </div>
                                    <div class="text-xs pt-4 flex justify-between items-center">
                                        <dt class="font-medium text-gray-500 dark:text-gray-400">{{ __('admin.status.created_at') }}</dt>
                                        <dd class="text-gray-900 dark:text-white">
                                            {{ $article->created_at ? $article->created_at->format('F d, Y H:i') : __('admin.common.not_set') }}
                                        </dd>
                                    </div>
                                    <div class="text-xs pt-4 flex justify-between items-center">
                                        <dt class="font-medium text-gray-500 dark:text-gray-400">{{ __('admin.status.updated_at') }}</dt>
                                        <dd class="text-gray-900 dark:text-white">
                                            {{ $article->updated_at ? $article->updated_at->format('F d, Y H:i') : __('admin.common.not_set') }}
                                        </dd>
                                    </div>
                                    <div class="text-xs pt-4 flex justify-between items-center">
                                        <dt class="font-medium text-gray-500 dark:text-gray-400">{{ __('admin.status.scheduled_at') }}</dt>
                                        <dd class="text-gray-900 dark:text-white">
                                            {{ $article->scheduled_at ? \Carbon\Carbon::parse($article->scheduled_at)->format('F d, Y H:i') : __('admin.common.not_set') }}
                                        </dd>
                                    </div>
                                    @if($article->meta_title || $article->meta_description)
                                        <div class="pt-4">
                                            <dt class="font-medium text-gray-500 dark:text-gray-400 mb-2">{{ __('admin.articles.seo_details') }}</dt>
                                            @if($article->meta_title)
                                                <dd class="text-gray-900 dark:text-white mb-1">
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.common.title') }}:</span> {{ $article->meta_title }}
                                                </dd>
                                            @endif
                                            @if($article->meta_description)
                                                <dd class="text-gray-900 dark:text-white">
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin.common.description') }}:</span> {{ $article->meta_description }}
                                                </dd>
                                            @endif
                                        </div>
                                    @endif
                                </dl>
                            </div>
                        </div>

                        <!-- Preview Tools Card -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                            <div class="p-6">
                                <div class="flex items-center gap-2 mb-4">
                                    <x-lucide-view class="w-5 h-5 text-gray-400" />
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('admin.articles.preview_tools') }}</h3>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('admin.articles.word_count') }}</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ str_word_count(strip_tags($article->content)) }} {{ __('admin.articles.words') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('admin.articles.reading_time') }}</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ ceil(str_word_count(strip_tags($article->content)) / 200) }} {{ __('admin.articles.minutes') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('admin.articles.images') }}</span>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $article->media->count() }} {{ __('admin.articles.images') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO Preview Card -->
                        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                            <div class="p-6">
                                <div class="flex items-center gap-2 mb-4">
                                    <x-lucide-search class="w-5 h-5 text-gray-400" />
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('admin.articles.seo_preview') }}</h3>
                                </div>
                                <div class="space-y-4">
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md">
                                        <div class="text-xs font-medium text-blue-600 dark:text-blue-400 truncate">
                                            {{ config('app.url') }}/{{ __('admin.articles.articles') }}/{{ $article->slug }}
                                        </div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $article->meta_title ?? $article->title }}
                                        </div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2">
                                            {{ $article->meta_description ?? Str::limit(strip_tags($article->excerpt ?? $article->content), 160) }}
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <!-- Gallery Modal -->
        <div id="galleryModal" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 hidden">
            <div class="relative w-full h-full max-w-4xl max-h-full p-4">
                <img id="galleryImage" src="" alt="Gallery Image" class="w-full h-full object-contain">
                <button id="prevButton" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/10 hover:bg-white/20 text-white p-2 rounded-full transition duration-200">
                    <x-lucide-chevron-left class="w-6 h-6" />
                </button>
                <button id="nextButton" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/10 hover:bg-white/20 text-white p-2 rounded-full transition duration-200">
                    <x-lucide-chevron-right class="w-6 h-6" />
                </button>
                <button id="closeButton" class="absolute top-4 right-4 bg-white/10 hover:bg-white/20 text-white p-2 rounded-full transition duration-200">
                    <x-lucide-x class="w-6 h-6" />
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const galleryModal = document.getElementById('galleryModal');
            const galleryImage = document.getElementById('galleryImage');
            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');
            const closeButton = document.getElementById('closeButton');
            const galleryImages = document.querySelectorAll('.gallery-image');
            
            let currentIndex = 0;
            const imagePaths = Array.from(galleryImages).map(img => img.src);

            function openGallery(index) {
                currentIndex = index;
                galleryImage.src = imagePaths[currentIndex];
                galleryModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeGallery() {
                galleryModal.classList.add('hidden');
                document.body.style.overflow = '';
            }

            function nextImage() {
                currentIndex = (currentIndex + 1) % imagePaths.length;
                galleryImage.src = imagePaths[currentIndex];
            }

            function prevImage() {
                currentIndex = (currentIndex - 1 + imagePaths.length) % imagePaths.length;
                galleryImage.src = imagePaths[currentIndex];
            }

            galleryImages.forEach((img, index) => {
                img.addEventListener('click', () => openGallery(index));
            });

            prevButton.addEventListener('click', prevImage);
            nextButton.addEventListener('click', nextImage);
            closeButton.addEventListener('click', closeGallery);
            galleryModal.addEventListener('click', (e) => {
                if (e.target === galleryModal) closeGallery();
            });

            document.addEventListener('keydown', (e) => {
                if (!galleryModal.classList.contains('hidden')) {
                    if (e.key === 'ArrowRight') nextImage();
                    if (e.key === 'ArrowLeft') prevImage();
                    if (e.key === 'Escape') closeGallery();
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>