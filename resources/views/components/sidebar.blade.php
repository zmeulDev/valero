<aside class="lg:col-span-1 space-y-8">
    <!-- Popular Articles Section -->
    <div class="p-6 rounded-lg border-solid border-2">
        <h3 class="text-xl font-semibold mb-4">Popular Articles</h3>
        <ul class="space-y-4">
            @foreach ($popularArticles as $popularArticle)
                <li>
                    <a href="{{ route('articles.show', $popularArticle->slug) }}" class="flex items-center space-x-3">
                        <img src="{{ asset('storage/' . $popularArticle->featured_image) }}" alt="{{ $popularArticle->title }}" class="w-16 h-16 object-cover rounded">
                        <div>
                            <h4 class="font-semibold">{{ $popularArticle->title }}</h4>
                            <p class="text-sm text-gray-500">{{ $popularArticle->created_at->format('F d, Y') }}</p>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Categories Section -->
    <div class="p-6 rounded-lg border-solid border-2">
        <h3 class="text-xl font-semibold mb-4">Categories</h3>
        <ul class="list-disc list-inside">
            @foreach ($categories as $category)
                <li>
                    <a href="{{ route('category.articles', $category->slug) }}" class="text-blue-600 hover:underline">{{ $category->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
</aside>