<x-admin-layout>
    <div x-data="{
        showDeleteModal: false,
        bookmarkToDelete: null,
        copiedId: null,
        
        openDeleteModal(id, title) {
            this.bookmarkToDelete = { id, title };
            this.showDeleteModal = true;
        },
        
        closeDeleteModal() {
            this.showDeleteModal = false;
            this.bookmarkToDelete = null;
        },
        
        copyToClipboard(text, id) {
            if (!text) return;
            
            // Try modern Clipboard API first (requires HTTPS)
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(() => {
                    this.copiedId = id;
                    setTimeout(() => this.copiedId = null, 2000);
                }).catch(err => {
                    console.error('Clipboard API failed:', err);
                    this.fallbackCopy(text, id);
                });
            } else {
                // Fallback for HTTP or unsupported browsers
                this.fallbackCopy(text, id);
            }
        },
        
        fallbackCopy(text, id) {
            const textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            
            try {
                document.execCommand('copy');
                this.copiedId = id;
                setTimeout(() => this.copiedId = null, 2000);
            } catch (err) {
                console.error('Fallback copy failed:', err);
            } finally {
                document.body.removeChild(textarea);
            }
        }
    }">
        <x-slot name="header">
            <x-admin.page-header
                icon="bookmark"
                title="{{ __('admin.bookmarks.title') }}"
                description="{{ __('admin.bookmarks.description') }}"
                :breadcrumbs="[['label' => __('admin.bookmarks.breadcrumbs')]]"
            >
                <x-slot:actions>
                    <a href="{{ route('admin.bookmarks.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        <x-lucide-plus-circle class="w-4 h-4 mr-2" />
                        {{ __('admin.bookmarks.new_bookmark') }}
                    </a>
                </x-slot:actions>

                <x-slot:stats>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-admin.stats-card 
                            icon="bookmark" 
                            label="{{ __('admin.bookmarks.total_bookmarks') }}" 
                            :value="$bookmarks->total()" 
                        />
                        <x-admin.stats-card 
                            icon="tag" 
                            iconColor="blue" 
                            label="{{ __('admin.bookmarks.categories') }}" 
                            :value="$categories->count()" 
                        />
                    </div>
                </x-slot:stats>
            </x-admin.page-header>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Search and Filter Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <!-- Search Form -->
                            <form method="GET" action="{{ route('admin.bookmarks.index') }}" class="flex-1">
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                <div class="relative">
                                    <x-lucide-search class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" />
                                    <input type="search" 
                                           name="search" 
                                           placeholder="{{ __('admin.bookmarks.search_placeholder') }}" 
                                           value="{{ request('search') }}"
                                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors duration-200">
                                </div>
                            </form>
                            
                            <!-- Category Pills -->
                            <div class="flex items-center gap-2 overflow-x-auto pb-2 sm:pb-0">
                                <a href="{{ route('admin.bookmarks.index', ['search' => request('search')]) }}"
                                   class="px-3 py-2 text-xs font-medium rounded-full whitespace-nowrap transition-colors duration-200 {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                    {{ __('admin.bookmarks.all') }} ({{ $bookmarks->total() }})
                                </a>
                                @foreach($categories as $category)
                                    <a href="{{ route('admin.bookmarks.index', ['category' => $category, 'search' => request('search')]) }}"
                                       class="px-3 py-2 text-xs font-medium rounded-full whitespace-nowrap transition-colors duration-200 {{ request('category') === $category ? 'bg-indigo-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                        {{ $category }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 p-4 rounded-lg">
                        <div class="flex items-center">
                            <x-lucide-check-circle class="h-5 w-5 text-green-400 mr-3" />
                            <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Bookmarks Grid -->
                @if($bookmarks->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        @foreach($bookmarks as $bookmark)
                            <div class="group bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600 hover:shadow-lg transition-all duration-200">
                                <div class="p-5">
                                    <!-- Header -->
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-2">
                                                <x-lucide-bookmark class="h-5 w-5 text-indigo-500 flex-shrink-0" />
                                                <h3 class="text-base font-semibold text-gray-900 dark:text-white truncate">
                                                    {{ $bookmark->title }}
                                                </h3>
                                            </div>
                                            @if($bookmark->category)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300">
                                                    <x-lucide-tag class="w-3 h-3 mr-1" />
                                                    {{ $bookmark->category }}
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap ml-2">
                                            {{ $bookmark->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                    
                                    <!-- Link Section -->
                                    @if($bookmark->link)
                                        <div class="mb-3">
                                            <div class="flex items-center gap-2 bg-gray-50 dark:bg-gray-900/50 rounded-lg p-2.5 group/link">
                                                <x-lucide-link class="w-4 h-4 text-gray-400 flex-shrink-0" />
                                                <div class="flex-1 min-w-0">
                                                    <a href="{{ $bookmark->link }}" 
                                                       target="_blank"
                                                       class="text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 truncate block">
                                                        {{ $bookmark->link }}
                                                    </a>
                                                </div>
                                                <button @click="copyToClipboard('{{ $bookmark->link }}', {{ $bookmark->id }})"
                                                        type="button"
                                                        class="flex-shrink-0 p-1.5 rounded-md text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:text-indigo-400 dark:hover:bg-indigo-900/30 transition-colors duration-150">
                                                    <x-lucide-copy class="w-4 h-4" x-show="copiedId !== {{ $bookmark->id }}" />
                                                    <x-lucide-check class="w-4 h-4 text-green-600 dark:text-green-400" x-show="copiedId === {{ $bookmark->id }}" />
                                                </button>
                                            </div>
                                            <div x-show="copiedId === {{ $bookmark->id }}" 
                                                 x-transition
                                                 class="mt-1 text-xs text-green-600 dark:text-green-400 font-medium flex items-center">
                                                <x-lucide-check-circle class="w-3 h-3 mr-1" />
                                                {{ __('admin.bookmarks.copied') }}!
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Notes Section -->
                                    @if($bookmark->notes)
                                        <div class="mb-3">
                                            <div class="bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-200 dark:border-yellow-800/50 rounded-lg p-2.5">
                                                <div class="flex items-start gap-2">
                                                    <x-lucide-sticky-note class="w-4 h-4 text-yellow-600 dark:text-yellow-500 flex-shrink-0 mt-0.5" />
                                                    <p class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed line-clamp-3">
                                                        {{ $bookmark->notes }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Actions -->
                                    <div class="flex items-center justify-between pt-3 border-t border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-2">
                                            @if($bookmark->link)
                                                <button @click="copyToClipboard('{{ $bookmark->link }}', 'btn-{{ $bookmark->id }}')"
                                                        type="button"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/30 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 rounded-lg transition-colors duration-150">
                                                    <x-lucide-clipboard class="w-3.5 h-3.5 mr-1.5" x-show="copiedId !== 'btn-{{ $bookmark->id }}'" />
                                                    <x-lucide-check class="w-3.5 h-3.5 mr-1.5 text-green-600" x-show="copiedId === 'btn-{{ $bookmark->id }}'" />
                                                    <span x-show="copiedId !== 'btn-{{ $bookmark->id }}'">{{ __('admin.bookmarks.copy_link') }}</span>
                                                    <span x-show="copiedId === 'btn-{{ $bookmark->id }}'">{{ __('admin.bookmarks.copied') }}!</span>
                                                </button>
                                            @endif
                                            <a href="{{ route('admin.bookmarks.edit', $bookmark) }}" 
                                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 rounded-lg transition-colors duration-150">
                                                <x-lucide-pencil class="w-3.5 h-3.5 mr-1.5" />
                                                {{ __('admin.common.edit') }}
                                            </a>
                                        </div>
                                        <button type="button"
                                                @click="openDeleteModal({{ $bookmark->id }}, '{{ addslashes($bookmark->title) }}')"
                                                class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors duration-150">
                                            <x-lucide-trash-2 class="h-4 w-4" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                {{ __('admin.bookmarks.showing') }} 
                                <span class="font-medium">{{ $bookmarks->firstItem() }}</span>
                                {{ __('admin.bookmarks.to') }}
                                <span class="font-medium">{{ $bookmarks->lastItem() }}</span>
                                {{ __('admin.bookmarks.of') }}
                                <span class="font-medium">{{ $bookmarks->total() }}</span>
                                {{ __('admin.bookmarks.bookmarks') }}
                            </div>
                            <div>
                                {{ $bookmarks->links() }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full mb-4">
                                <x-lucide-bookmark class="w-8 h-8 text-gray-400" />
                            </div>
                            <h3 class="text-base font-medium text-gray-900 dark:text-white mb-2">
                                @if(request('search') || request('category'))
                                    {{ __('admin.bookmarks.no_results') }}
                                @else
                                    {{ __('admin.bookmarks.no_bookmarks') }}
                                @endif
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 max-w-sm mx-auto">
                                @if(request('search') || request('category'))
                                    {{ __('admin.bookmarks.try_different_search') }}
                                @else
                                    {{ __('admin.bookmarks.no_bookmarks_description') }}
                                @endif
                            </p>
                            @if(!request('search') && !request('category'))
                                <a href="{{ route('admin.bookmarks.create') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                    <x-lucide-plus-circle class="h-5 w-5 mr-2" />
                                    {{ __('admin.bookmarks.new_bookmark') }}
                                </a>
                            @else
                                <a href="{{ route('admin.bookmarks.index') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <x-lucide-x class="h-5 w-5 mr-2" />
                                    {{ __('admin.bookmarks.clear_filters') }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="showDeleteModal" 
             x-cloak
             class="fixed z-50 inset-0 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showDeleteModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity" 
                     aria-hidden="true"
                     @click="closeDeleteModal()"></div>

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
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20 sm:mx-0 sm:h-10 sm:w-10">
                                <x-lucide-alert-triangle class="h-6 w-6 text-red-600 dark:text-red-400" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                    {{ __('admin.bookmarks.delete_confirmation') }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ __('admin.bookmarks.delete_warning') }}
                                        <span class="font-semibold" x-text="bookmarkToDelete?.title"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <form :action="`{{ route('admin.bookmarks.index') }}/${bookmarkToDelete?.id}`" 
                              method="POST" 
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                                {{ __('admin.bookmarks.delete') }}
                            </button>
                        </form>
                        <button type="button"
                                @click="closeDeleteModal()"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-700 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                            {{ __('admin.bookmarks.cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
