@if($article->images->count() > 0)
<div class="mt-12">
  <h3 class="text-2xl font-bold mb-4">Gallery</h3>
  <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
    @foreach($article->images as $index => $image)
    <div class="relative aspect-w-1 aspect-h-1">
      <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image"
        class="object-cover rounded-lg cursor-pointer gallery-image" data-index="{{ $index }}">
    </div>
    @endforeach
  </div>
</div>
@endif