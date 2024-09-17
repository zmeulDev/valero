<x-admin-layout>
    <x-slot name="title">View Article</x-slot>

    <h1 class="text-4xl font-semibold mb-6">{{ $article->title }}</h1>

    <!-- Display the Featured Image -->
    @if($article->featured_image)
        <div class="mb-6">
            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Featured Image" class="w-full rounded-lg shadow-md">
        </div>
    @endif

    <!-- Display the Excerpt -->
    @if($article->excerpt)
        <p class="text-gray-700 text-lg mb-6">{{ $article->excerpt }}</p>
    @endif

    <!-- Display the Article Content -->
    <div class="prose lg:prose-xl max-w-none mb-6">
        {!! nl2br(e($article->content)) !!}
    </div>

    <!-- Display the Gallery Images -->
    @if($article->images->count())
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Gallery Images</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($article->images as $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image" class="w-full h-auto rounded-lg shadow-md object-cover">
                @endforeach
            </div>
        </div>
    @endif

    <!-- Back to Articles List -->
    <a href="{{ route('admin.articles.index') }}" class="mt-8 inline-block text-blue-600 hover:underline">Back to Articles</a>
</x-admin-layout>
