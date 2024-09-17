<x-app-layout>
    <x-slot name="title">Article</x-slot>
    <h1 class="text-4xl font-extrabold mb-10 text-center text-gray-900">{{ $category->name }} Articles</h1>

    @if ($articles->isEmpty())
        <p class="text-gray-500 text-center">No articles found in this category.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($articles as $article)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-200">
                    <!-- Article Thumbnail -->
                    @if ($article->featured_image)
                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                    @else
                        <img src="{{ asset('default-featured-image.jpg') }}" alt="Default Image" class="w-full h-48 object-cover">
                    @endif

                    <!-- Article Content -->
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2 hover:text-blue-600 transition-colors duration-150">
                            <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                        </h2>

                        <p class="text-gray-700 mb-4">{{ Str::limit($article->excerpt, 120, '...') }}</p>
                        <p class="text-sm text-gray-500 mb-2">{{ $article->views }} {{ Str::plural('view', $article->views) }} · {{ $article->created_at->format('M d, Y') }}</p>

                        <a href="{{ route('articles.show', $article->slug) }}" class="text-blue-600 font-semibold hover:underline">Read More</a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $articles->links() }}
        </div>
    @endif
</x-app-layout>
