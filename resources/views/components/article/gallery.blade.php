@if($article->media->count() > 0)
<div class="mt-12">
    {{-- Section Header --}}
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300 bg-clip-text text-transparent">
            Gallery
        </h3>
        <div class="h-[2px] flex-1 bg-gradient-to-r from-gray-200 to-transparent dark:from-gray-700 ml-6"></div>
    </div>
  <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
    @foreach($article->media as $index => $image)
    <div class="relative aspect-square overflow-hidden rounded-lg">
      <img 
        src="{{ asset('storage/' . $image->image_path) }}" 
        alt="{{ $image->alt_text ?? 'Gallery Image' }}"
        class="w-full h-full object-cover cursor-pointer gallery-image hover:opacity-90 transition-opacity duration-300"
        data-index="{{ $index }}"
        loading="lazy"
      >
    </div>
    @endforeach
  </div>
</div>
@endif