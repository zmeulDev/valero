@props(['categories', 'article'])

<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden"
     x-data="{ 
         isOpen: localStorage.getItem('featured-image-expanded') === 'true',
         ...initFeaturedImage()
     }"
     x-init="$watch('isOpen', value => localStorage.setItem('featured-image-expanded', value))">
    <!-- Header -->
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center cursor-pointer"
         @click.prevent.stop="isOpen = !isOpen">
        <div class="flex items-center gap-2">
            <x-lucide-image class="w-5 h-5 text-indigo-500" />
            <div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                    Featured Image
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-400">
                    Main image for article preview and social sharing
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
        
        <div class="p-4 sm:p-6 space-y-4">
            <!-- Image Preview -->
            <div class="relative group">
                <div class="aspect-[1200/630] rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900">
                    <img 
                        :src="previewUrl || '{{ $article && $article->featured_image ? asset('storage/' . $article->featured_image) : asset('storage/brand/no-image.jpg') }}'"
                        :alt="'{{ $article ? $article->title . ' featured image' : 'Featured image placeholder' }}'"
                        class="w-full h-full object-cover transition duration-300 group-hover:scale-105"
                    >
                </div>

                <!-- Overlay -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 opacity-0 group-hover:opacity-100 transition-all duration-300 rounded-lg">
                    <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between">
                        <!-- Image Info -->
                        <div class="px-2 py-1 text-xs font-medium text-white bg-black/20 backdrop-blur-sm rounded-md">
                            <span x-text="imageInfo"></span>
                        </div>
                        
                        <!-- Preview Button -->
                        <button x-show="hasImage"
                                @click="showPreview"
                                class="p-1.5 text-white hover:text-indigo-400 transition-colors bg-black/20 backdrop-blur-sm rounded-md">
                            <x-lucide-maximize-2 class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            @if($article)
                <form action="{{ route('admin.articles.featured-image.update', $article) }}"  
                      method="POST" 
                      enctype="multipart/form-data"
                      class="space-y-3">
                    @csrf
                    
                    <!-- File Input Area -->
                    <div class="relative">
                        <input type="file" 
                               name="featured_image" 
                               class="hidden"
                               x-ref="fileInput"
                               @change="handleFileSelect"
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
                                    PNG, JPG up to 2MB
                                </span>
                            </div>
                        </button>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200"
                            :disabled="!hasChanges">
                        <x-lucide-save class="w-4 h-4 mr-2" />
                        Update Featured Image
                    </button>
                </form>
            @else
                <!-- File Input for Create Form -->
                <div class="relative">
                    <input type="file" 
                           name="featured_image" 
                           class="hidden"
                           x-ref="fileInput"
                           @change="handleFileSelect"
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
                                PNG, JPG up to 2MB
                            </span>
                        </div>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function initFeaturedImage() {
    return {
        // Initialize all required variables
        previewUrl: null,
        showingPreview: false,
        hasChanges: false,
        selectedFile: null,
        currentImagePath: '{{ $article && $article->featured_image ? asset("storage/" . $article->featured_image) : asset("storage/brand/no-image.jpg") }}',
        
        init() {
            // Initialize component
            this.previewUrl = this.currentImagePath;
        },

        get hasImage() {
            return this.previewUrl && this.previewUrl !== '{{ asset("storage/brand/no-image.jpg") }}';
        },

        get imageInfo() {
            if (this.selectedFile) {
                return `${this.selectedFile.name} (${(this.selectedFile.size / 1024).toFixed(1)}KB)`;
            }
            return this.hasImage ? 'Current featured image' : 'No image selected';
        },

        handleFileSelect(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Validate file type and size
            const isValidType = ['image/jpeg', 'image/png', 'image/jpg'].includes(file.type);
            const isValidSize = file.size <= 2048 * 1024; // 2MB

            if (!isValidType || !isValidSize) {
                alert('Please select a valid image file (PNG, JPG, GIF) under 2MB');
                event.target.value = '';
                return;
            }

            this.selectedFile = file;
            this.previewUrl = URL.createObjectURL(file);
            this.hasChanges = true;
        },

        showPreview() {
            this.showingPreview = true;
            document.body.style.overflow = 'hidden';
        },

        closePreview() {
            this.showingPreview = false;
            document.body.style.overflow = 'auto';
        },

        clearSelection() {
            this.selectedFile = null;
            this.previewUrl = this.currentImagePath;
            this.hasChanges = false;
            this.$refs.fileInput.value = '';
        }
    }
}
</script>
@endpush