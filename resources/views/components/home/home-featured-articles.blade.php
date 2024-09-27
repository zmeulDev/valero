<div class="relative bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl overflow-hidden mb-8 shadow-lg">
  <div class="absolute inset-0 bg-black opacity-50"></div>
  <div class="relative z-1 p-6 sm:p-8 flex flex-col sm:flex-row items-center">
    <div class="sm:w-1/3 mb-6 sm:mb-0 sm:mr-8">
      <img
        class="w-full h-48 sm:h-64 object-cover object-center rounded-lg shadow-md transform hover:scale-105 transition-transform duration-300"
        src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" />
    </div>
    <div class="sm:w-2/3">
      <span class="inline-block bg-yellow-400 text-gray-900 text-xs font-bold px-3 py-1 rounded-lg mb-4">FEATURED</span>
      <h2 class="text-2xl sm:text-3xl font-bold text-white mb-4 leading-tight">
        <a href="{{ route('articles.show', $article->slug) }}"
          class="hover:text-yellow-400 transition-colors duration-150">{{ $article->title }}</a>
      </h2>
      <p class="text-gray-200 mb-6">{{ Str::limit($article->excerpt, 120) }}</p>
      <div class="flex items-center text-gray-200">
        <img class="w-8 h-8 rounded-full mr-3"
          src="{{ $article->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($article->user->name) }}"
          alt="{{ $article->user->name }}">
        <span>{{ $article->user->name }}</span>
        <span class="mx-2">•</span>
        <span>{{ $article->created_at->format('M d, Y') }}</span>
      </div>
    </div>
  </div>
  <x-button-action href="{{ route('articles.show', $article->slug) }}"
    class="absolute bottom-4 right-4 border border-yellow-400 bg-yellow-400 text-gray-900 px-4 py-2 font-bold hover:bg-yellow-300">
    Read Now
  </x-button-action>
</div>