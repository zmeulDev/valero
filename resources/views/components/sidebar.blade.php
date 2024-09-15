<!-- resources/views/components/sidebar.blade.php -->
<div class="md:w-1/4 md:ml-6 mt-6 md:mt-0">
    <div class="bg-white rounded-lg shadow-md p-4">
        @if($categories->count())
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Categories</h2>
        <ul>
            @foreach($categories as $category)
            <li class="mb-2">
                <a href="{{ route('categories.show', $category->slug) }}" class="text-blue-600 hover:underline">
                    {{ $category->name }} ({{ $category->posts_count }})
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </div>
</div>