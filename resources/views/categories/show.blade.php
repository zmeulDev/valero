<!-- resources/views/categories/show.blade.php -->

<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $category->name }}
      </h2>
      <a href="{{ route('categories.index') }}"
        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring focus:ring-gray-100 active:bg-gray-400 disabled:opacity-25 transition">
        {{ __('Back to Categories') }}
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

        <div class="mb-4">
          <x-label value="{{ __('Name') }}" />
          <div class="text-gray-700">
            {{ $category->name }}
          </div>
        </div>

        <div class="mb-4">
          <x-label value="{{ __('Slug') }}" />
          <div class="text-gray-700">
            {{ $category->slug }}
          </div>
        </div>

        <div class="flex items-center mt-6">
          <a href="{{ route('categories.edit', $category->slug) }}"
            class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 focus:outline-none focus:ring focus:ring-yellow-200 active:bg-yellow-700 disabled:opacity-25 transition">
            {{ __('Edit Category') }}
          </a>
          <form action="{{ route('categories.destroy', $category->slug) }}" method="POST" class="inline-block ml-2"
            onsubmit="return confirm('{{ __('Are you sure you want to delete this category?') }}');">
            @csrf
            @method('DELETE')
            <button type="submit"
              class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:outline-none focus:ring focus:ring-red-200 active:bg-red-700 disabled:opacity-25 transition">
              {{ __('Delete Category') }}
            </button>
          </form>
        </div>

      </div>

    </div>
  </div>
</x-app-layout>