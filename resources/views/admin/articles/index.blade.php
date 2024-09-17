<x-admin-layout>
    <x-slot name="title">Articles</x-slot>

    <div class="mb-6">
        <h1 class="text-4xl font-semibold mb-4">Articles</h1>
        <a href="{{ route('admin.articles.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md shadow-sm transition">Create New Article</a>
    </div>

    @if($articles->isEmpty())
        <p class="text-gray-600">No articles found.</p>
    @else
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 text-left text-sm uppercase font-medium">
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
                            <td class="px-6 py-4">{{ $article->title }}</td>
                            <td class="px-6 py-4">{{ $article->user->name }}</td>
                            <td class="px-6 py-4">{{ $article->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">{{ $article->scheduled_at ?? 'Not Scheduled' }}</td>
                            <td class="px-6 py-4">{{ $article->category->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 flex items-center space-x-4">
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
</x-admin-layout>
