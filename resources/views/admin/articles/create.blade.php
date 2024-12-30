<x-admin-layout>
  <x-slot name="header">
    <x-admin.page-header
      icon="book-open"
      title="{{ __('Create New Article') }}"
      description="Create and publish your new article"
      :breadcrumbs="[
        ['label' => 'Articles', 'url' => route('admin.articles.index')],
        ['label' => 'Create New']
      ]"
    >
      <x-slot:actions>
        <a href="{{ route('admin.articles.index') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <x-lucide-arrow-left class="w-4 h-4 mr-2" />
          Back to Articles
        </a>
      </x-slot:actions>
    </x-admin.page-header>
  </x-slot>

  <div class="min-h-screen dark:bg-gray-900">
    <div class="container mx-auto px-4 py-8">
      <form x-data="{ 
              submitting: false,
              activeTab: 'content',
              submitForm(e) {
                if (this.submitting) return;
                this.submitting = true;
                e.target.submit();
              }
            }"
            @submit.prevent="submitForm($event)"
            action="{{ route('admin.articles.store') }}" 
            method="POST" 
            enctype="multipart/form-data"
            class="relative">
        @csrf

        <!-- Loading Overlay -->
        <div x-show="submitting"
             class="absolute inset-0 bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
          <div class="text-center">
            <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm transition ease-in-out duration-150 space-x-3">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              <span class="text-indigo-500">Creating article...</span>
            </div>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">This may take a few moments based on your connection speed.</p>
          </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
          <!-- Main Content -->
          <div class="w-full lg:w-2/3 order-2 lg:order-1 space-y-6">
            <!-- Content Card with Tabs -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
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
                      <span>Content Editor</span>
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
                      <span>Gallery</span>
                    </div>
                  </button>
                </nav>
              </div>

              <!-- Tab Content -->
              <div class="p-6">
                <!-- Content Tab -->
                <div x-show="activeTab === 'content'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0">
                  <!-- Title, Excerpt, Tags, and Content fields go here -->
                  <div class="space-y-6">
                    <!-- Title -->
                    <div>
                      <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Title <span class="text-red-500">*</span>
                      </label>
                      <input type="text" id="title" name="title"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ old('title') }}" required>
                        <div class="mt-2 flex items-center justify-between text-sm">
                            <p class="text-gray-500 dark:text-gray-400">Recommended: 60 characters maximum</p>
                            <p class="text-sm text-gray-500">Characters: <span id="title-char-count">0</span></p>
                        </div>
                    </div>

                    <!-- Excerpt -->
                    <div>
                      <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Excerpt (description)
                      </label>
                      <textarea id="excerpt" name="excerpt"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        rows="3">{{ old('excerpt') }}</textarea>
                        <div class="mt-2 flex items-center justify-between text-sm">
                            <p class="text-gray-500 dark:text-gray-400">Recommended: 160 characters maximum</p>
                            <p class="text-sm text-gray-500">Characters: <span id="excerpt-char-count">0</span></p>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div>
                      <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Tags (comma separated)
                      </label>
                      <input type="text" id="tags" name="tags" 
                             class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white" 
                             value="{{ old('tags') }}">
                    </div>

                    <!-- Content -->
                    <div>
                      <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Content <span class="text-red-500">*</span>
                      </label>
                      <textarea id="content" name="content" class="w-full">{{ old('content') }}</textarea>
                    </div>
                  </div>
                </div>

                <!-- Gallery Tab -->
                <div x-show="activeTab === 'gallery'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0">
                  <x-admin.article.gallery-create />
                </div>
              </div>
            </div>
          </div>

          <!-- Sidebar -->
          <div class="w-full lg:w-1/3 order-1 lg:order-2 space-y-6">
            <x-admin.article.sidebar :categories="$categories" />
            
            <!-- Submit Button Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 sticky top-6">
              <div class="p-6">
                <button type="submit"
                        :disabled="submitting"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-sm transition duration-150 ease-in-out flex items-center justify-center disabled:opacity-75 disabled:cursor-not-allowed">
                  <template x-if="!submitting">
                    <div class="flex items-center">
                      <x-lucide-plus class="w-5 h-5 mr-2" />
                      Create Article
                    </div>
                  </template>
                  <template x-if="submitting">
                    <div class="flex items-center">
                      <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                      </svg>
                      Creating...
                    </div>
                  </template>
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</x-admin-layout>
