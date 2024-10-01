@props(['categories', 'article'])

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