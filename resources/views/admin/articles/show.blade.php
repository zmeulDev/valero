<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header
            icon="book-open"
            title="{{ __('Article Preview') }}"
            description="Preview and manage article details"
            :breadcrumbs="[
                ['label' => 'Articles', 'url' => route('admin.articles.index')],
                ['label' => 'Preview']
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('admin.articles.edit', $article->id) }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <x-lucide-pencil class="w-4 h-4 mr-2" />
                    Edit Article
                </a>
                <a href="{{ route('admin.articles.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                    Back to Articles
                </a>
            </x-slot:actions>
        </x-admin.page-header>
    </x-slot>

    <div class="min-h-screen dark:bg-gray-900">
        <div class="container mx-auto px-4 py-8">
            <!-- Enhanced Header Section -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $article->title }}</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Featured Image Card -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                        @if($article->featured_image)
                            <div class="relative aspect-video">
                                <img src="{{ asset('storage/' . $article->featured_image) }}"
                                     alt="{{ $article->title }}"
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent">
                                    <div class="absolute bottom-0 left-0 right-0 p-6">
                                        <p class="text-sm text-white/80 mb-2">Featured Image</p>
                                        <h2 class="text-2xl font-bold text-white">{{ $article->title }}</h2>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="p-6">
                            <!-- Enhanced Excerpt -->
                            @if($article->excerpt)
                                <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg mb-6 border border-gray-100 dark:border-gray-600">
                                    <div class="flex items-center gap-2 mb-2">
                                        <x-lucide-quote class="w-5 h-5 text-gray-400" />
                                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Article Excerpt</h3>
                                    </div>
                                    <p class="text-lg font-light text-gray-700 dark:text-gray-300">
                                        {{ $article->excerpt }}
                                    </p>
                                </div>
                            @endif

                            <!-- Enhanced Content -->
                            <div class="prose dark:prose-invert max-w-none">
                                {!! $article->content !!}
                            </div>

                            <!-- Enhanced Gallery -->
                            @if($article->images->count() > 0)
                                <div class="mt-12 border-t dark:border-gray-700 pt-8">
                                    <div class="flex items-center gap-2 mb-4">
                                        <x-lucide-image class="w-5 h-5 text-gray-400" />
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Image Gallery</h3>
                                    </div>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($article->images as $index => $image)
                                            <div class="relative aspect-square group rounded-lg overflow-hidden">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                     alt="Gallery Image" 
                                                     class="w-full h-full object-cover transition duration-300 group-hover:scale-105 gallery-image"
                                                     data-index="{{ $index }}">
                                                <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                                    <x-lucide-maximize-2 class="w-8 h-8 text-white drop-shadow-lg transform scale-75 group-hover:scale-100 transition-transform duration-300" />
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Enhanced Sidebar -->
                <div class="space-y-6">
                    <!-- Article Details Card -->
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-4">
                                <x-lucide-info class="w-5 h-5 text-gray-400" />
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Article Details</h3>
                            </div>
                            <dl class="space-y-4 divide-y dark:divide-gray-700">
                                
                                <div class="pt-4 flex justify-between items-center">
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Author</dt>
                                    <dd class="text-gray-900 dark:text-white">{{ $article->user->name ?? 'Unknown' }}</dd>
                                </div>
                                <div class="pt-4 flex justify-between items-center">
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Created At</dt>
                                    <dd class="text-gray-900 dark:text-white">
                                        {{ $article->created_at ? $article->created_at->format('F d, Y H:i') : 'Not set' }}
                                    </dd>
                                </div>
                                <div class="pt-4 flex justify-between items-center">
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Updated At</dt>
                                    <dd class="text-gray-900 dark:text-white">
                                        {{ $article->updated_at ? $article->updated_at->format('F d, Y H:i') : 'Not set' }}
                                    </dd>
                                </div>
                                <div class="pt-4 flex justify-between items-center">
                                    <dt class="font-medium text-gray-500 dark:text-gray-400">Scheduled For</dt>
                                    <dd class="text-gray-900 dark:text-white">
                                        {{ $article->scheduled_at ? \Carbon\Carbon::parse($article->scheduled_at)->format('F d, Y H:i') : 'Not set' }}
                                    </dd>
                                </div>
                                @if($article->meta_title || $article->meta_description)
                                    <div class="pt-4">
                                        <dt class="font-medium text-gray-500 dark:text-gray-400 mb-2">SEO Details</dt>
                                        @if($article->meta_title)
                                            <dd class="text-gray-900 dark:text-white mb-1">
                                                <span class="text-sm text-gray-500 dark:text-gray-400">Title:</span> {{ $article->meta_title }}
                                            </dd>
                                        @endif
                                        @if($article->meta_description)
                                            <dd class="text-gray-900 dark:text-white">
                                                <span class="text-sm text-gray-500 dark:text-gray-400">Description:</span> {{ $article->meta_description }}
                                            </dd>
                                        @endif
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gallery Modal -->
        <div id="galleryModal" 
             class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 hidden"
             x-data="{ show: false }"
             x-show="show"
             x-cloak>
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