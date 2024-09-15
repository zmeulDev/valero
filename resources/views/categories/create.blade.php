<!-- resources/views/categories/create.blade.php -->

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Create New Category') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

        @if ($errors->any())
        <div class="mb-4">
          <x-validation-errors />
        </div>
        @endif

        <form action="{{ route('categories.store') }}" method="POST">
          @csrf

          <div class="mb-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name') }}" required
              autofocus />
          </div>

          <div class="mb-4">
            <x-label for="slug" value="{{ __('Slug') }}" />
            <x-input id="slug" class="block mt-1 w-full" type="text" name="slug" value="{{ old('slug') }}" required />
          </div>

          <div class="flex items-center justify-start">
            <x-button>
              {{ __('Create Category') }}
            </x-button>
            <a href="{{ route('categories.index') }}"
              class="ml-4 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring focus:ring-gray-100 active:bg-gray-400 disabled:opacity-25 transition">
              {{ __('Cancel') }}
            </a>
          </div>
        </form>

      </div>

    </div>
  </div>
</x-app-layout>