<x-admin-layout>
    <x-slot name="title">Admin Dashboard</x-slot>

    <div class="bg-gray-100 min-h-screen py-12">
        <div class="container mx-auto px-4 lg:px-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-8">Admin Dashboard</h1>

            <!-- Dashboard statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2 text-gray-800">Total Articles</h2>
                        <p class="text-3xl font-bold text-indigo-600">{{ $articleCount }}</p>
                    </div>
                </div>

                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2 text-gray-800">Total Users</h2>
                        <p class="text-3xl font-bold text-green-600">{{ $userCount }}</p>
                    </div>
                </div>

                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold mb-2 text-gray-800">Recent Activity</h2>
                        <p class="text-gray-600">No recent activities.</p>
                    </div>
                </div>
            </div>

            <!-- Latest articles section -->
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-4 text-gray-800">Latest Articles</h2>

                    @if ($articles->isEmpty())
                        <p class="text-gray-600">No articles found.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published At</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thumbnail</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($articles as $article)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $article->category->name ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $article->title }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ $article->user->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ $article->created_at->format('Y-m-d') }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($article->featured_image)
                                                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="h-10 w-10 rounded-full object-cover">
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">No Image</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.articles.show', $article->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">View</a>
                                                <a href="{{ route('admin.articles.edit', $article->id) }}" class="text-green-600 hover:text-green-900 mr-2">Edit</a>
                                                <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this article?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>