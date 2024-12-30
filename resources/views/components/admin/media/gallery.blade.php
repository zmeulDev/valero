@props(['media'])

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
    @forelse($media as $item)
        <div class="relative group bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden">
            {{-- Image Container --}}
            <div class="aspect-square w-full">
                <img src="{{ asset($item->image_path) }}" 
                     alt="{{ $item->alt_text }}" 
                     class="w-full h-full object-cover"
                     data-modal-target="previewModal" 
                     data-modal-toggle="previewModal"
                     loading="lazy">
            </div>

            {{-- Hover Overlay with Actions --}}
            <div class="absolute inset-0 bg-black bg-opacity-75 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex flex-col justify-between p-3">
                <div class="text-white">
                    <p class="font-medium text-sm truncate">{{ $item->filename }}</p>
                    <p class="text-xs text-gray-300">{{ number_format($item->size / 1024, 2) }} KB</p>
                </div>
                
                <div class="flex justify-end space-x-2">
                <button type="button"
                        data-modal-target="default-modal" 
                        data-modal-toggle="default-modal"
                        data-image-path="{{ asset($item->image_path) }}"
                        data-download-link="{{ route('admin.media.download', $item) }}"
                        data-dimensions="{{ json_encode($item->dimensions) }}"
                        data-uploaded="{{ $item->created_at->format('M d, Y') }}"
                        data-article-title="{{ $item->article->title ?? 'No Article' }}"
                        class="p-1.5 bg-gray-800 rounded-md hover:bg-gray-700 transition-colors">
                    <x-lucide-eye class="h-4 w-4 text-gray-300" />
                </button>
                </div>
            </div>

            @if($item->is_cover)
                <div class="absolute top-2 left-2 bg-yellow-500 text-white text-xs px-2 py-1 rounded-full">
                    Cover
                </div>
            @endif
        </div>
    @empty
        <div class="col-span-full py-12 text-center">
            <x-lucide-image class="mx-auto h-12 w-12 text-gray-400" />
            <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-200">No media files</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload some images to get started.</p>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($media->hasPages())
    <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
        {{ $media->links() }}
    </div>
@endif

<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true" 
     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex items-center justify-center w-full md:inset-0 h-screen bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-2xl">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Media Preview
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-6">
                <!-- Image Preview -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg overflow-hidden">
                    <img src="" alt="Media Preview" class="w-full h-auto">
                </div>

                <!-- Meta information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- File Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">File Information</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center text-gray-600 dark:text-gray-300">
                                <x-lucide-file class="h-4 w-4 mr-2" />
                                <span class="font-medium">Filename:</span>
                                <span class="ml-2" id="modal-filename"></span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-300">
                                <x-lucide-hard-drive class="h-4 w-4 mr-2" />
                                <span class="font-medium">Size:</span>
                                <span class="ml-2" id="modal-filesize"></span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-300">
                                <x-lucide-maximize class="h-4 w-4 mr-2" />
                                <span class="font-medium">Dimensions:</span>
                                <span class="ml-2" id="modal-dimensions"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Additional Details</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center text-gray-600 dark:text-gray-300">
                                <x-lucide-calendar class="h-4 w-4 mr-2" />
                                <span class="font-medium">Uploaded:</span>
                                <span class="ml-2" id="modal-uploaded"></span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-300">
                                <x-lucide-newspaper class="h-4 w-4 mr-2" />
                                <span class="font-medium">Article:</span>
                                <span class="ml-2" id="modal-article"></span>
                            </div>
                            @if($item->is_cover)
                            <div class="flex items-center text-yellow-600 dark:text-yellow-500">
                                <x-lucide-star class="h-4 w-4 mr-2" />
                                <span class="font-medium">Cover Image</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <div class="flex items-center space-x-2">
                    <button type="button" id="prev-image" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        <x-lucide-chevron-left class="h-5 w-5" />
                    </button>
                    <button type="button" id="next-image" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                        <x-lucide-chevron-right class="h-5 w-5" />
                    </button>
                </div>
                <div class="ml-auto flex items-center space-x-2">
                    
                    <a href="#" id="download-link" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        <div class="flex items-center">
                            <x-lucide-download class="h-4 w-4 mr-2" />
                            Download
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentImageIndex = 0;
    const mediaItems = [];

    // Collect all media items data
    document.querySelectorAll('[data-modal-toggle="default-modal"]').forEach((button, index) => {
        // Parse the dimensions JSON
        let dimensions = 'N/A';
        const rawDimensions = button.getAttribute('data-dimensions');
        
        try {
            if (rawDimensions) {
                // Clean the string and parse JSON
                const cleanDimensions = rawDimensions
                    .replace(/&quot;/g, '"')
                    .replace(/&#34;/g, '"')
                    .replace(/\\/g, '');
                    
                const dimensionsData = JSON.parse(cleanDimensions);
                if (dimensionsData && dimensionsData.width && dimensionsData.height) {
                    dimensions = `${dimensionsData.width.toLocaleString()} × ${dimensionsData.height.toLocaleString()}px`;
                }
            }
        } catch (e) {
            console.error('Error parsing dimensions:', e);
            console.log('Raw dimensions:', rawDimensions); // Debug log
        }

        mediaItems.push({
            index: index,
            imagePath: button.getAttribute('data-image-path'),
            downloadLink: button.getAttribute('data-download-link'),
            filename: button.closest('.relative').querySelector('.font-medium').textContent,
            filesize: button.closest('.relative').querySelector('.text-gray-300').textContent,
            dimensions: dimensions,
            uploaded: button.getAttribute('data-uploaded') || 'N/A',
            articleTitle: button.getAttribute('data-article-title') || 'No Article'
        });
    });

    function updateModalContent(index) {
        const modal = document.getElementById('default-modal');
        const item = mediaItems[index];

        if (modal && item) {
            modal.querySelector('img').src = item.imagePath;
            modal.querySelector('#download-link').href = item.downloadLink;
            modal.querySelector('#modal-filename').textContent = item.filename;
            modal.querySelector('#modal-filesize').textContent = item.filesize;
            modal.querySelector('#modal-dimensions').textContent = item.dimensions;
            modal.querySelector('#modal-uploaded').textContent = item.uploaded;
            modal.querySelector('#modal-article').textContent = item.articleTitle;

            // Update navigation buttons state
            document.getElementById('prev-image').disabled = index === 0;
            document.getElementById('next-image').disabled = index === mediaItems.length - 1;
        }
    }

    // Modal toggle event
    document.querySelectorAll('[data-modal-toggle="default-modal"]').forEach(button => {
        button.addEventListener('click', event => {
            const modal = document.getElementById('default-modal');
            currentImageIndex = mediaItems.findIndex(item => item.imagePath === button.getAttribute('data-image-path'));
            
            if (modal) {
                updateModalContent(currentImageIndex);
                modal.classList.toggle('hidden');
            }
        });
    });

    // Navigation buttons
    document.getElementById('prev-image').addEventListener('click', () => {
        if (currentImageIndex > 0) {
            currentImageIndex--;
            updateModalContent(currentImageIndex);
        }
    });

    document.getElementById('next-image').addEventListener('click', () => {
        if (currentImageIndex < mediaItems.length - 1) {
            currentImageIndex++;
            updateModalContent(currentImageIndex);
        }
    });

    // Close modal functionality
    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', () => {
            const target = button.getAttribute('data-modal-hide');
            const modal = document.getElementById(target);
            if (modal) {
                modal.classList.add('hidden');
            }
        });
    });
});
</script>

