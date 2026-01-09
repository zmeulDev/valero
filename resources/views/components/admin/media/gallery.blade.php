@props(['media'])

@props(['media'])

<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
    @forelse($media as $item)
        <div class="relative group bg-background rounded-lg overflow-hidden border border-border">
            {{-- Image Container --}}
            <div class="aspect-square w-full">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->alt_text }}"
                    class="w-full h-full object-cover" data-modal-target="previewModal" data-modal-toggle="previewModal"
                    loading="lazy">
            </div>

            {{-- Hover Overlay with Actions --}}
            <div
                class="absolute inset-0 bg-black bg-opacity-75 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex flex-col justify-between p-3">
                <div class="text-white">
                    <p class="font-medium text-sm truncate">{{ $item->filename }}</p>
                    <p class="text-xs text-gray-300">{{ number_format($item->size / 1024, 2) }} KB</p>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" data-modal-target="default-modal" data-modal-toggle="default-modal"
                        data-image-path="{{ asset('storage/' . $item->image_path) }}"
                        data-download-link="{{ route('admin.media.download', $item) }}"
                        data-dimensions="{{ json_encode($item->dimensions) }}"
                        data-uploaded="{{ $item->created_at->format('M d, Y') }}"
                        data-article-title="{{ $item->article->title ?? 'No Article' }}"
                        class="p-1.5 bg-gray-800 rounded-md hover:bg-gray-700 transition-colors border border-gray-600">
                        <x-lucide-eye class="h-4 w-4 text-gray-300" />
                    </button>
                </div>
            </div>

            @if($item->is_cover)
                <div class="absolute top-2 left-2 bg-yellow-500 text-white text-xs px-2 py-1 rounded-full shadow-sm">
                    Cover
                </div>
            @endif
        </div>
    @empty
        <div class="col-span-full py-12 text-center">
            <x-lucide-image class="mx-auto h-12 w-12 text-muted" />
            <h3 class="mt-2 text-sm font-semibold text-text">{{ __('admin.media.no_media') }}</h3>
            <p class="mt-1 text-sm text-muted">{{ __('admin.media.upload_media') }}</p>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($media->hasPages())
    <div class="mt-6 border-t border-border pt-4">
        {{ $media->links() }}
    </div>
@endif

