<!-- resources/views/dashboard.blade.php -->

<x-app-layout>
    <!-- ... your existing code ... -->

    <div class="bg-gray-200 bg-opacity-25 p-6 lg:p-8">
        @if($posts->count())
        <div class="space-y-8">
            @foreach($posts as $post)
            <!-- Display each post -->
            <div class="bg-white rounded-lg shadow-md flex flex-col md:flex-row overflow-hidden">
                @if($post->image)
                <div class="md:w-1/3">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                        class="object-cover w-full h-full">
                </div>
                @endif
                <div class="p-6 flex flex-col justify-between w-full">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">{{ $post->title }}</h2>
                        <p class="mt-4 text-gray-600">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 150) }}
                        </p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('posts.show', $post->slug) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-white hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200 active:bg-blue-700 transition">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Add pagination links -->
        <div class="mt-6">
            {{ $posts->links() }}
        </div>

        @else
        <p class="text-gray-600">No posts available.</p>
        @endif
    </div>
</x-app-layout>