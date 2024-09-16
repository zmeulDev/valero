<!-- resources/views/posts/show.blade.php -->

<x-app-layout>
    <div class="py-8 bg-white">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            <!-- Post Title -->
            <h1 class="text-4xl font-bold leading-tight text-center mb-6 text-gray-900">
                {{ $post->title }}
            </h1>

            <!-- Featured Image -->
            @if($post->image)
            <div class="flex justify-center mb-8">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full md:w-3/4 lg:w-2/3 rounded-lg shadow-lg">
            </div>
            @endif

            <!-- Post Content -->
            <article class="prose lg:prose-xl max-w-none mx-auto text-gray-900">
                {!! $post->content !!}
            </article>

            <!-- Category -->
            <div class="text-center mt-6">
                <span class="inline-block bg-gray-200 text-gray-700 text-xs font-semibold tracking-wider px-4 py-2 rounded-md">
                    Category: {{ $post->category->name }}
                </span>
            </div>

            <!-- Back to Posts Link -->
            <div class="flex justify-center mt-8">
                <a href="{{ route('posts.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg shadow-sm hover:bg-gray-300 focus:outline-none focus:ring focus:ring-gray-100 active:bg-gray-400 transition">
                    {{ __('Back to Posts') }}
                </a>
            </div>

            <!-- Edit and Delete Actions -->
            <div class="flex justify-center space-x-4 mt-8">
                <a href="{{ route('posts.edit', $post->slug) }}"
                    class="px-6 py-3 bg-blue-500 text-white rounded-md font-medium text-sm hover:bg-blue-600">
                    {{ __('Edit Post') }}
                </a>

                <form action="{{ route('posts.destroy', $post->slug) }}" method="POST"
                    onsubmit="return confirm('{{ __('Are you sure you want to delete this post?') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-6 py-3 bg-red-500 text-white rounded-md font-medium text-sm hover:bg-red-600">
                        {{ __('Delete Post') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
