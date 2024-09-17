<x-app-layout>
    <x-slot name="title">Blog</x-slot>
    <!-- Featured Article Section -->
    <section class="mb-12">
        @if ($featuredArticle)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $featuredArticle->featured_image) }}" alt="{{ $featuredArticle->title }}" class="w-full h-96 object-cover">
                <div class="p-6">
                    <h1 class="text-4xl font-extrabold mb-4 hover:text-blue-600 transition-colors duration-150">
                        <a href="{{ route('articles.show', $featuredArticle->slug) }}">{{ $featuredArticle->title }}</a>
                    </h1>
                    <p class="text-gray-600 mb-4">{{ Str::limit($featuredArticle->excerpt, 200, '...') }}</p>
                    <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="text-blue-600 font-semibold hover:underline">Read More</a>
                </div>
            </div>
        @endif
    </section>

    <!-- Main Article Grid and Sidebar -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">
        
        <!-- Main Article Content (3 columns on large screens) -->
        <div class="lg:col-span-3 space-y-8">
            <h2 class="text-2xl font-bold mb-6">Latest Articles</h2>
            
            <!-- Loop through the articles -->
            @if ($articles->isEmpty())
                <p class="text-gray-500">No articles found.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach ($articles as $article)
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-200">
                            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-900 mb-2 hover:text-blue-600 transition-colors duration-150">
                                    <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                </h2>
                                <p class="text-gray-700 mb-4">{{ Str::limit($article->excerpt, 120, '...') }}</p>
                                <div class="text-sm text-gray-500 mb-2">{{ $article->views }} {{ Str::plural('view', $article->views) }} · {{ $article->created_at->format('M d, Y') }}</div>
                                 <a href="{{ route('articles.show', $article->slug) }}" class="inline-block px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition ease-in-out duration-150">
                                    Read More
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>

        <!-- Sidebar (Component) -->
        <x-sidebar :popularArticles="$popularArticles" :categories="$categories" />
    
    </div>
</x-app-layout>
