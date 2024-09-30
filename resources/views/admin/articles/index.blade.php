<x-admin-layout>
  <x-slot name="title">Articles</x-slot>

  <div x-data="{ 
        showDeleteModal: false, 
        articleToDelete: null,
        openDeleteModal(articleId) {
            this.showDeleteModal = true;
            this.articleToDelete = articleId;
        }
    }" class="bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="mb-8 sm:flex sm:items-center sm:justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Articles</h1>
          <p class="mt-2 text-sm text-gray-600">Manage your content articles</p>
        </div>
        <div class="mt-4 sm:mt-0">
          <x-button-action href="{{ route('admin.articles.create') }}">
            <x-lucide-plus class="w-4 h-4 mr-2" />
            Add Article
          </x-button-action>
        </div>
      </div>

      <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200 bg-gray-50">
          <h2 class="text-lg font-medium text-gray-900">All Articles</h2>
        </div>
        @if ($articles->isEmpty())
        <x-nothing-found />
        @else
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Thumbnail</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Title</th>
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                  Author</th>
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                  Created At</th>
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                  Scheduled At</th>
                <th scope="col"
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden xl:table-cell">
                  Category</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($articles as $article)
              <tr>
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
                  <div class="text-sm font-medium text-gray-900">{{ $article->title }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                  <div class="text-sm text-gray-900">{{ $article->user->name }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                  <div class="text-sm text-gray-900">{{ $article->created_at->format('M d, Y') }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                  <div class="text-sm text-gray-900">{{ $article->scheduled_at ?? 'Published' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap hidden xl:table-cell">
                  <div class="text-sm text-gray-900">{{ $article->category->name ?? 'N/A' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <a href="{{ route('admin.articles.show', $article->id) }}"
                      class="text-indigo-600 hover:text-indigo-900">Preview</a>
                    <a href="{{ route('admin.articles.edit', $article->id) }}"
                      class="text-blue-600 hover:text-blue-900">Edit</a>
                    <button @click.prevent="openDeleteModal({{ $article->id }})"
                      class="text-red-600 hover:text-red-900">Delete</button>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif
      </div>
      <div class="mt-4">
        {{ $articles->links() }}
      </div>
    </div>

    <!-- Custom Delete Confirmation Modal -->
    <div x-show="showDeleteModal" class="fixed inset-0 overflow-y-auto z-50" x-cloak>
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
          x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
          x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
          class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
          x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
          x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
              <div
                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                  stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
              </div>
              <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                  Delete Article?
                </h3>
                <div class="mt-2">
                  <p>Are you sure you want to delete this article?</p>
                </div>
              </div>
            </div>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <form x-bind:action="'/admin/articles/' + articleToDelete" method="POST" class="w-full sm:w-auto">
              @csrf
              @method('DELETE')
              <button type="submit"
                class="w-full sm:w-auto inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:text-sm">
                Delete
              </button>
            </form>
            <button @click="showDeleteModal = false" type="button"
              class="mt-3 sm:mt-0 w-full sm:w-auto inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-admin-layout>