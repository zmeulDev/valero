<div class="relative mb-8">
  <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
    class="w-full h-[400px] object-cover rounded-lg">
  <div class="absolute bottom-6 left-6 text-gray-300 bg-black bg-opacity-90  rounded-lg shadow-xs p-4">
    <div class="flex items-center text-gray-300">
      <img src="{{ $article->user->profile_photo_url }}" alt="{{ $article->user->name }}"
        class="w-16 h-16 rounded-lg border-2 border-white mr-4">
      <div class="flex flex-col">
        <span class="font-bold text-md">{{ $article->user->name }}</span>
        
        <div class="text-sm text-gray-400 mb-2">{{ $readingTime }} min read</div>
        <div class="text-sm text-white text-center inline-block bg-blue-500 rounded-lg px-2">{{ $article->category->name }}</div>
      </div>
    </div>
    <div class="mt-2 text-xs text-gray-300">
      <span>Updated: {{ $article->updated_at->format('M d, Y') }}</span>
    </div>
  </div>
</div>