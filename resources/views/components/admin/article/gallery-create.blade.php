<div class="bg-white dark:bg-gray-800"
     x-data="galleryCreate()">
    <div class="space-y-4">
        <!-- Header -->
        <div class="flex items-center gap-2">
            <x-lucide-images class="w-5 h-5 text-indigo-500" />
            <div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                    Gallery Images
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    0 of 12 images selected
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
                            Click to upload or drag and drop
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            PNG, JPG, WebP up to 2MB each (12 slots available)
                        </span>
                    </div>
                </button>
            </div>

            <!-- Selected Files Preview -->
            <template x-if="files.length > 0">
                <div class="mt-3 space-y-2">
                    <div class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                        Selected <span x-text="files.length"></span> file(s)
                    </div>
                    <template x-for="file in files" :key="file.name">
                        <div class="flex items-center justify-between px-3 py-2 text-sm bg-gray-50 dark:bg-gray-900 rounded-md">
                            <span x-text="file.name" class="text-gray-700 dark:text-gray-300"></span>
                            <span x-text="file.size" class="text-gray-500 dark:text-gray-400"></span>
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
        maxFiles: 12,
        handleFiles(event) {
            const selectedFiles = Array.from(event.target.files);
            if (selectedFiles.length > this.maxFiles) {
                alert(`You can only upload up to ${this.maxFiles} images at once.`);
                event.target.value = '';
                return;
            }
            
            this.files = selectedFiles.map(file => ({
                name: file.name,
                size: (file.size / 1024).toFixed(1) + 'KB'
            }));
        }
    };
}
</script>