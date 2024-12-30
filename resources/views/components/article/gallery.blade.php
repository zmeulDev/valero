@if($article->media->count() > 0)
<div class="mt-12">
  <h3 class="text-2xl font-bold mb-4">Gallery</h3>
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