<x-admin-layout>
  <x-slot name="title">Edit Article</x-slot>


  <div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Article</h1>

      @if ($errors->any())
      <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
        <p class="font-bold">Please correct the following errors:</p>
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

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
                    Excerpt
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
            <!-- Scheduled Publish Date -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
              <div class="p-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Scheduled Publish Date</label>
                <input type="datetime-local" name="scheduled_at"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                  value="{{ old('scheduled_at', $article->scheduled_at ? \Carbon\Carbon::parse($article->scheduled_at)->format('Y-m-d\TH:i') : '') }}">
              </div>
            </div>
            <!-- Category Select -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
              <div class="p-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Category <span
                    class="text-red-500">*</span></label>
                <select name="category_id"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                  required>
                  <option value="">Select Category</option>
                  @foreach ($categories as $category)
                  <option value="{{ $category->id }}"
                    {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>

            <!-- Featured Image -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
              <div class="p-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Featured Image</label>
                @if($article->featured_image)
                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Featured Image"
                  class="mb-2 rounded shadow-md" style="max-width: 200px;">
                @endif
                <input type="file" name="featured_image" accept="image/*"
                  class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
              </div>
            </div>

            <!-- Gallery Images -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
              <div class="p-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Gallery Images</label>
                  <input type="file" name="gallery_images[]" accept="image/*" multiple
                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div> 
                <!-- Existing Gallery Images -->
                @if($article->images->count())
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Existing Gallery Images</label>
                  <div class="flex flex-wrap gap-4">
                    @foreach($article->images as $image)
                    <div class="relative">
                      <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image"
                        class="w-32 h-32 object-cover rounded-md">
                      <form
                        action="{{ route('admin.articles.destroyImage', ['article' => $article->id, 'image' => $image->id]) }}"
                        method="POST" class="absolute top-0 right-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white p-1 rounded-full hover:bg-red-700 transition"
                          onclick="return confirm('Delete this image?');">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"></path>
                          </svg>
                        </button>
                      </form>
                    </div>
                    @endforeach
                  </div>
                </div>
                @endif
              </div>
            </div>
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