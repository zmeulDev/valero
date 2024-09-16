<!-- resources/views/posts/index.blade.php -->

<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Posts') }}
      </h2>
      <a href="{{ route('posts.create') }}"
        class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200 active:bg-blue-700 disabled:opacity-25 transition">
        {{ __('Create New Post') }}
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      @if(session('success'))
      <div class="mb-4 font-medium text-sm text-green-600">
        {{ session('success') }}
      </div>
      @endif

      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        @if($posts->count())
        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th
                class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Image') }}
              </th>
              <th
                class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Title') }}
              </th>
              <th
                class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Category') }}
              </th>
              <th
                class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Published') }}
              </th>
              <th class="px-6 py-3 border-b border-gray-200">
                {{ __('Actions') }}
              </th>
            </tr>
          </thead>
          <tbody class="bg-white">
            @foreach($posts as $post)
            <tr>
            <!-- Image Avatar -->
        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-20 h-20 rounded-xl object-cover">
            @else
                <img src="{{ asset('images/default-avatar.jpg') }}" alt="Default Image" class="w-20 h-20 rounded-xl object-cover">
            @endif
        </td>   
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                {{ $post->title }}
              </td>
              <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                {{ $post->category->name }}
              </td>
              <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                {{ $post->is_published }}
              </td>
              <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
               
                <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-600 hover:text-blue-900">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>

               
                  <a href="{{ route('posts.edit', $post->slug) }}" class="ml-2 text-yellow-600 hover:text-yellow-900">
                    <i class="fas fa-edit"></i>
                  </a>
                <form action="{{ route('posts.destroy', $post->slug) }}" method="POST" class="inline-block ml-2"
                  onsubmit="return confirm('{{ __('Are you sure you want to delete this post?') }}');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('{{ __('Are you sure you want to delete this post?') }}');">
                      <i class="fas fa-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <div class="p-6 bg-white border-b border-gray-200">
          {{ __('No posts found.') }}
        </div>
        @endif
        
      </div>
      <!-- Pagination -->
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
    </div>
  </div>
</x-app-layout>