@if($article->media->count() > 0)
<div class="mt-12">
    {{-- Section Header --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                <x-lucide-images class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
            </div>
            <div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ __('frontend.article.gallery') }}
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $article->media->count() }} {{ $article->media->count() === 1 ? 'image' : 'images' }} • Click to view full size
                </p>
            </div>
        </div>
    </div>

    {{-- Gallery Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
        @foreach($article->media as $index => $image)
        <div class="group relative aspect-square overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800 cursor-pointer transition-all duration-300 hover:shadow-xl hover:shadow-indigo-500/20 hover:scale-[1.02] gallery-image" data-index="{{ $index }}">
            {{-- Image --}}
            <img 
                src="{{ asset('storage/' . $image->image_path) }}" 
                alt="{{ $image->alt_text ?? __('frontend.article.gallery_image') }}"
                @if($image->dimensions)
                    width="{{ $image->dimensions['width'] ?? 400 }}"
                    height="{{ $image->dimensions['height'] ?? 400 }}"
                @endif
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 pointer-events-none"
                loading="lazy"
            >
            
            {{-- Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between">
                    <span class="text-white text-sm font-medium">
                        {{ $index + 1 }} / {{ $article->media->count() }}
                    </span>
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-white/20 backdrop-blur-sm rounded-lg">
                            <x-lucide-maximize-2 class="w-4 h-4 text-white" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cover Badge --}}
            @if($image->is_cover)
            <div class="absolute top-3 right-3 px-2 py-1 bg-indigo-600 text-white text-xs font-semibold rounded-lg shadow-lg backdrop-blur-sm pointer-events-none">
                Cover
            </div>
            @endif

            {{-- Ripple Effect on Click --}}
            <div class="absolute inset-0 pointer-events-none">
                <div class="absolute inset-0 rounded-xl opacity-0 group-active:opacity-100 group-active:animate-ping bg-white/30"></div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Gallery Instructions (Mobile) --}}
    <div class="mt-4 flex items-center justify-center gap-2 text-sm text-gray-500 dark:text-gray-400 md:hidden">
        <x-lucide-hand class="w-4 h-4" />
        <span>Tap any image to view • Swipe to navigate</span>
    </div>
</div>
@endif