<!-- Main modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-screen bg-black bg-opacity-75 backdrop-blur-sm p-4"
    role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="relative w-full max-w-5xl max-h-[95vh] flex flex-col">
        <!-- Modal content -->
        <div class="relative bg-surface rounded-lg shadow-xl flex flex-col max-h-[95vh] overflow-hidden">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-border flex-shrink-0">
                <h3 id="modal-title" class="text-xl font-semibold text-text">
                    {{ __('admin.media.media_preview') }}
                </h3>
                <button type="button"
                    class="text-muted hover:text-text hover:bg-background rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors"
                    data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">{{ __('admin.media.close_modal') }}</span>
                </button>
            </div>

            <!-- Modal body -->
            <div class="p-4 md:p-5 flex-1 flex flex-col min-h-0 gap-4 overflow-y-auto">
                <!-- Image Preview -->
                <div
                    class="bg-background rounded-lg overflow-hidden flex items-center justify-center flex-1 min-h-[300px] border border-border">
                    <img src="" alt="Media Preview" id="modal-image" class="max-w-full max-h-full object-contain">
                </div>

                <!-- Meta information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 flex-shrink-0">
                    <!-- File Information -->
                    <div class="bg-background rounded-lg p-4 shadow-sm border border-border">
                        <h4 class="text-sm font-semibold text-text mb-3">{{ __('admin.media.file_information') }}</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center text-muted">
                                <x-lucide-file class="h-4 w-4 mr-2" />
                                <span class="font-medium text-text">{{ __('admin.media.filename') }}:</span>
                                <span class="ml-2" id="modal-filename"></span>
                            </div>
                            <div class="flex items-center text-muted">
                                <x-lucide-hard-drive class="h-4 w-4 mr-2" />
                                <span class="font-medium text-text">{{ __('admin.media.size') }}:</span>
                                <span class="ml-2" id="modal-filesize"></span>
                            </div>
                            <div class="flex items-center text-muted">
                                <x-lucide-maximize class="h-4 w-4 mr-2" />
                                <span class="font-medium text-text">{{ __('admin.media.dimensions') }}:</span>
                                <span class="ml-2" id="modal-dimensions"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Details -->
                    <div class="bg-background rounded-lg p-4 shadow-sm border border-border">
                        <h4 class="text-sm font-semibold text-text mb-3">{{ __('admin.media.additional_details') }}</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center text-muted">
                                <x-lucide-calendar class="h-4 w-4 mr-2" />
                                <span class="font-medium text-text">{{ __('admin.media.uploaded') }}:</span>
                                <span class="ml-2" id="modal-uploaded"></span>
                            </div>
                            <div class="flex items-center text-muted">
                                <x-lucide-newspaper class="h-4 w-4 mr-2" />
                                <span class="font-medium text-text">{{ __('admin.media.article') }}:</span>
                                <span class="ml-2" id="modal-article"></span>
                            </div>
                            <div id="modal-is-cover-container"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-border rounded-b flex-shrink-0 bg-background">
                <div class="flex items-center space-x-2">
                    <button type="button" id="prev-image"
                        class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800 disabled:opacity-50 disabled:cursor-not-allowed">
                        <x-lucide-chevron-left class="h-5 w-5" />
                    </button>
                    <button type="button" id="next-image"
                        class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800 disabled:opacity-50 disabled:cursor-not-allowed">
                        <x-lucide-chevron-right class="h-5 w-5" />
                    </button>
                </div>
                <div class="ml-auto flex items-center space-x-2">
                    <a href="#" id="download-link"
                        class="py-2.5 px-5 text-sm font-medium text-text focus:outline-none bg-surface rounded-lg border border-border hover:bg-background hover:text-indigo-600 focus:z-10 focus:ring-4 focus:ring-indigo-100 transition-colors">
                        <div class="flex items-center">
                            <x-lucide-download class="h-4 w-4 mr-2" />
                            {{ __('admin.media.download') }}
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
            const modalImage = document.getElementById('modal-image');

            if (modal && item) {
                // Update image with proper sizing
                modalImage.src = item.imagePath;
                modalImage.style.maxWidth = '100%';
                modalImage.style.maxHeight = '100%';
                modalImage.style.width = 'auto';
                modalImage.style.height = 'auto';

                // Ensure image fits when loaded
                modalImage.onload = function () {
                    const imageContainer = modalImage.parentElement;
                    const containerHeight = imageContainer.clientHeight;
                    const containerWidth = imageContainer.clientWidth;

                    // Calculate aspect ratio
                    const imageAspectRatio = this.naturalWidth / this.naturalHeight;
                    const containerAspectRatio = containerWidth / containerHeight;

                    // Adjust image to fit container
                    if (imageAspectRatio > containerAspectRatio) {
                        // Image is wider - fit to width
                        this.style.width = '100%';
                        this.style.height = 'auto';
                    } else {
                        // Image is taller - fit to height
                        this.style.width = 'auto';
                        this.style.height = '100%';
                    }
                };

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
                    const isHidden = modal.classList.contains('hidden');

                    if (isHidden) {
                        // Opening modal
                        modal.classList.remove('hidden');
                        modal.setAttribute('aria-hidden', 'false');
                        // Focus the first focusable element in the modal
                        const firstFocusable = modal.querySelector('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                        if (firstFocusable) {
                            firstFocusable.focus();
                        }
                    } else {
                        // Closing modal
                        modal.classList.add('hidden');
                        modal.setAttribute('aria-hidden', 'true');
                    }
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
                    modal.setAttribute('aria-hidden', 'true');
                }
            });
        });

        // Close modal on backdrop click
        const modal = document.getElementById('default-modal');
        if (modal) {
            modal.addEventListener('click', (e) => {
                // Close if clicking the backdrop (the modal container itself, not its children)
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                }
            });
        }

        // Close modal on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const modal = document.getElementById('default-modal');
                if (modal && !modal.classList.contains('hidden')) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                }
            }
        });
    });
</script>