@props(['article', 'maxFiles' => 30, 'maxFileSizeMB' => 5])

@if($article && $article->exists)
    <div class="bg-white dark:bg-gray-800"
         x-data="galleryEdit({{ $maxFiles }}, {{ $maxFileSizeMB }}, {{ $article->media->count() }}, '{{ addslashes($article->title) }}')">
        
        <!-- Delete Confirmation Modal -->
        <div x-show="showDeleteModal"
             x-cloak
             class="fixed inset-0 z-50 overflow-y-auto"
             aria-labelledby="modal-title"
             role="dialog"
             aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div x-show="showDeleteModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                     @click="showDeleteModal = false"
                     aria-hidden="true"></div>

                <!-- Center modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="showDeleteModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/50 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                    Delete Image
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Are you sure you want to delete this image? This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button"
                                @click="confirmDelete()"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Delete
                        </button>
                        <button type="button"
                                @click="showDeleteModal = false"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <!-- Header -->
            <div class="flex items-center gap-2">
                <x-lucide-images class="w-5 h-5 text-indigo-500" />
                <div>
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        {{ __('admin.articles.gallery') }}
                    </h3>
                    <p id="gallery-count" class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $article->media->count() }} {{ __('admin.articles.of_maxFiles_images_used', ['maxFiles' => $maxFiles]) }}
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
                        <div class="space-y-3">
                            <!-- Upload Button -->
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
                                            {{ __('admin.articles.png_jpg_webp_up_to_maxFileSizeMB_each', ['maxFileSizeMB' => $maxFileSizeMB]) }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ __('admin.articles.max_dimensions') }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $maxFiles - $article->media->count() }} {{ __('admin.articles.slots_remaining') }}
                                        </span>
                                    </div>
                                </button>
                            </div>

                            <!-- Divider -->
                            <div class="relative flex items-center">
                                <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
                                <span class="flex-shrink mx-4 text-sm text-gray-500 dark:text-gray-400">{{ __('admin.articles.or') }}</span>
                                <div class="flex-grow border-t border-gray-300 dark:border-gray-600"></div>
                            </div>

                            <!-- Media Library Button -->
                            <button type="button"
                                    @click="$dispatch('open-media-library')"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-500 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors duration-200">
                                <x-lucide-images class="w-5 h-5 text-gray-500 dark:text-gray-400" />
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    {{ __('admin.articles.select_from_media_library') }}
                                </span>
                            </button>
                        </div>

                        <!-- Selected Files Preview -->
                        <template x-if="files.length > 0">
                            <div class="mt-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ __('admin.articles.selected') }} <span x-text="files.length"></span> {{ __('admin.articles.file') }}
                                    </div>
                                    <button type="button" 
                                            @click="clearAllFiles()"
                                            class="text-xs text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                        Clear all
                                    </button>
                                </div>
                                <div class="space-y-3">
                                <template x-for="(file, index) in files" :key="file.name">
                                    <div class="group relative flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-900 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors border border-gray-200 dark:border-gray-700">
                                        <!-- Image Preview -->
                                        <div class="flex-shrink-0 relative">
                                            <img :src="file.previewUrl" 
                                                 :alt="file.name"
                                                 class="w-64 h-64 object-cover rounded-lg border-2 border-gray-300 dark:border-gray-600 shadow-md">
                                            
                                            <!-- Delete Button Overlay -->
                                            <button type="button"
                                                    @click="removeFile(index)"
                                                    class="absolute -top-2 -right-2 p-2 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-lg transition-all duration-200 hover:scale-110"
                                                    title="Remove this image">
                                                <x-lucide-x class="w-4 h-4" />
                                            </button>
                                        </div>
                                        
                                        <!-- File Info -->
                                        <div class="flex-1 min-w-0 space-y-2">
                                            <div class="flex items-center gap-2">
                                                <span x-text="file.name" class="text-base font-semibold text-gray-900 dark:text-gray-100 truncate"></span>
                                            </div>
                                            
                                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 dark:text-gray-300">
                                                <span class="flex items-center gap-1.5">
                                                    <x-lucide-file class="w-4 h-4 text-gray-400" />
                                                    <span x-text="file.sizeFormatted" class="font-medium"></span>
                                                </span>
                                                <span x-show="file.dimensionsText" class="flex items-center gap-1.5">
                                                    <x-lucide-ruler class="w-4 h-4 text-gray-400" />
                                                    <span x-text="file.dimensionsText" class="font-medium"></span>
                                                </span>
                                            </div>
                                            
                                            <!-- Validation Status -->
                                            <div class="flex items-center gap-2">
                                                <div x-show="file.sizeMB > {{ $maxFileSizeMB }}" class="flex items-center gap-2 text-red-600 dark:text-red-400 text-sm">
                                                    <x-lucide-alert-circle class="w-4 h-4" />
                                                    <span>File exceeds {{ $maxFileSizeMB }}MB limit</span>
                                                </div>
                                                <div x-show="file.dimensionsText && (file.width > 5120 || file.height > 5120)" class="flex items-center gap-2 text-red-600 dark:text-red-400 text-sm">
                                                    <x-lucide-alert-circle class="w-4 h-4" />
                                                    <span>Dimensions exceed 5120px limit</span>
                                                </div>
                                                <div x-show="(!file.sizeMB || file.sizeMB <= {{ $maxFileSizeMB }}) && (!file.width || (file.width <= 5120 && file.height <= 5120))" class="flex items-center gap-2 text-green-600 dark:text-green-400 text-sm">
                                                    <x-lucide-check-circle class="w-4 h-4" />
                                                    <span>Valid image</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                </div>
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
                        {{ __('admin.articles.maximum_number_of_images') }} ({{ $maxFiles }})
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Media Library Modal -->
    <x-admin.article.media-library-modal :article="$article" />
@endif