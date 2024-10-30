<x-admin-layout>
  <x-slot name="header">
    <div class="bg-white">
      <div class="border-b border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
          <div class="flex justify-between items-center h-16">
            <!-- Left side -->
            <div class="flex-1 flex items-center">
              <x-lucide-book-open class="w-8 h-8 text-indigo-600 mr-3" />
              <div>
                <h2 class="text-2xl font-bold text-gray-900 leading-7">
                  {{ __('Create New Article') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                  Create and publish your new article
                </p>
              </div>
            </div>

            <!-- Right side -->
            <div class="flex items-center space-x-4">
              <a href="{{ route('admin.articles.index') }}" 
                 class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                Back to Articles
              </a>
            </div>
          </div>

          <!-- Breadcrumbs -->
          <div class="py-4">
            <nav class="flex" aria-label="Breadcrumb">
              <ol role="list" class="flex items-center space-x-4">
                <li>
                  <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-gray-500">
                      <x-lucide-home class="flex-shrink-0 h-5 w-5" />
                      <span class="sr-only">Home</span>
                    </a>
                  </div>
                </li>
                <li>
                  <div class="flex items-center">
                    <x-lucide-chevron-right class="flex-shrink-0 h-5 w-5 text-gray-400" />
                    <a href="{{ route('admin.articles.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Articles</a>
                  </div>
                </li>
                <li>
                  <div class="flex items-center">
                    <x-lucide-chevron-right class="flex-shrink-0 h-5 w-5 text-gray-400" />
                    <span class="ml-4 text-sm font-medium text-indigo-600">Create New</span>
                  </div>
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </x-slot>

  <div class="min-h-screen dark:bg-gray-900">
    <div class="container mx-auto px-4 py-8">
      <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="flex flex-col lg:flex-row gap-8">
          <!-- Main Content -->
          <div class="w-full lg:w-2/3 order-2 lg:order-1 space-y-6">
            <!-- Title Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
              <div class="p-6">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                  Title <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title"
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                       value="{{ old('title') }}" 
                       required
                       x-data="{ charCount: $el.value.length }"
                       x-on:input="charCount = $el.value.length"
                       maxlength="60">
                <div class="mt-2 flex items-center justify-between text-sm">
                  <p class="text-gray-500 dark:text-gray-400">Recommended: 60 characters maximum</p>
                  <p x-text="charCount + '/60'" 
                     :class="{ 'text-red-500': charCount > 60, 'text-gray-500': charCount <= 60 }"
                     class="dark:text-gray-400"></p>
                </div>
              </div>
            </div>

            <!-- Excerpt Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
              <div class="p-6">
                <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                  Excerpt (Meta Description)
                </label>
                <textarea id="excerpt" 
                         name="excerpt"
                         class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white"
                         rows="3"
                         x-data="{ charCount: $el.value.length }"
                         x-on:input="charCount = $el.value.length"
                         maxlength="160">{{ old('excerpt') }}</textarea>
                <div class="mt-2 flex items-center justify-between text-sm">
                  <p class="text-gray-500 dark:text-gray-400">Recommended: 160 characters maximum</p>
                  <p x-text="charCount + '/160'" 
                     :class="{ 'text-red-500': charCount > 160, 'text-gray-500': charCount <= 160 }"
                     class="dark:text-gray-400"></p>
                </div>
              </div>
            </div>

            <!-- Content Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
              <div class="p-6">
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                  Content <span class="text-red-500">*</span>
                </label>
                <textarea id="content" 
                         name="content"
                         class="w-full">{{ old('content') }}</textarea>
              </div>
            </div>
          </div>

          <!-- Sidebar -->
          <div class="w-full lg:w-1/3 order-1 lg:order-2 space-y-6">
            <x-admin.sidebar-admin :categories="$categories" />

            <!-- Submit Button Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 sticky top-6">
              <div class="p-6">
                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-sm transition duration-150 ease-in-out flex items-center justify-center">
                  <x-lucide-plus class="w-5 h-5 mr-2" />
                  Create Article
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  @push('scripts')
  <script>
    // Initialize TinyMCE
    tinymce.init({
      selector: '#content',
      height: 500,
      plugins: 'link image code table lists media',
      toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
      content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }',
      menubar: false,
      branding: false,
      skin: document.documentElement.classList.contains('dark') ? 'oxide-dark' : 'oxide',
      content_css: document.documentElement.classList.contains('dark') ? 'dark' : 'default'
    });
  </script>
  @endpush
</x-admin-layout>