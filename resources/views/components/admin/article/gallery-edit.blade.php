@props(['article'])

@if($article && $article->exists)
    <div class="bg-white dark:bg-gray-800"
         x-data="galleryEdit()">
        <div class="space-y-4">
            <!-- Header -->
            <div class="flex items-center gap-2">
                <x-lucide-images class="w-5 h-5 text-indigo-500" />
                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        {{ __('admin.articles.gallery') }}
                    </h3>
                    <p id="gallery-count" class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $article->media->count() }} {{ __('admin.articles.of_20_images_used') }}
                    </p>
                </div>
            </div>

            <!-- Content -->
            <div class="space-y-4">
                <!-- Existing Gallery Images -->
                @if($article->media->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-2">
                        @foreach($article->media as $image)
                            <div class="relative group aspect-w-16 aspect-h-9 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900 
                                {{ $image->is_cover ? 'ring-2 ring-yellow-500' : '' }}">
                                <!-- Cover Badge -->
                                @if($image->is_cover)
                                    <div class="absolute top-2 left-2 z-10">
                                        <div class="px-2 py-1 bg-yellow-500 rounded-md flex items-center gap-1">
                                            <x-lucide-star class="w-4 h-4 text-white" />
                                            <span class="text-xs font-medium text-white">{{ __('admin.articles.cover') }}</span>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Image -->
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     alt="{{ $image->alt_text }}"
                                     class="w-full h-full object-cover transition duration-300 group-hover:scale-105">

                                <!-- Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <!-- Cover and Delete Buttons -->
                                    <div class="absolute top-2 right-2 flex space-x-2">
                                        <!-- Set Cover Button -->
                                        @if(!$image->is_cover)
                                            <form action="{{ route('admin.articles.images.set-cover', ['article' => $article, 'media' => $image]) }}"
                                                  method="POST"
                                                  class="inline-block">
                                                @csrf
                                                <button type="submit" 
                                                        class="p-1.5 text-white hover:text-yellow-400 transition-colors bg-black/20 backdrop-blur-sm rounded-md"
                                                        title="Set as cover image">
                                                    <x-lucide-star class="w-4 h-4" />
                                                </button>
                                            </form>
                                        @else
                                            <div class="p-1.5 text-yellow-400 bg-black/20 backdrop-blur-sm rounded-md"
                                                 title="Current cover image">
                                                <x-lucide-star class="w-4 h-4" />
                                            </div>
                                        @endif

                                        @if(!$image->is_cover)
                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.articles.images.destroy', ['article' => $article->id, 'media' => $image->id]) }}"
                                              method="POST"
                                              class="inline-block"
                                              @submit.prevent="deleteImage($event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-1.5 text-white hover:text-red-400 transition-colors bg-black/20 backdrop-blur-sm rounded-md"
                                                    title="Delete image">
                                                <x-lucide-trash-2 class="w-4 h-4" />
                                            </button>
                                        </form>
                                        @endif
                                    </div>

                                    <!-- Image Info -->
                                    <div class="absolute bottom-3 left-3 right-3">
                                        <div class="px-2 py-1 text-xs font-medium text-white bg-black/20 backdrop-blur-sm rounded-md">
                                            @if($image->dimensions)
                                                {{ $image->dimensions['width'] }}x{{ $image->dimensions['height'] }} •
                                            @endif
                                            {{ number_format($image->size / 1024, 1) }}KB
                                            @if($image->is_cover)
                                                • {{ __('admin.articles.cover_image') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Upload Form -->
                @if($article->media->count() < 20)
                    <form action="{{ route('admin.articles.images.store', $article) }}"
                          method="POST" 
                          enctype="multipart/form-data"
                          class="space-y-2"
                          @submit.prevent="uploadImages"
                          data-set-cover-route="{{ route('admin.articles.images.set-cover', ['article' => $article, 'media' => '__id__']) }}"
                          data-delete-route="{{ route('admin.articles.images.destroy', ['article' => $article->id, 'media' => '__id__']) }}">
                        @csrf
                        
                        <!-- File Input Area -->
                        <div class="relative">
                            <input type="file" 
                                   name="gallery_images[]" 
                                   multiple
                                   class="hidden"
                                   x-ref="fileInput"
                                   @change="handleFiles($event)"
                                   accept="image/jpeg,image/png,image/gif,image/webp">

                            <button type="button"
                                    @click="$refs.fileInput.click()"
                                    class="w-full flex items-center justify-center px-4 py-3 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-500 transition-colors duration-200"
                                    :class="{ 'opacity-50 cursor-not-allowed': uploading }">
                                <div class="flex flex-col items-center gap-1">
                                    <x-lucide-upload-cloud class="w-6 h-6 text-gray-400 dark:text-gray-500" />
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                        {{ __('admin.articles.click_to_upload_or_drag_and_drop') }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ __('admin.articles.png_jpg_webp_up_to_5mb_each') }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ __('admin.articles.max_dimensions') }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ 20 - $article->media->count() }} {{ __('admin.articles.slots_remaining') }}
                                    </span>
                                </div>
                            </button>
                        </div>

                        <!-- Selected Files Preview -->
                        <template x-if="files.length > 0">
                            <div class="mt-3 space-y-2">
                                <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                    {{ __('admin.articles.selected') }} <span x-text="files.length"></span> {{ __('admin.articles.file') }}
                                </div>
                                <template x-for="file in files" :key="file.name">
                                    <div class="flex items-center justify-between px-3 py-2 text-sm bg-gray-50 dark:bg-gray-900 rounded-md">
                                        <div class="flex flex-col">
                                            <span x-text="file.name" class="text-gray-700 dark:text-gray-300"></span>
                                            <span x-text="file.size" class="text-xs text-gray-500 dark:text-gray-400"></span>
                                            <span x-text="file.dimensions" class="text-xs text-gray-500 dark:text-gray-400"></span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span x-show="file.size > 5" class="text-red-500">
                                                <x-lucide-alert-circle class="w-4 h-4" />
                                            </span>
                                            <span x-show="file.dimensions && (file.width > 3840 || file.height > 2160)" class="text-red-500">
                                                <x-lucide-alert-circle class="w-4 h-4" />
                                            </span>
                                        </div>
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
                @else
                    <div class="text-center py-3 text-gray-500 dark:text-gray-400">
                        {{ __('admin.articles.maximum_number_of_images') }} (20)
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

