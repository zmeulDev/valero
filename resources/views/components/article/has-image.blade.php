@props(['article'])
<img src="{{ asset('storage/' . $article->media->firstWhere('is_cover', true)->image_path) }}" 
alt="{{ $article->title }}"
class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
loading="lazy" >