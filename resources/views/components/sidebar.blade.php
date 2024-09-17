<aside class="prose lg:col-span-1 space-y-8">
    <!-- Popular Articles Section -->
    <div class=" bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-xl font-bold mb-4">Popular Articles</h3>
        <ul class="space-y-2">
            @foreach ($popularArticles as $popular)
                <li>
                    <a href="{{ route('articles.show', $popular->slug) }}" class="text-blue-600 hover:underline">{{ $popular->title }}</a>
                    <p class="text-sm text-gray-500">{{ $popular->views }} {{ Str::plural('view', $popular->views) }}</p>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Categories Section -->
    <div class=" bg-white shadow-lg rounded-lg p-6">
        <h3 class="text-xl font-bold mb-4">Categories</h3>
        <ul class="space-y-2">
            @foreach ($categories as $category)
                <li>
                    <a href="{{ route('category.articles', $category->slug) }}" class="text-gray-700 hover:text-blue-600">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</aside>