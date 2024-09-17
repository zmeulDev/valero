<x-admin-layout>
    <x-slot name="title">Manage articles</x-slot>
    <h1 class="text-3xl font-bold mb-6">Manage Articles</h1>

    <a href="{{ route('admin.articles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">Create New Article</a>

    @if($articles->isEmpty())
        <p>No articles found.</p>
    @else
        <table class="w-full bg-white shadow-lg rounded-lg">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Title</th>
                    <th class="border px-4 py-2">Author</th>
                    <th class="border px-4 py-2">Created At</th>
                    <th class="border px-4 py-2">Scheduled At</th>
                    <th class="border px-4 py-2">Category</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                    <tr>
                        <td class="border px-4 py-2">{{ $article->title }}</td>
                        <td class="border px-4 py-2">{{ $article->user->name }}</td>
                        <td class="border px-4 py-2">{{ $article->created_at }}</td>
                        <td class="border px-4 py-2">{{ $article->scheduled_at }}</td>
                        <td class="border px-4 py-2">{{ $article->category->name ?? 'N/A' }}</td>
                        <td class="border px-4 py-2">
                            <!-- View Article -->
                            <a href="{{ route('admin.articles.show', $article->id) }}" class="text-blue-600 hover:underline">Preview | </a>

                            <!-- Edit Article -->
                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="text-blue-600 hover:underline">Edit | </a>

                            <!-- Delete Article -->
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this article?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

<!-- Pagination -->
 {{ $articles->links() }}
</x-admin-layout>

