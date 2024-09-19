<x-app-layout>
  <x-slot name="title">{{ $article->title }}</x-slot>

  <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="lg:flex lg:space-x-8">
        <main class="lg:w-2/3">
          <article class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <!-- Featured Image with Metadata -->
            <div class="relative mb-8">
              <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-[400px] object-cover">
              <div class="absolute bottom-6 left-6">
                <div class="flex items-center text-sm bg-black bg-opacity-75 text-white rounded-full px-4 py-2">
                  <img src="{{ $article->user->profile_photo_url }}" alt="{{ $article->user->name }}" class="w-8 h-8 rounded-full mr-3">
                  <span>{{ $article->user->name }}</span>
                  <span class="mx-2">·</span>
                  <span>Last update: {{ $article->updated_at->format('M d, Y') }}</span>
                  <span class="mx-2">·</span>
                  <span>{{ $readingTime }} min read</span>
                </div>
              </div>
            </div>

            <div class="px-6 pb-8">
              <!-- Article Header -->
              <header class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white leading-tight mb-4">
                  {{ $article->title }}
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-4 bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                  {{ $article->excerpt }}
                </p>
              </header>

              <!-- Article Content -->
              <div class="prose prose-lg max-w-none dark:prose-invert mb-12">
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

              <!-- Author Bio and Category -->
              <div class="bg-gray-100 dark:bg-gray-700 rounded-xl mt-6 p-6">
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
                    <img src="{{ $article->user->profile_photo_url }}" alt="{{ $article->user->name }}" class="w-16 h-16 rounded-full mr-4">
                    <div>
                      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $article->user->name }}</h3>
                      <p class="text-sm text-gray-600 dark:text-gray-400">Published: {{ $article->created_at->format('M d, Y') }}</p>
                      <p class="text-sm text-gray-600 dark:text-gray-400">Updated: {{ $article->created_at->format('M d, Y') }}</p>
                    </div>
                  </div>
                  <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                    {{ $article->category->name ?? 'N/A' }}
                  </div>
                </div>
              </div>
            </div>
          </article>
        </main>

        <!-- Sidebar -->
        <aside class="lg:w-1/3 mt-8 lg:mt-0">
          <div class="sticky top-8">
            <x-sidebar :popularArticles="$popularArticles" :categories="$categories" />
          </div>
        </aside>
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
</x-app-layout>