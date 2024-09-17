<x-app-layout>
    <x-slot name="title">{{ $article->title }}</x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">

        <!-- Main Content (3 columns on large screens) -->
        <div class="lg:col-span-3">

            <!-- Article Hero Section -->
            <div class="mb-8 text-center">
                <h1 class="text-4xl font-extrabold leading-tight mb-4">{{ $article->title }}</h1>

                <!-- Author and Metadata -->
                <div class="flex justify-center items-center text-gray-600 mb-6">
                <img src="{{ $article->user->profile_photo_url }}" alt="{{ $article->user->name }}" class="h-12 w-12 rounded-full mr-4">    
                <div>
                        <p class="font-semibold">{{ $article->user->name }}</p>
                        <p class="text-sm">{{ $article->created_at->format('F d, Y') }} · {{ $article->read_time }} min read</p>
                    </div>
                </div>

                <!-- Featured Image with Rounded Corners -->
                @if($article->featured_image)
                    <div class="flex justify-center">
                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-2/3 h-auto rounded-lg shadow-lg mb-8">
                    </div>
                @endif
            </div>

            <!-- Article Content -->
            <div class="prose lg:prose-xl mx-auto text-left">
                {!! nl2br(e($article->content)) !!}
            </div>

        </div>

        <!-- Sidebar (1 column) -->
        <div class="lg:col-span-1 hidden lg:block">
            <div class="sticky top-16">
                <!-- Include Sidebar Component -->
                <x-sidebar :popularArticles="$popularArticles" :categories="$categories" />
            </div>
        </div>

    </div>
</x-app-layout>
