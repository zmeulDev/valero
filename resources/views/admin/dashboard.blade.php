<x-admin-layout>
  <x-slot name="title">Admin Dashboard</x-slot>

  <div class="bg-gray-100 min-h-screen py-12">
    <div class="container mx-auto px-4 lg:px-8">
      <h1 class="text-4xl font-bold text-gray-900 mb-8 flex items-center">
        <x-lucide-activity class="w-10 h-10 mr-2 text-indigo-600" />
        Admin Dashboard
      </h1>

      <!-- Dashboard statistics -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <div class="px-4 py-5 sm:p-6">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
              <x-lucide-book-text class="w-6 h-6 mr-2 text-indigo-600" />
              Total Articles
            </h2>
            <p class="mt-2 text-3xl font-bold text-indigo-600">{{ $articleCount }}</p>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <div class="px-4 py-5 sm:p-6">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
              <x-lucide-users class="w-6 h-6 mr-2 text-green-600" />
              Total Users
            </h2>
            <p class="mt-2 text-3xl font-bold text-green-600">{{ $userCount }}</p>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
          <div class="px-4 py-5 sm:p-6">
            <h2 class="text-xl font-semibold text-gray-800 flex items-center">
              <x-lucide-clock class="w-6 h-6 mr-2 text-blue-600" />
              Recent Activity
            </h2>
            <p class="mt-2 text-gray-600">No recent activities.</p>
          </div>
        </div>
      </div>

      <!-- Latest articles section -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
          <h2 class="text-2xl font-semibold text-gray-800 mb-4 flex items-center">
            <x-lucide-newspaper class="w-8 h-8 mr-2 text-indigo-600" />
            Latest Articles
          </h2>
          @if ($articles->isEmpty())
          <p class="text-gray-600">No articles found.</p>
          @else
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Published
                    At</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thumbnail
                  </th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($articles as $article)
                <tr>
                  <td class="px-6 py-4 whitespace-nowrap">{{ $article->category->name ?? 'N/A' }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ $article->title }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ $article->user->name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">{{ $article->created_at->format('Y-m-d') }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    @if($article->featured_image)
                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
                      class="h-10 w-10 rounded-full object-cover">
                    @else
                    <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                      <x-lucide-camera class="w-4 h-4 mr-1" />
                      No Image
                    </span>
                    @endif
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-2">
                      <a href="{{ route('admin.articles.show', $article->id) }}"
                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150"
                        title="View">
                        <x-lucide-eye class="w-5 h-5" />
                      </a>
                      <a href="{{ route('admin.articles.edit', $article->id) }}"
                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150"
                        title="Edit">
                        <x-lucide-pencil class="w-5 h-5" />
                      </a>
                      <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST"
                        class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                          class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-100 text-red-600 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150"
                          onclick="return confirm('Are you sure you want to delete this article?')" title="Delete">
                          <x-lucide-trash class="w-5 h-5" />
                        </button>
                      </form>
                    </div>
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