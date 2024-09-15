<!-- resources/views/posts/create.blade.php -->

<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Create New Post') }}
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

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="mb-4">
            <x-label for="title" value="{{ __('Title') }}" />
            <x-input id="title" class="block mt-1 w-full" type="text" name="title" value="{{ old('title') }}" required
              autofocus />
          </div>

          <div class="mb-4">
            <x-label for="slug" value="{{ __('Slug') }}" />
            <x-input id="slug" class="block mt-1 w-full" type="text" name="slug" value="{{ old('slug') }}" required />
          </div>

          <div class="mb-4">
            <x-label for="category_id" value="{{ __('Category') }}" />
            <select name="category_id" id="category_id" class="block mt-1 w-full border-gray-300 rounded-md">
              @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
              @endforeach
            </select>
          </div>

          <div class="mb-4">
            <x-label for="content" value="{{ __('Content') }}" />
            <textarea name="content" id="content" rows="5"
              class="block mt-1 w-full border-gray-300 rounded-md">{{ old('content') }}</textarea>
          </div>

          <div class="mb-4">
            <x-label for="image" value="{{ __('Image') }}" />
            <x-input id="image" class="block mt-1 w-full" type="file" name="image" />
          </div>

          <div class="mb-4">

            <input type="checkbox" id="is_published" name="is_published" />
            {{ __('Publish') }}

          </div>

          <div class="flex items-center justify-start">
            <x-button>
              {{ __('Create Post') }}
            </x-button>
            <x-button>
              <a href="{{ route('posts.index') }}">
                {{ __('Cancel') }}
              </a>
            </x-button>
          </div>
        </form>

      </div>

    </div>
  </div>
</x-app-layout>