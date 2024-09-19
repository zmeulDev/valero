<x-admin-layout>
    <x-slot name="title">Create New Article</x-slot>

    <div class="bg-gray-100 min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-6">Create New Article</h1>

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

            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col lg:flex-row gap-8">
                @csrf

                <!-- Main Content -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6 space-y-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                    Title <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="title" name="title"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                    value="{{ old('title') }}" required>
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
                                    rows="3">{{ old('excerpt') }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">Recommended: 160 characters maximum</p>
                                <p class="text-sm text-gray-500">Characters: <span id="excerpt-char-count">0</span></p>
                            </div>

                            <!-- Content (with TinyMCE) -->
                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                                    Content <span class="text-red-500">*</span>
                                </label>
                                <textarea id="content" name="content" class="w-full">{{ old('content') }}</textarea>
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
                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
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
                  <option value="{{ $category->id }}">
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
            </form>
        </div>
    </div>
</x-admin-layout>