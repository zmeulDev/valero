<x-admin-layout>
    <x-slot name="title">Preview: {{ $article->title }}</x-slot>

    <div class="bg-gray-100 min-h-screen py-12">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Preview: {{ $article->title }}</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Category: {{ $article->category->name ?? 'Uncategorized' }} | 
                    Published: {{ $article->created_at ? $article->created_at->format('F d, Y') : 'Not published' }} | 
                    Author: {{ $article->user->name ?? 'Unknown' }}
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content (2 columns on large screens) -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <!-- Featured Image -->
                        @if($article->featured_image)
                            <div class="relative h-96 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $article->featured_image) }}');">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-6">
                                    <h2 class="text-3xl font-bold text-white">{{ $article->title }}</h2>
                                </div>
                            </div>
                        @endif

                        <div class="p-6">
                            <!-- Excerpt -->
                            @if($article->excerpt)
                                <div class="bg-gray-100 p-4 rounded-lg mb-6">
                                    <p class="text-lg font-light text-gray-700">
                                        {{ $article->excerpt }}
                                    </p>
                                </div>
                            @endif

                            <!-- Content -->
                            <div class="prose max-w-none">
                                {!! $article->content !!}
                            </div>

                            <!-- Gallery -->
                            @if($article->images->count() > 0)
                                <div class="mt-12">
                                    <h3 class="text-2xl font-bold mb-4">Gallery</h3>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($article->images as $index => $image)
                                            <div class="relative aspect-w-1 aspect-h-1">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                     alt="Gallery Image" 
                                                     class="object-cover rounded-lg cursor-pointer gallery-image"
                                                     data-index="{{ $index }}">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-4">Article Details</h3>
                            <ul class="space-y-2">
                                <li><strong>Status:</strong> 
                                    @php
                                        $status = 'Published';
                                        if ($article->scheduled_at && \Carbon\Carbon::parse($article->scheduled_at)->isFuture()) {
                                            $status = 'Not Published';
                                        }
                                    @endphp
                                    {{ $status }}
                                </li>
                                <li><strong>Scheduled At:</strong> {{ $article->scheduled_at ? \Carbon\Carbon::parse($article->scheduled_at)->format('F d, Y H:i') : 'Not scheduled' }}</li>
                                <li><strong>Read Time:</strong> {{ $article->read_time ?? 'Unknown' }} min</li>
                                <li><strong>Created At:</strong> {{ $article->created_at ? $article->created_at->format('F d, Y H:i') : 'Unknown' }}</li>
                                <li><strong>Updated At:</strong> {{ $article->updated_at ? $article->updated_at->format('F d, Y H:i') : 'Unknown' }}</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6 space-y-4">
                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center">
                                Edit Article
                            </a>
                            <a href="{{ route('admin.articles.index') }}" class="block w-full bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded text-center">
                                Back to All Articles
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full-size Gallery Modal -->
        <div id="galleryModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 hidden">
            <div class="relative w-full h-full max-w-4xl max-h-full p-4">
                <img id="galleryImage" src="" alt="Gallery Image" class="w-full h-full object-contain">
                <button id="prevButton" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="nextButton" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
                <button id="closeButton" class="absolute top-4 right-4 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

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
            }

            function closeGallery() {
                galleryModal.classList.add('hidden');
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
</x-admin-layout>