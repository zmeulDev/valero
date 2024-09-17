<x-admin-layout>
    <x-slot name="title">Create new article</x-slot>
    <h1 class="text-2xl font-bold mb-4">Create New Article</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Title -->
        <div class="mb-4">
            <label class="block font-bold mb-2">Title</label>
            <input type="text" name="title" class="w-full p-2 border" value="{{ old('title') }}" required>
        </div>

        <!-- Excerpt -->
        <div class="mb-4">
            <label class="block font-bold mb-2">Excerpt</label>
            <textarea name="excerpt" class="w-full p-2 border">{{ old('excerpt') }}</textarea>
        </div>

        <!-- Category Select -->
        <div class="mb-4">
            <label class="block font-bold mb-2">Category</label>
            <select name="category_id" class="w-full p-2 border" required>
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Content -->
        <div class="mb-4">
            <label class="block font-bold mb-2">Content</label>
            <textarea name="content" class="w-full p-2 border" rows="10" required>{{ old('content') }}</textarea>
        </div>

        <!-- Featured Image -->
        <div class="mb-4">
            <label class="block font-bold mb-2">Featured Image</label>
            <input type="file" name="featured_image" accept="image/*">
        </div>

        <!-- Gallery Images -->
        <div class="mb-4">
            <label class="block font-bold mb-2">Gallery Images</label>
            <input type="file" name="gallery_images[]" accept="image/*" multiple>
        </div>

        <!-- Scheduled Publish Date -->
        <div class="mb-4">
            <label class="block font-bold mb-2">Scheduled Publish Date</label>
            <input type="datetime-local" name="scheduled_at" class="w-full p-2 border" value="{{ old('scheduled_at') }}">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create Article</button>
    </form>
</x-admin-layout>

