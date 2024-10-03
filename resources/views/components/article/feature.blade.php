<div class="relative mb-8">
  <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
    class="w-full h-[400px] object-cover">
  <div class="absolute bottom-6 left-6">
    <div class="flex items-center text-sm bg-black bg-opacity-75 text-white rounded-full px-4 py-2">
      <img src="{{ $article->user->profile_photo_url }}" alt="{{ $article->user->name }}"
        class="w-8 h-8 rounded-full mr-3">
      <span>{{ $article->user->name }}</span>
      <span class="mx-2">·</span>
      <span>Update: {{ $article->updated_at->format('M d, Y') }}</span>
      <span class="mx-2">·</span>
      <span>{{ $readingTime }} min read</span>
    </div>
  </div>
</div>