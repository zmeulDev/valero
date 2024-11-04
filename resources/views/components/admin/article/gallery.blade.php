@props(['categories', 'article'])

<div class="bg-white shadow-md rounded-lg overflow-hidden">
  <div class="p-6">
    <div>
      <label class="block text-lg font-medium text-gray-700 mb-1">Gallery Images</label>
      <input type="file" name="gallery_images[]" accept="image/*" multiple
        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
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
        <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
          Update Gallery Image
        </button>
      </div>
    </div>
    @endif
  </div>
</div>