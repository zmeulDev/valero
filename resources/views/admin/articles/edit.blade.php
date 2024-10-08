<x-admin-layout>
  <x-slot name="title">Edit Article</x-slot>

  <div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Article</h1>



      <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="flex flex-col lg:flex-row gap-8">
          <!-- Main Content -->
          <div class="w-full lg:w-2/3 order-2 lg:order-1">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
              <div class="p-6 space-y-6">
                <!-- Title -->
                <div>
                  <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                    Title <span class="text-red-500">*</span>
                  </label>
                  <input type="text" id="title" name="title"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ old('title', $article->title) }}" required>
                  <p class="mt-1 text-sm text-gray-500">Recommended: 60 characters maximum</p>
                  <p class="text-sm text-gray-500">Characters: <span id="title-char-count">0</span></p>
                </div>

                <!-- Excerpt -->
                <div>
                  <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">
                    Excerpt (description)
                  </label>
                  <textarea id="excerpt" name="excerpt"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    rows="3">{{ old('excerpt', $article->excerpt) }}</textarea>
                  <p class="mt-1 text-sm text-gray-500">Recommended: 160 characters maximum</p>
                  <p class="text-sm text-gray-500">Characters: <span id="excerpt-char-count">0</span></p>
                </div>

                <!-- Content (with TinyMCE) -->
                <div>
                  <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                    Content <span class="text-red-500">*</span>
                  </label>
                  <textarea id="content" name="content"
                    class="w-full">{{ old('content', $article->content) }}</textarea>
                </div>
              </div>
            </div>
          </div>

          <!-- Sidebar -->
          <div class="w-full lg:w-1/3 order-1 lg:order-2 space-y-6">
            <x-admin.sidebar-admin :article="$article" :categories="$categories" />

            <!-- Submit Button -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
              <div class="p-6">
                <button type="submit"
                  class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-md shadow-sm transition duration-150 ease-in-out">
                  Update Article
                </button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</x-admin-layout>