<script>
function galleryEdit() {
    return {
        uploading: false,
        files: [],
        maxFiles: {{ 20 - ($article->media->count()) }},
        article_title: "{{ $article->title }}",

        getRoutes() {
            const form = document.querySelector('form[data-set-cover-route]');
            return {
                setCoverRoute: form.dataset.setCoverRoute,
                deleteRoute: form.dataset.deleteRoute
            };
        },

        handleFiles(event) {
            const selectedFiles = Array.from(event.target.files);
            const remainingSlots = this.maxFiles;
            
            if (selectedFiles.length > remainingSlots) {
                alert(`You can only upload ${remainingSlots} more images. (Maximum total: 20)`);
                event.target.value = '';
                return;
            }

            // Check file sizes and dimensions
            const maxFileSize = 5 * 1024 * 1024; // 5MB
            const maxWidth = 3840;
            const maxHeight = 2160;
            
            for (const file of selectedFiles) {
                if (file.size > maxFileSize) {
                    alert(`File "${file.name}" is too large. Maximum file size is 5MB.`);
                    event.target.value = '';
                    return;
                }

                // Create a promise to check image dimensions
                const checkDimensions = new Promise((resolve, reject) => {
                    const img = new Image();
                    img.onload = () => {
                        if (img.width > maxWidth || img.height > maxHeight) {
                            reject(`File "${file.name}" dimensions (${img.width}x${img.height}) exceed the maximum allowed size of ${maxWidth}x${maxHeight} pixels.`);
                        } else {
                            resolve();
                        }
                    };
                    img.onerror = () => reject(`Failed to load image "${file.name}" for dimension check.`);
                    img.src = URL.createObjectURL(file);
                });

                // Wait for dimension check
                checkDimensions.catch(error => {
                    alert(error);
                    event.target.value = '';
                    return;
                });
            }
            
            this.files = selectedFiles.map(file => ({
                name: file.name,
                size: (file.size / 1024).toFixed(1) + 'MB',
                dimensions: new Promise((resolve) => {
                    const img = new Image();
                    img.onload = () => {
                        resolve({
                            text: `${img.width}x${img.height} pixels`,
                            width: img.width,
                            height: img.height
                        });
                    };
                    img.src = URL.createObjectURL(file);
                })
            }));
        },

        uploadImages(event) {
            if (this.files.length === 0) return;
            
            this.uploading = true;
            const formData = new FormData(event.target);
            const routes = this.getRoutes();
            
            fetch(event.target.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Get the gallery container
                    const galleryContainer = document.querySelector('.grid');
                    
                    // For each uploaded image, create and append a new gallery item
                    data.images.forEach(image => {
                        const newImageHtml = `
                            <div class="relative group aspect-w-16 aspect-h-9 rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900">
                                <img src="${image.url}" 
                                     alt="${this.article_title}"
                                     class="w-full h-full object-cover transition duration-300 group-hover:scale-105">

                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <div class="absolute top-2 right-2 flex space-x-2">
                                        <form action="${routes.setCoverRoute.replace('__id__', image.id)}"
                                              method="POST"
                                              class="inline-block">
                                            @csrf
                                            <button type="submit" 
                                                    class="p-1.5 text-white hover:text-yellow-400 transition-colors bg-black/20 backdrop-blur-sm rounded-md"
                                                    title="Set as cover image">
                                                <x-lucide-star class="w-4 h-4" />
                                            </button>
                                        </form>

                                        <form action="${routes.deleteRoute.replace('__id__', image.id)}"
                                              method="POST"
                                              class="inline-block"
                                              @submit.prevent="deleteImage($event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-1.5 text-white hover:text-red-400 transition-colors bg-black/20 backdrop-blur-sm rounded-md"
                                                    title="Delete image">
                                                <x-lucide-trash-2 class="w-4 h-4" />
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        // Create a temporary container and set its HTML
                        const temp = document.createElement('div');
                        temp.innerHTML = newImageHtml;
                        
                        // Append the new image to the gallery
                        galleryContainer.appendChild(temp.firstElementChild);
                    });

                    // Update the image count
                    const countElement = document.getElementById('gallery-count');
                    const currentCount = parseInt(countElement.textContent);
                    const newCount = currentCount + data.images.length;
                    countElement.textContent = `${newCount} of 20 images used`;

                    // Show success notification
                    const notification = document.createElement('div');
                    notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                    notification.textContent = data.message;
                    document.body.appendChild(notification);
                    setTimeout(() => notification.remove(), 3000);

                    // Reset the form
                    this.files = [];
                    this.$refs.fileInput.value = '';
                } else {
                    throw new Error(data.message || 'Upload failed');
                }
            })
            .catch(error => {
                console.error('Upload error:', error);
                // Show error notification
                const notification = document.createElement('div');
                notification.className = 'fixed bottom-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                notification.textContent = error.message || 'An unexpected error occurred';
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 3000);
            })
            .finally(() => {
                this.uploading = false;
            });
        },

        deleteImage(event) {
            if (!confirm('Are you sure you want to delete this image?')) {
                return;
            }

            const form = event.target;
            const token = form.querySelector('input[name="_token"]').value;
            const imageContainer = form.closest('.relative.group');

            fetch(form.action, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                const data = await response.json();
                if (!response.ok) {
                    throw new Error(data.message || 'Failed to delete image');
                }
                return data;
            })
            .then(data => {
                if (data.success) {
                    // Remove the image container from DOM
                    imageContainer.remove();
                    
                    // Update the image count text using the ID
                    const countElement = document.getElementById('gallery-count');
                    if (countElement) {
                        countElement.textContent = `${data.remainingImages} of 20 images used`;
                    }
                    
                    // Show success notification
                    const notification = document.createElement('div');
                    notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                    notification.textContent = data.message;
                    document.body.appendChild(notification);
                    setTimeout(() => notification.remove(), 3000);
                }
            })
            .catch(error => {
                console.error('Delete error:', error);
                // Show error notification
                const notification = document.createElement('div');
                notification.className = 'fixed bottom-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                notification.textContent = error.message || 'An error occurred while deleting the image';
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 3000);
            });
        }
    };
}
</script>