@extends('layouts.admin')

@section('title', 'Edit Article')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Edit Article</h1>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-6">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-4">
            <label class="block font-bold mb-2">Title</label>
            <input type="text" name="title" class="w-full p-2 border" value="{{ old('title', $article->title) }}" required>
        </div>

        <!-- Excerpt -->
        <div class="mb-4">
            <label class="block font-bold mb-2">Excerpt</label>
            <textarea name="excerpt" class="w-full p-2 border">{{ old('excerpt', $article->excerpt) }}</textarea>
        </div>

        <!-- Content -->
        <div class="mb-4">
            <label class="block font-bold mb-2">Content</label>
            <textarea name="content" class="w-full p-2 border" rows="10" required>{{ old('content', $article->content) }}</textarea>
        </div>

        <!-- Featured Image -->
        <div class="mb-4">
            <label class="block font-bold mb-2">Featured Image</label>
            @if($article->featured_image)
                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Featured Image" class="mb-2" style="max-width: 200px;">
            @endif
            <input type="file" name="featured_image" accept="image/*">
        </div>

        <!-- Gallery Images -->
        <div class="mb-4">
            <label class="block font-bold mb-2">Gallery Images</label>
            <input type="file" name="gallery_images[]" accept="image/*" multiple>
        </div>

        <!-- Existing Gallery Images -->
        @if($article->images->count())
            <div class="mb-4">
                <label class="block font-bold mb-2">Existing Gallery Images</label>
                <div class="flex flex-wrap">
                    @foreach($article->images as $image)
                        <div class="relative mr-4 mb-4">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image" style="max-width: 100px;">
                            <form action="{{ route('admin.articles.destroyImage', $image->id) }}" method="POST" class="absolute top-0 right-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 text-white px-1 rounded" onclick="return confirm('Delete this image?');">X</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Scheduled Publish Date -->
        <div class="mb-4">
            <label class="block font-bold mb-2">Scheduled Publish Date</label>
            <input type="datetime-local" name="scheduled_at" class="w-full p-2 border" 
    value="{{ old('scheduled_at', $article->scheduled_at ? \Carbon\Carbon::parse($article->scheduled_at)->format('Y-m-d\TH:i') : '') }}">

            </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Article</button>
    </form>
@endsection
