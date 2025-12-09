<div class="bg-white dark:bg-gray-800"
     x-data="galleryCreate()">
    <div class="space-y-4">
        <!-- Header -->
        <div class="flex items-center gap-2">
            <x-lucide-images class="w-5 h-5 text-indigo-500" />
            <div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                    {{ __('admin.articles.gallery') }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ __('admin.articles.0_of_20_images_selected') }}
                </p>
            </div>
        </div>

        <!-- Content -->
        <div class="space-y-4">
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
                        class="w-full flex items-center justify-center px-4 py-3 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-500 transition-colors duration-200">
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
                            {{ __('admin.articles.slots_available') }}
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
                                <span x-text="file.name" class="text-gray-700 dark:text-gray-300 font-medium"></span>
                                <span x-text="file.sizeFormatted" class="text-xs text-gray-500 dark:text-gray-400"></span>
                                <span x-show="file.dimensionsText" x-text="file.dimensionsText" class="text-xs text-gray-500 dark:text-gray-400"></span>
                                <span x-show="!file.dimensionsText" class="text-xs text-gray-400 dark:text-gray-500">Loading dimensions...</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span x-show="file.sizeMB > 5" class="text-red-500" title="File exceeds 5MB limit">
                                    <x-lucide-alert-circle class="w-4 h-4" />
                                </span>
                                <span x-show="file.dimensionsText && (file.width > 5120 || file.height > 5120)" class="text-red-500" title="Dimensions exceed maximum allowed (max 5120 in either dimension)">
                                    <x-lucide-alert-circle class="w-4 h-4" />
                                </span>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
function galleryCreate() {
    return {
        files: [],
        maxFiles: 20,
        handleFiles(event) {
            const selectedFiles = Array.from(event.target.files);
            if (selectedFiles.length > this.maxFiles) {
                alert(`You can only upload up to ${this.maxFiles} images at once.`);
                event.target.value = '';
                return;
            }

            // Check file sizes and dimensions - allow up to 5120 in either dimension
            const maxFileSize = 5 * 1024 * 1024; // 5MB
            const maxWidth = 5120;
            const maxHeight = 5120;
            
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
                            reject(`File "${file.name}" dimensions (${img.width}x${img.height}) exceed the maximum allowed size of ${maxWidth}x${maxHeight} pixels (max 5120 in either dimension).`);
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
            
            this.files = selectedFiles.map(file => {
                const fileObj = {
                    name: file.name,
                    size: file.size,
                    sizeMB: (file.size / (1024 * 1024)).toFixed(2),
                    sizeFormatted: '',
                    dimensionsText: null,
                    width: null,
                    height: null
                };
                
                // Format file size
                if (fileObj.sizeMB < 1) {
                    fileObj.sizeFormatted = (file.size / 1024).toFixed(1) + ' KB';
                } else {
                    fileObj.sizeFormatted = fileObj.sizeMB + ' MB';
                }
                
                // Load dimensions asynchronously
                const img = new Image();
                img.onload = () => {
                    fileObj.dimensionsText = `${img.width}x${img.height} pixels`;
                    fileObj.width = img.width;
                    fileObj.height = img.height;
                };
                img.onerror = () => {
                    fileObj.dimensionsText = 'Unable to load dimensions';
                };
                img.src = URL.createObjectURL(file);
                
                return fileObj;
            });
        }
    };
}
</script>