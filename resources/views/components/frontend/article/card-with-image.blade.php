@props(['article', 'loading' => 'lazy', 'fetchpriority' => 'auto'])
@php
    $coverMedia = $article->media->firstWhere('is_cover', true);
@endphp
@if($coverMedia?->image_path ?? false)
    <img src="{{ asset('storage/' . $coverMedia->image_path) }}"
        alt="{{ $article->title }}"
        @if($coverMedia->dimensions)
            width="{{ $coverMedia->dimensions['width'] ?? 600 }}"
            height="{{ $coverMedia->dimensions['height'] ?? 338 }}"
        @endif
        class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
        loading="{{ $loading }}"
        fetchpriority="{{ $fetchpriority }}"
        decoding="async"
    >
@endif