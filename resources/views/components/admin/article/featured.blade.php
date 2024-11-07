@props(['categories', 'article'])

<div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
  <div class="p-6">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Featured Image</label>
    
    <!-- Image Preview -->
    <div class="mb-4">
        <img 
            src="{{ $article && $article->featured_image ? asset('storage/' . $article->featured_image) : asset('storage/brand/no-image.jpg') }}" 
            alt="{{ $article ? $article->title . ' featured image' : 'Featured image placeholder' }}" 
            class="w-full h-48 object-cover rounded-lg shadow-md"
        >
    </div>

    <!-- Upload Form -->
    @if($article)
        <form action="{{ route('admin.articles.featured-image.update', $article) }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="space-y-3">
            @csrf
            <div class="flex items-center justify-center w-full">
                <label class="w-full flex flex-col items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm cursor-pointer bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <span class="text-sm text-gray-600 dark:text-gray-300">Choose image</span>
                    <input type="file" 
                           name="featured_image" 
                           class="hidden" 
                           accept="image/*">
                </label>
            </div>
            
            <button type="submit" 
                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                Update Featured Image
            </button>
        </form>
    @else
        <div class="flex items-center justify-center w-full">
            <label class="w-full flex flex-col items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm cursor-pointer bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <span class="text-sm text-gray-600 dark:text-gray-300">Choose image</span>
                <input type="file" 
                       name="featured_image" 
                       class="hidden" 
                       accept="image/*">
            </label>
        </div>
    @endif

    <!-- Help Text -->
    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
        Recommended: 1200x630px, max 2MB
    </p>
  </div>
</div>