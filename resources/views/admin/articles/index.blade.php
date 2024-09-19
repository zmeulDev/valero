<x-admin-layout>
    <x-slot name="title">Articles</x-slot>

    <div class="bg-gray-100 min-h-screen py-12">
        <div class="container mx-auto px-4 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-4xl font-bold text-gray-900">Articles</h1>
                <a href="{{ route('admin.articles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-sm transition">Create New Article</a>
            </div>

            @if($articles->isEmpty())
                <p class="text-gray-600">No articles found.</p>
            @else
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <table class="min-w-full table-auto">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 text-left text-sm uppercase font-medium">
                                <th class="px-6 py-3">Thumbnail</th>
                                <th class="px-6 py-3">Title</th>
                                <th class="px-6 py-3">Author</th>
                                <th class="px-6 py-3">Created At</th>
                                <th class="px-6 py-3">Scheduled At</th>
                                <th class="px-6 py-3">Category</th>
                                <th class="px-6 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @foreach ($articles as $article)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        @if($article->featured_image)
                                            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">No Image</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $article->title }}</td>
                                    <td class="px-6 py-4">{{ $article->user->name }}</td>
                                    <td class="px-6 py-4">{{ $article->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4">{{ $article->scheduled_at ?? 'Published' }}</td>
                                    <td class="px-6 py-4">{{ $article->category->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-4">
                                            <!-- View Article -->
                                            <a href="{{ route('admin.articles.show', $article->id) }}" class="text-blue-500 hover:underline">Preview</a>

                                            <!-- Edit Article -->
                                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="text-blue-500 hover:underline">Edit</a>

                                            <!-- Delete Article -->
                                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this article?');">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Pagination -->
            <div class="mt-6">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>
