<!-- resources/views/posts/show.blade.php -->

<x-app-layout>
  <x-slot name="header">
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ $post->title }}
      </h2>
      <a href="{{ route('posts.index') }}"
        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring focus:ring-gray-100 active:bg-gray-400 disabled:opacity-25 transition">
        {{ __('Back to Posts') }}
      </a>
    </div>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

        <div class="mb-4">
          <x-label value="{{ __('Title') }}" />
          <div class="text-gray-700">
            {{ $post->title }}
          </div>
        </div>

        <div class="mb-4">
          <x-label value="{{ __('Slug') }}" />
          <div class="text-gray-700">
            {{ $post->slug }}
          </div>
        </div>

        <div class="mb-4">
          <x-label value="{{ __('Category') }}" />
          <div class="text-gray-700">
            {{ $post->category->name }}
          </div>
        </div>

        <div class="mb-4">
          <x-label value="{{ __('Content') }}" />
          <div class="text-gray-700">
            {!! nl2br(e($post->content)) !!}
          </div>
        </div>

        @if($post->image)
        <div class="mb-4">
          <x-label value="{{ __('Image') }}" />
          <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-1/2 h-auto">
        </div>
        @endif

        <div class="flex items-center mt-6">
          <x-button>
            <a href="{{ route('posts.edit', $post->slug) }}">
              {{ __('Edit Post') }}
            </a>
          </x-button>
          <form action="{{ route('posts.destroy', $post->slug) }}" method="POST" class="inline-block ml-2"
            onsubmit="return confirm('{{ __('Are you sure you want to delete this post?') }}');">
            @csrf
            @method('DELETE')
            <x-button type="submit">
              {{ __('Delete Post') }}
            </x-button>
          </form>
        </div>

      </div>

    </div>
  </div>
</x-app-layout>