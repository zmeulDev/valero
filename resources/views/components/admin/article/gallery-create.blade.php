@props(['maxFiles' => 30, 'maxFileSizeMB' => 5])

<div class="bg-surface" x-data="galleryCreate({{ $maxFiles }}, {{ $maxFileSizeMB }})">
    <div class="space-y-4">
        <!-- Header -->
        <div class="flex items-center gap-2">
            <x-lucide-images class="w-5 h-5 text-indigo-500" />
            <div>
                <h3 class="text-base font-semibold text-text">
                    {{ __('admin.articles.gallery') }}
                </h3>
                <p class="text-sm text-muted">
                    {{ __('admin.articles.0_of_maxFiles_images_selected', ['maxFiles' => $maxFiles]) }}
                </p>
            </div>
        </div>

        <!-- Content -->
        <div class="space-y-4">
            <!-- File Input Area -->
            <div class="space-y-3">
                <!-- Upload Button -->
                <div class="relative">
                    <input type="file" name="gallery_images[]" multiple class="hidden" x-ref="fileInput"
                        @change="handleFiles($event)" accept="image/jpeg,image/png,image/gif,image/webp">

                    <button type="button" @click="$refs.fileInput.click()"
                        class="w-full flex items-center justify-center px-4 py-3 border-2 border-dashed border-border rounded-lg hover:border-indigo-500 transition-colors duration-200">
                        <div class="flex flex-col items-center gap-1">
                            <x-lucide-upload-cloud class="w-6 h-6 text-muted" />
                            <span class="text-sm font-medium text-text">
                                {{ __('admin.articles.click_to_upload_or_drag_and_drop') }}
                            </span>
                            <span class="text-xs text-muted">
                                {{ __('admin.articles.png_jpg_webp_up_to_maxFileSizeMB_each', ['maxFileSizeMB' => $maxFileSizeMB]) }}
                            </span>
                            <span class="text-xs text-muted">
                                {{ __('admin.articles.max_dimensions') }}
                            </span>
                            <span class="text-xs text-muted">
                                {{ __('admin.articles.slots_available') }}
                            </span>
                        </div>
                    </button>
                </div>

                <!-- Divider -->
                <div class="relative flex items-center">
                    <div class="flex-grow border-t border-border"></div>
                    <span class="flex-shrink mx-4 text-sm text-muted">{{ __('admin.articles.or') }}</span>
                    <div class="flex-grow border-t border-border"></div>
                </div>

                <!-- Media Library Button -->
                <button type="button" @click="$dispatch('open-media-library')"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 border-2 border-border rounded-lg hover:border-indigo-500 hover:bg-background transition-colors duration-200">
                    <x-lucide-images class="w-5 h-5 text-muted" />
                    <span class="text-sm font-medium text-text">
                        {{ __('admin.articles.select_from_media_library') }}
                    </span>
                </button>
            </div>

            <!-- Selected Files Preview -->
            <template x-if="files.length > 0">
                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-medium text-text">
                            {{ __('admin.articles.selected') }} <span x-text="files.length"></span>
                            {{ __('admin.articles.file') }}
                        </div>
                        <button type="button" @click="clearAllFiles()"
                            class="text-xs text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium">
                            Clear all
                        </button>
                    </div>
                    <div class="space-y-3">
                        <template x-for="(file, index) in files" :key="file.name">
                            <div
                                class="group relative flex items-center gap-4 p-3 bg-background rounded-lg hover:bg-surface transition-colors border border-border">
                                <!-- Image Preview -->
                                <div class="flex-shrink-0 relative">
                                    <img :src="file.previewUrl" :alt="file.name"
                                        class="w-64 h-64 object-cover rounded-lg border-2 border-border shadow-md">

                                    <!-- Delete Button Overlay -->
                                    <button type="button" @click="removeFile(index)"
                                        class="absolute -top-2 -right-2 p-2 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-lg transition-all duration-200 hover:scale-110"
                                        title="Remove this image">
                                        <x-lucide-x class="w-4 h-4" />
                                    </button>
                                </div>

                                <!-- File Info -->
                                <div class="flex-1 min-w-0 space-y-2">
                                    <div class="flex items-center gap-2">
                                        <span x-text="file.name"
                                            class="text-base font-semibold text-text truncate"></span>
                                    </div>

                                    <div class="flex flex-wrap items-center gap-4 text-sm text-text">
                                        <span class="flex items-center gap-1.5">
                                            <x-lucide-file class="w-4 h-4 text-muted" />
                                            <span x-text="file.sizeFormatted" class="font-medium"></span>
                                        </span>
                                        <span x-show="file.dimensionsText" class="flex items-center gap-1.5">
                                            <x-lucide-ruler class="w-4 h-4 text-muted" />
                                            <span x-text="file.dimensionsText" class="font-medium"></span>
                                        </span>
                                    </div>

                                    <!-- Validation Status -->
                                    <div class="flex items-center gap-2">
                                        <div x-show="file.sizeMB > {{ $maxFileSizeMB }}"
                                            class="flex items-center gap-2 text-red-600 dark:text-red-400 text-sm">
                                            <x-lucide-alert-circle class="w-4 h-4" />
                                            <span>File exceeds {{ $maxFileSizeMB }}MB limit</span>
                                        </div>
                                        <div x-show="file.dimensionsText && (file.width > 5120 || file.height > 5120)"
                                            class="flex items-center gap-2 text-red-600 dark:text-red-400 text-sm">
                                            <x-lucide-alert-circle class="w-4 h-4" />
                                            <span>Dimensions exceed 5120px limit</span>
                                        </div>
                                        <div x-show="(!file.sizeMB || file.sizeMB <= {{ $maxFileSizeMB }}) && (!file.width || (file.width <= 5120 && file.height <= 5120))"
                                            class="flex items-center gap-2 text-green-600 dark:text-green-400 text-sm">
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
        </div>
    </div>
</div>

<!-- Media Library Modal -->
<x-admin.article.media-library-modal />