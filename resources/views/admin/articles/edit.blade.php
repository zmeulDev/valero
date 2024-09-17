<x-admin-layout>
    <x-slot name="title">Edit Article</x-slot>

    <h1 class="text-4xl font-semibold mb-6">Edit Article</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-600 px-4 py-3 rounded mb-6">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Title</label>
            <input type="text" name="title" class="w-full p-3 border border-gray-300 rounded focus:ring focus:ring-blue-200" value="{{ old('title', $article->title) }}" required>
        </div>

        <!-- Excerpt -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Excerpt</label>
            <textarea name="excerpt" class="w-full p-3 border border-gray-300 rounded focus:ring focus:ring-blue-200" rows="4">{{ old('excerpt', $article->excerpt) }}</textarea>
        </div>

        <!-- Category Select -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Category</label>
            <select name="category_id" class="w-full p-3 border border-gray-300 rounded focus:ring focus:ring-blue-200" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Content -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Content</label>
            <textarea name="content" class="w-full p-3 border border-gray-300 rounded focus:ring focus:ring-blue-200" rows="10" required>{{ old('content', $article->content) }}</textarea>
        </div>

        <!-- Featured Image -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Featured Image</label>
            @if($article->featured_image)
                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Featured Image" class="mb-2 rounded shadow-md" style="max-width: 200px;">
            @endif
            <input type="file" name="featured_image" accept="image/*" class="block w-full text-gray-700">
        </div>

        <!-- Gallery Images -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Gallery Images</label>
            <input type="file" name="gallery_images[]" accept="image/*" multiple class="block w-full text-gray-700">
        </div>

            <!-- Existing Gallery Images -->
            @if($article->images->count())
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2">Existing Gallery Images</label>
                    <div class="flex flex-wrap">
                        @foreach($article->images as $image)
                            <div class="relative mr-4 mb-4">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image" class="rounded shadow-md" style="max-width: 100px;">
                                <form action="{{ route('admin.articles.destroyImage', ['article' => $article->id, 'image' => $image->id]) }}" method="POST" class="absolute top-0 right-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-1 rounded hover:bg-red-700 transition" onclick="return confirm('Delete this image?');">X</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        <!-- Scheduled Publish Date -->
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Scheduled Publish Date</label>
            <input type="datetime-local" name="scheduled_at" class="w-full p-3 border border-gray-300 rounded focus:ring focus:ring-blue-200" 
                value="{{ old('scheduled_at', $article->scheduled_at ? \Carbon\Carbon::parse($article->scheduled_at)->format('Y-m-d\TH:i') : '') }}">
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded focus:outline-none focus:ring focus:ring-blue-300 transition ease-in-out duration-150">
            Update Article
        </button>
    </form>
</x-admin-layout>
