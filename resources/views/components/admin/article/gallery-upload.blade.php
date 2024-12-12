<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden"
     x-data="{ 
         isOpen: localStorage.getItem('gallery-upload-expanded') === 'true',
         files: [],
         handleFiles(event) {
             this.files = Array.from(event.target.files).map(file => ({
                 name: file.name,
                 size: (file.size / 1024).toFixed(1) + 'KB'
             }));
         }
     }"
     x-init="$watch('isOpen', value => localStorage.setItem('gallery-upload-expanded', value))">
    
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
                    Add multiple images to your article
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
            <!-- File Input Area -->
            <div class="relative">
                <input type="file" 
                       name="gallery_images[]" 
                       multiple
                       class="hidden"
                       x-ref="fileInput"
                       @change="handleFiles($event)"
                       accept="image/*">

                <button type="button"
                        @click="$refs.fileInput.click()"
                        class="w-full flex items-center justify-center px-4 py-3 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg hover:border-indigo-500 dark:hover:border-indigo-500 transition-colors duration-200">
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

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Additional images can be added after creating the article
            </p>
        </div>
    </div>
</div>