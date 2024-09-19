<x-app-layout>
  <x-slot name="title">{{ $article->title }}</x-slot>

  <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="lg:flex lg:space-x-8">
        <main class="lg:w-2/3">
          <article class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <!-- Featured Image with Metadata -->
            <div class="relative mb-8">
              <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full h-[400px] object-cover">
              <div class="absolute bottom-6 left-6">
                <div class="flex items-center text-sm bg-black bg-opacity-75 text-white rounded-full px-4 py-2">
                  <img src="{{ $article->user->profile_photo_url }}" alt="{{ $article->user->name }}" class="w-8 h-8 rounded-full mr-3">
                  <span>{{ $article->user->name }}</span>
                  <span class="mx-2">·</span>
                  <span>{{ $article->created_at->format('M d, Y') }}</span>
                  <span class="mx-2">·</span>
                  <span>{{ $readingTime }} min read</span>
                </div>
              </div>
            </div>

            <div class="px-6 pb-8">
              <!-- Article Header -->
              <header class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white leading-tight mb-4">
                  {{ $article->title }}
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 mb-4 bg-gray-100 dark:bg-gray-700 rounded-lg p-4">
                  {{ $article->excerpt }}
                </p>
              </header>

              <!-- Article Content -->
              <div class="prose prose-lg max-w-none dark:prose-invert mb-12">
                {!! $article->content !!}
              </div>

              <!-- Author Bio and Category -->
              <div class="bg-gray-100 dark:bg-gray-700 rounded-xl p-6">
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
                    <img src="{{ $article->user->profile_photo_url }}" alt="{{ $article->user->name }}" class="w-16 h-16 rounded-full mr-4">
                    <div>
                      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $article->user->name }}</h3>
                      <p class="text-sm text-gray-600 dark:text-gray-400">{{ $article->created_at->format('M d, Y') }}</p>
                    </div>
                  </div>
                  <div class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                    {{ $article->category->name ?? 'N/A' }}
                  </div>
                </div>
              </div>
            </div>
          </article>
        </main>

        <!-- Sidebar -->
        <aside class="lg:w-1/3 mt-8 lg:mt-0">
          <div class="sticky top-8">
            <x-sidebar :popularArticles="$popularArticles" :categories="$categories" />
          </div>
        </aside>
      </div>
    </div>
  </div>
</x-app-layout>