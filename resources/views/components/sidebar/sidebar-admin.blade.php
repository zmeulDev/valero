@props(['article' => null, 'categories'])

<!-- Scheduled Publish Date -->
<div class="bg-white shadow-md rounded-lg overflow-hidden">
  <div class="p-6">
    <label class="block text-sm font-medium text-gray-700 mb-1">Scheduled Publish Date</label>
    <input type="datetime-local" name="scheduled_at"
      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
      value="{{ old('scheduled_at', $article?->scheduled_at ? \Carbon\Carbon::parse($article->scheduled_at)->format('Y-m-d\TH:i') : '') }}">
  </div>
</div>

<!-- Category Select -->
<div class="bg-white shadow-md rounded-lg overflow-hidden">
  <div class="p-6">
    <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
    <select name="category_id"
      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
      required>
      <option value="">Select Category</option>
      @foreach ($categories as $category)
      <option value="{{ $category->id }}"
        {{ old('category_id', $article?->category_id) == $category->id ? 'selected' : '' }}>
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
    @if($article && $article->featured_image)
    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Featured Image" class="mb-2 rounded shadow-md"
      style="max-width: 200px;">
    @endif
    @if($article)
    <form action="{{ route('admin.articles.featured-image.update', $article) }}" method="POST"
      enctype="multipart/form-data">
      @csrf
      <input type="file" name="featured_image" accept="image/*"
        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
      <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
        Update Featured Image
      </button>
    </form>
    @else
    <input type="file" name="featured_image" accept="image/*"
      class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
    @endif
  </div>
</div>

<!-- Gallery Images -->
<div class="bg-white shadow-md rounded-lg overflow-hidden">
  <div class="p-6">
    <div>
      <label class="block text-lg font-medium text-gray-700 mb-1">Gallery Images</label>
      @if($article)
      <form action="{{ route('admin.articles.images.store', $article) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="images[]" accept="image/*" multiple
          class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
        <button type="submit" class="mt-2 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
          Add Gallery Images
        </button>
      </form>
      @else
      <input type="file" name="images[]" accept="image/*" multiple
        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
      @endif
    </div>

    @if($article && $article->images->count())
    <div class="mt-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Existing Gallery Images</label>
      <div class="flex flex-wrap gap-4">
        @foreach($article->images as $image)
        <div class="relative">
          <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image"
            class="w-32 h-32 object-cover rounded-md">
          <form
            action="{{ route('admin.articles.images.destroy', ['article' => $article->id, 'image' => $image->id]) }}"
            method="POST" class="absolute top-0 right-0">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white p-1 rounded-full hover:bg-red-700 transition"
              onclick="return confirm('Delete this image?');">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
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