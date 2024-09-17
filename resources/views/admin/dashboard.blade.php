<x-admin-layout>
    <x-slot name="title"> Admin Dashboard</x-slot>

    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

    <!-- Dashboard statistics -->
    <div class="grid grid-cols-3 gap-6 mb-8">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">Total Articles</h2>
            <p class="text-gray-600 text-lg">{{ $articleCount }}</p>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">Total Users</h2>
            <p class="text-gray-600 text-lg">{{ $userCount }}</p>
        </div>

        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-bold mb-4">Recent Activity</h2>
            <p class="text-gray-600 text-lg">No recent activities.</p>
        </div>
    </div>

    <!-- Latest articles section -->
    <h2 class="text-2xl font-bold mb-4">Latest Articles</h2>

    @if ($articles->isEmpty())
        <p>No articles found.</p>
    @else
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2 text-left">Title</th>
                        <th class="border px-4 py-2 text-left">Author</th>
                        <th class="border px-4 py-2 text-left">Published At</th>
                        <th class="border px-4 py-2">Thumbnail</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <!-- Title and details on the left -->
                            <td class="border px-4 py-4">{{ $article->title }}</td>
                            <td class="border px-4 py-4">{{ $article->user->name }}</td>
                            <td class="border px-4 py-4">{{ $article->created_at->format('Y-m-d') }}</td>

                            <!-- Featured Image Thumbnail -->
                            <td class="border px-4 py-4 text-center">
                                @if($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <img src="{{ asset('default-thumbnail.jpg') }}" alt="No Image" class="w-16 h-16 object-cover rounded-lg">
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="border px-4 py-4 text-center">
                                <!-- View Article -->
                                <a href="{{ route('admin.articles.show', $article->id) }}" class="text-blue-600 hover:underline">View</a>

                                <!-- Edit Article -->
                                <a href="{{ route('admin.articles.edit', $article->id) }}" class="text-blue-600 hover:underline ml-2">Edit</a>
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
