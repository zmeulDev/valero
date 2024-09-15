<!-- resources/views/categories/index.blade.php -->

<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Categories') }}
      </h2>
      <a href="{{ route('categories.create') }}"
        class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-200 active:bg-blue-700 disabled:opacity-25 transition">
        {{ __('Create New Category') }}
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
        @if($categories->count())
        <table class="min-w-full bg-white">
          <thead>
            <tr>
              <th
                class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Name') }}
              </th>
              <th
                class="px-6 py-3 border-b border-gray-200 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Slug') }}
              </th>
              <th class="px-6 py-3 border-b border-gray-200">
                {{ __('Actions') }}
              </th>
            </tr>
          </thead>
          <tbody class="bg-white">
            @foreach($categories as $category)
            <tr>
              <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                {{ $category->name }}
              </td>
              <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                {{ $category->slug }}
              </td>
              <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                <x-button>
                  <a href="{{ route('categories.show', $category->slug) }}" class="text-blue-600 hover:text-blue-900">
                    {{ __('View') }}
                  </a>
                </x-button>
                <x-button>
                  <a href="{{ route('categories.edit', $category->slug) }}"
                    class="ml-2 text-yellow-600 hover:text-yellow-900">
                    {{ __('Edit') }}
                  </a>
                </x-button>
                <form action="{{ route('categories.destroy', $category->slug) }}" method="POST"
                  class="inline-block ml-2"
                  onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}');">
                  @csrf
                  @method('DELETE')
                  <x-button type="submit" class="text-red-600 hover:text-red-900">
                    {{ __('Delete') }}
                  </x-button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @else
        <div class="p-6 bg-white border-b border-gray-200">
          {{ __('No categories found.') }}
        </div>
        @endif
      </div>
    </div>
  </div>
</x-app-layout>