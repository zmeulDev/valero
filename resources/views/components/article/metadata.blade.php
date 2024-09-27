<div class="bg-gray-100 dark:bg-gray-700 rounded-xl mt-6 p-6">
  <div class="flex items-center justify-between">
    <div class="flex items-center">
      <img src="{{ $article->user->profile_photo_url }}" alt="{{ $article->user->name }}"
        class="w-16 h-16 rounded-full mr-4">
      <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $article->user->name }}</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400">Published:
          {{ $article->created_at->format('M d, Y') }}
        </p>
        <p class="text-sm text-gray-600 dark:text-gray-400">Updated:
          {{ $article->created_at->format('M d, Y') }}
        </p>
      </div>
    </div>
    <div
      class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
      {{ $article->category->name ?? 'N/A' }}
    </div>
  </div>
</div>