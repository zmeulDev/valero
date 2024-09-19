<x-admin-layout>
  <x-slot name="title">Create New Article</x-slot>

  <h1 class="text-4xl font-semibold mb-6">Create New Article</h1>

  @if ($errors->any())
  <div class="bg-red-100 border border-red-400 text-red-600 px-4 py-3 rounded mb-6">
    <ul class="list-disc pl-5">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Title -->
    <div class="mb-6">
      <label for="title" class="block text-gray-700 font-bold mb-2">
        Title <span id="title-char-count" class="text-gray-600">(0)</span>
      </label>
      <span>Recomanded maximum 60 characthers</span>
      <input type="text" id="title" name="title"
        class="w-full p-3 border border-gray-300 rounded focus:ring focus:ring-blue-200" value="{{ old('title') }}"
        required oninput="updateCharCount('title', 60)">
    </div>

    <!-- Excerpt -->
    <div class="mb-6">
      <label for="excerpt" class="block text-gray-700 font-bold mb-2">
        Excerpt <span id="excerpt-char-count" class="text-gray-600">(0)</span>
      </label>
      <span>Recomanded maximum 160 characthers</span>
      <textarea id="excerpt" name="excerpt"
        class="w-full p-3 border border-gray-300 rounded focus:ring focus:ring-blue-200" rows="3"
        oninput="updateCharCount('excerpt', 160)">{{ old('excerpt') }}</textarea>
    </div>

    <!-- Category Select -->
    <div class=" mb-6">
      <label class="block text-gray-700 font-bold mb-2">Category</label>
      <select name="category_id" class="w-full p-3 border border-gray-300 rounded focus:ring focus:ring-blue-200"
        required>
        <option value="">Select Category</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
          {{ $category->name }}
        </option>
        @endforeach
      </select>
    </div>

    <!-- Content -->
    <div class="mb-6">
      <label for="content" class="block text-gray-700 font-bold mb-2">
        Content <span id="content-char-count" class="text-gray-600">(0)</span>
      </label>
      <textarea id="content" name="content"
        class="w-full p-3 border border-gray-300 rounded focus:ring focus:ring-blue-200" rows="10"
        oninput="updateCharCount('content')">{{ old('content') }}</textarea>
    </div>

    <!-- Featured Image -->
    <div class="mb-6">
      <label class="block text-gray-700 font-bold mb-2">Featured Image</label>
      <input type="file" name="featured_image" accept="image/*" class="block w-full text-gray-700">
    </div>

    <!-- Gallery Images -->
    <div class="mb-6">
      <label class="block text-gray-700 font-bold mb-2">Gallery Images</label>
      <input type="file" name="gallery_images[]" accept="image/*" multiple class="block w-full text-gray-700">
    </div>

    <!-- Scheduled Publish Date -->
    <div class="mb-6">
      <label class="block text-gray-700 font-bold mb-2">Scheduled Publish Date</label>
      <input type="datetime-local" name="scheduled_at"
        class="w-full p-3 border border-gray-300 rounded focus:ring focus:ring-blue-200"
        value="{{ old('scheduled_at') }}">
    </div>

    <!-- Submit Button -->
    <button type="submit"
      class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded focus:outline-none focus:ring focus:ring-blue-300 transition ease-in-out duration-150">
      Create Article
    </button>
  </form>
</x-admin-layout>