<x-admin-layout>
  <x-slot name="header">
    <x-admin.page-header
      icon="book-open"
      title="{{ __('admin.articles.edit_article') }}"
      description="{{ __('admin.articles.description') }}"
      :breadcrumbs="[
        ['label' => __('admin.articles.breadcrumbs'), 'url' => route('admin.articles.index')],
        ['label' => __('admin.common.edit')]
      ]"
    >
      <x-slot:actions>
        <a href="{{ route('admin.articles.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <x-lucide-arrow-left class="w-4 h-4 mr-2" />
          {{ __('admin.articles.back_to_articles') }}
        </a>
      </x-slot:actions>
    </x-admin.page-header>
  </x-slot>

  <div class="min-h-screen dark:bg-gray-900">
    <div class="container mx-auto px-4 py-8">
      <!-- Server-side validation errors toast (only shows if there are session messages) -->
      @if(session('success') || session('error') || session('info') || session('warning'))
        <x-notification />
      @endif
      
      <!-- Validation Errors Banner (if any) -->
      @if($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
          <div class="flex items-start">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3 flex-1">
              <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                Missing Required Information
              </h3>
              <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                <ul class="list-disc list-inside space-y-1">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
            <div class="ml-4 flex-shrink-0">
              <button type="button" 
                      @click="$el.closest('div').remove()"
                      class="inline-flex rounded-md text-red-400 hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      @endif

      <form x-data="articleFormEdit()"
            @submit.prevent="validateAndSubmit($event)"
        action="{{ route('admin.articles.update', $article) }}"
        method="POST"
        enctype="multipart/form-data"
        novalidate
        class="relative">
        @csrf
        @method('PUT')

        <!-- Loading Overlay -->
        <div x-show="submitting"
             class="absolute inset-0 bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center">
            <div class="text-center">
                <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm transition ease-in-out duration-150 space-x-3">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-indigo-500">{{ __('admin.articles.updating') }}...</span>
                </div>
            </div>
        </div>

        <div class="w-full">
                <!-- Content Card with Tabs -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700"
                     x-data="{ 
                         activeTab: localStorage.getItem('activeArticleTab') || 'content',
                         init() {
                             this.$watch('activeTab', value => localStorage.setItem('activeArticleTab', value))
                         }
                     }">
                    <!-- Tabs Header -->
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                            <button type="button"
                                    @click.prevent="activeTab = 'content'"
                                    :class="{ 
                                        'border-indigo-500 text-indigo-600 dark:text-indigo-500': activeTab === 'content',
                                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'content'
                                    }"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out">
                                <div class="flex items-center space-x-2">
                                    <x-lucide-file-text class="w-5 h-5" />
                                    <span>{{ __('admin.articles.content') }}</span>
                                </div>
                            </button>
                            
                            <button type="button"
                                    @click.prevent="activeTab = 'gallery'"
                                    :class="{ 
                                        'border-indigo-500 text-indigo-600 dark:text-indigo-500': activeTab === 'gallery',
                                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'gallery'
                                    }"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out">
                                <div class="flex items-center space-x-2">
                                    <x-lucide-images class="w-5 h-5" />
                                    <span>{{ __('admin.articles.gallery') }}</span>
                                </div>
                            </button>
                            

                            <button type="button"
                                    @click.prevent="activeTab = 'options'"
                                    :class="{ 
                                        'border-indigo-500 text-indigo-600 dark:text-indigo-500': activeTab === 'options',
                                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'options'
                                    }"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out">
                                <div class="flex items-center space-x-2">
                                    <x-lucide-settings class="w-5 h-5" />
                                    <span>{{ __('admin.articles.options') }}</span>
                                </div>
                            </button>

                            <button type="button"
                                    @click.prevent="activeTab = 'seo'"
                                    :class="{ 
                                        'border-indigo-500 text-indigo-600 dark:text-indigo-500': activeTab === 'seo',
                                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'seo'
                                    }"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out">
                                <div class="flex items-center space-x-2">
                                    <x-lucide-search class="w-5 h-5" />
                                    <span>{{ __('admin.articles.seo') }}</span>
                                </div>
                            </button>

                            <button type="button"
                                    @click.prevent="activeTab = 'publish'"
                                    :class="{ 
                                        'border-indigo-500 text-indigo-600 dark:text-indigo-500': activeTab === 'publish',
                                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': activeTab !== 'publish'
                                    }"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition duration-150 ease-in-out">
                                <div class="flex items-center space-x-2">
                                    <x-lucide-calendar class="w-5 h-5" />
                                    <span>{{ __('admin.articles.publish') }}</span>
                                </div>
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div>
                        <!-- Content Tab -->
                        <div x-show="activeTab === 'content'" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="p-6"> 
                            
                            <!-- Title Card -->
                            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden mb-6">
                                <div class="p-2">
                                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ __('admin.articles.title') }} <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           id="title" 
                                           name="title"
                                           class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white @error('title') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror"
                                           value="{{ old('title', $article->title) }}">
                                    @error('title')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                    <div class="mt-2 flex items-center justify-between text-sm">
                                        <p class="text-gray-500 dark:text-gray-400">{{ __('admin.articles.recommended_characters_title') }}</p>
                                        <p class="text-sm text-gray-500">{{ __('admin.articles.characters') }}: <span id="title-char-count">0</span></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Excerpt Card -->
                            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden mb-6">
                                <div class="p-2">
                                    <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ __('admin.articles.excerpt') }}
                                    </label>
                                    <textarea id="excerpt" 
                                             name="excerpt"
                                             class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                                             rows="3">{{ old('excerpt', $article->excerpt) }}</textarea>
                                    <div class="mt-2 flex items-center justify-between text-sm">
                                        <p class="text-gray-500 dark:text-gray-400">{{ __('admin.articles.recommended_characters_excerpt') }}</p>
                                        <p class="text-sm text-gray-500">{{ __('admin.articles.characters') }}: <span id="excerpt-char-count">0</span></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Tags Card -->
                            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden mb-6">
                                <div class="p-2">
                                    <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        {{ __('admin.articles.tags') }}
                                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">(Comma-separated, for SEO optimization)</span>
                                    </label>
                                    <input type="text" 
                                           id="tags" 
                                           name="tags" 
                                           class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
                                           value="{{ old('tags', $article->tags) }}"
                                           placeholder="keyword1, keyword2, long-tail keyword, etc.">
                                    <div class="mt-2 space-y-1">
                                        <div class="flex items-center justify-between text-sm">
                                            <p class="text-gray-500 dark:text-gray-400">
                                                <span class="font-medium">SEO Best Practices:</span> Use 5-10 relevant keywords (2-50 chars each)
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                Tags: <span id="tags-counter">0</span> / 15 max
                                            </p>
                                        </div>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">
                                            💡 <strong>Tip:</strong> Tags are used in meta keywords, article schema, and help with SEO. Use specific, relevant keywords that match your content.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                {{ __('admin.articles.content') }} <span class="text-red-500">*</span>
                            </label>
                            <textarea id="content" 
                                     name="content"
                                     class="w-full @error('content') border-red-500 dark:border-red-500 @enderror">{{ old('content', $article->content) }}</textarea>
                            @error('content')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gallery Tab -->
                        <div x-show="activeTab === 'gallery'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="p-6">
                            <x-admin.article.gallery-edit :article="$article" />
                        </div>

                        <!-- SEO Tab -->
                        <div x-show="activeTab === 'seo'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="p-6">
                            <x-admin.article.seo :article="$article" />
                        </div>

                        <!-- Options Tab -->
                        <div x-show="activeTab === 'options'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-1"
                             class="p-6">
                            <x-admin.article.options :article="$article" />
                        </div>

                        <!-- Publishing Tab -->
                        <div x-show="activeTab === 'publish'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 transform translate-y-0"
                             x-transition:leave-end="opacity-0 transform -translate-y-2">
                            <x-admin.article.publish-option :article="$article" :categories="$categories" :scheduledArticles="$scheduledArticles" />
                    </div>
                </div>
            </div>
        </div>
      </form>
    </div>
  </div>

</x-admin-layout>