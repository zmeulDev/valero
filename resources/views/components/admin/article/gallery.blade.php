@props(['categories', 'article'])

<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden"
     x-data="{ 
         isOpen: localStorage.getItem('gallery-expanded') === 'true',
         uploading: false,
         files: [],
         handleFiles(event) {
             this.files = Array.from(event.target.files).map(file => ({
                 name: file.name,
                 size: (file.size / 1024).toFixed(1) + 'KB'
             }));
         }
     }"
     x-init="$watch('isOpen', value => localStorage.setItem('gallery-expanded', value))">
    <!-- Header -->
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center cursor-pointer"
         @click.prevent.stop="isOpen = !isOpen">
        <div class="flex items-center gap-2">
            <x-lucide-images class="w-5 h-5 text-indigo-500" />
            <div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                    Gallery Images
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                    Additional images for the article
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
        
        <div class="p-4 sm:p-6 space-y-6">
            <!-- Existing Gallery Images -->
            @if($article && $article->images->count())
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($article->images as $image)
                <div class="relative group aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900">
                    <!-- Image -->
                    <img src="{{ asset('storage/' . ($image->variants['medium'] ?? $image->image_path)) }}" 
                         alt="{{ $image->alt_text }}"
                         class="w-full h-full object-cover transition duration-300 group-hover:scale-105">

                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 opacity-0 group-hover:opacity-100 transition-all duration-300">
                        <!-- Delete Button -->
                        <div class="absolute top-2 right-2">
                            <form action="{{ route('admin.articles.images.destroy', ['article' => $article->id, 'image' => $image->id]) }}"
                                  method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Are you sure you want to delete this image?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-1.5 text-white hover:text-red-400 transition-colors bg-black/20 backdrop-blur-sm rounded-md">
                                    <x-lucide-trash-2 class="w-4 h-4" />
                                </button>
                            </form>
                        </div>

                        <!-- Image Info -->
                        <div class="absolute bottom-3 left-3 right-3">
                            <div class="px-2 py-1 text-xs font-medium text-white bg-black/20 backdrop-blur-sm rounded-md">
                                @php
                                    $filesize = $image->size ? number_format($image->size / 1024, 1) : filesize(storage_path('app/public/' . $image->image_path)) / 1024;
                                @endphp
                                @if($image->dimensions)
                                    {{ $image->dimensions['width'] }}x{{ $image->dimensions['height'] }} •
                                @endif
                                {{ number_format($filesize, 1) }}KB
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Upload Form -->
            <form action="{{ route('admin.articles.images.store', $article) }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="space-y-3"
                  x-on:submit="setTimeout(() => { uploading = false; files = []; $refs.fileInput.value = ''; }, 1000)">
                @csrf
                
                <!-- File Input Area -->
                <div class="relative">
                    <input type="file" 
                           name="images[]" 
                           multiple
                           class="hidden"
                           x-ref="fileInput"
                           @change="handleFiles($event)"
                           accept="image/*">

                    <button type="button"
                            @click="$refs.fileInput.click()"
                            class="w-full flex items-center justify-center px-4 py-3 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-500 transition-colors duration-200"
                            :class="{ 'opacity-50 cursor-not-allowed': uploading }">
                        <div class="flex flex-col items-center gap-1">
                            <x-lucide-upload-cloud class="w-6 h-6 text-gray-400 dark:text-gray-500" />
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                Click to upload or drag and drop
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                PNG, JPG, WebP up to 2MB each
                            </span>
                        </div>
                    </button>
                </div>

                <!-- Selected Files Preview -->
                <template x-if="files.length > 0">
                    <div class="mt-3 space-y-2">
                        <template x-for="file in files" :key="file.name">
                            <div class="flex items-center justify-between px-3 py-2 text-sm bg-gray-50 dark:bg-gray-900 rounded-md">
                                <span x-text="file.name" class="text-gray-700 dark:text-gray-300"></span>
                                <span x-text="file.size" class="text-gray-500 dark:text-gray-400"></span>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200"
                        :disabled="uploading || files.length === 0"
                        :class="{ 'opacity-50 cursor-not-allowed': uploading || files.length === 0 }">
                    <span class="flex items-center">
                        <x-lucide-upload class="w-4 h-4 mr-2" />
                        <span x-text="uploading ? 'Uploading...' : 'Upload Images'"></span>
                    </span>
                    <!-- Loading spinner -->
                    <svg x-show="uploading" class="animate-spin ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>