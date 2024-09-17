<x-admin-layout>
    <x-slot name="title">View Article</x-slot>
    <h1 class="text-3xl font-bold mb-4">{{ $article->title }}</h1>

    <!-- Display the Featured Image -->
    @if($article->featured_image)
        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Featured Image" class="mb-4" style="max-width: 100%;">
    @endif

    <!-- Display the Excerpt -->
    @if($article->excerpt)
        <p class="text-gray-600 mb-4">{{ $article->excerpt }}</p>
    @endif

    <!-- Display the Article Content -->
    <div class="prose">
        {!! nl2br(e($article->content)) !!}
    </div>

    <!-- Display the Gallery Images -->
    @if($article->images->count())
        <div class="mt-6">
            <h2 class="text-2xl font-bold mb-4">Gallery Images</h2>
            <div class="grid grid-cols-3 gap-4">
                @foreach($article->images as $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image" class="w-full h-auto object-cover">
                @endforeach
            </div>
        </div>
    @endif

    <!-- Back to Articles List -->
    <a href="{{ route('admin.articles.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">Back to Articles</a>
</x-admin-layout>

