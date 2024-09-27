<x-admin-layout>
  <x-slot name="title">Admin Dashboard</x-slot>

  <div class="bg-gray-100 min-h-screen py-12">
    <div class="container mx-auto px-4 lg:px-8">
      <h1 class="text-4xl font-bold text-gray-900 mb-8">Admin Dashboard</h1>

      <!-- Dashboard statistics -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white border border -2 shadow-xs rounded-lg overflow-hidden">
          <div class="p-6">
            <h2 class="text-xl font-semibold mb-2 text-gray-800">Total Articles</h2>
            <p class="text-3xl font-bold text-indigo-600">{{ $articleCount }}</p>
          </div>
        </div>

        <div class="bg-white border border -2 shadow-xs rounded-lg overflow-hidden">
          <div class="p-6">
            <h2 class="text-xl font-semibold mb-2 text-gray-800">Total Users</h2>
            <p class="text-3xl font-bold text-green-600">{{ $userCount }}</p>
          </div>
        </div>

        <div class="bg-white border border -2 shadow-xs rounded-lg overflow-hidden">
          <div class="p-6">
            <h2 class="text-xl font-semibold mb-2 text-gray-800">Total views</h2>
            <p class="text-3xl font-bold text-blue-600">{{ $totalViews }}</p>
          </div>
        </div>
      </div>

      <!-- Latest articles section -->

      <div class="bg-white border border -2 shadow-xs rounded-lg overflow-hidden">
        <div class="p-6 mx-4">
          <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold mb-4 text-gray-800">Latest Articles</h2>
            <p>
              <a href="{{ route('admin.articles.index') }}"
                class="text-blue-600 hover:text-blue-800 mb-4 inline-block">View
                All</a>
            </p>
          </div>
          @if ($articles->isEmpty())
          <p class="text-gray-600">No articles found.</p>
          @else
          <div class="relative overflow-x-auto sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Image</th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Category</th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Title</th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Author</th>
                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Published At</th>

                  <th scope="col"
                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($articles as $article)
                <tr
                  class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td class="px-6 py-4 whitespace-nowrap">
                    @if($article->featured_image)
                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
                      class="h-10 w-10 rounded-full object-cover">
                    @else
                    <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">No
                      Image</span>
                    @endif
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">
                      {{ $article->category->name ?? 'N/A' }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">{{ $article->title }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">{{ $article->user->name }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-500">{{ $article->created_at->format('Y-m-d') }}
                    </div>
                  </td>

                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('admin.articles.edit', $article->id) }}"
                      class="text-green-600 hover:text-green-900 mr-2">Edit</a>
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