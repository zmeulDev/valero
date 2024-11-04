<x-admin-layout>
  <x-slot name="header">
    <x-admin.page-header
      icon="book-open"
      title="{{ __('Edit Article') }}"
      description="Update your article content and settings"
      :breadcrumbs="[
        ['label' => 'Articles', 'url' => route('admin.articles.index')],
        ['label' => 'Edit']
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
      <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                       value="{{ old('title', $article->title) }}" 
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
                         maxlength="160">{{ old('excerpt', $article->excerpt) }}</textarea>
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
                         class="w-full">{{ old('content', $article->content) }}</textarea>
              </div>
            </div>
          </div>

          <!-- Sidebar -->
          <div class="w-full lg:w-1/3 order-1 lg:order-2 space-y-6">
            <x-admin.article-sidebar :article="$article" :categories="$categories" />

            <!-- Submit Button Card -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 sticky top-6">
              <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                  <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Last updated: {{ $article->updated_at->diffForHumans() }}</span>
                  <span class="px-3 py-1 text-xs font-medium {{ $article->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }} rounded-full">
                    {{ ucfirst($article->status) }}
                  </span>
                </div>
                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg shadow-sm transition duration-150 ease-in-out flex items-center justify-center">
                  <x-lucide-save class="w-5 h-5 mr-2" />
                  Update Article
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