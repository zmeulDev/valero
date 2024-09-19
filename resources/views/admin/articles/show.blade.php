<x-admin-layout>
  <x-slot name="title">Preview: {{ $article->title }}</x-slot>
  <!-- Main Container -->
  <div class="container mx-auto px-4 lg:px-8 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">

    <!-- Left Section: Hero, Title, and Content (2 columns on large screens) -->
    <div class="lg:col-span-2">
      <!-- Hero Section (Featured Image) with Title Overlay and Metadata in Bottom Left -->
      @if($article->featured_image)
      <div class="relative rounded-lg bg-cover bg-center h-[400px]"
        style="background-image: url('{{ asset('storage/' . $article->featured_image) }}');">
        <!-- Metadata in the Bottom Left -->
        <div class="absolute bottom-4 left-4 bg-gray-800 bg-opacity-75 text-white p-4 rounded-lg flex items-center">
          <img src="{{ $article->user->profile_photo_url }}" alt="{{ $article->user->name }}"
            class="h-12 w-12 rounded-full mr-4">
          <div class="text-left">
            <p class="font-semibold">{{ $article->user->name }}</p>
            <p class="text-sm">{{ $article->created_at->format('F d, Y') }} • {{ $article->read_time }} min read</p>
          </div>
          <span
            class="ml-4 bg-teal-100 text-teal-800 text-sm font-medium px-3 py-1 rounded-full">{{ $article->category->name ?? 'General' }}</span>
        </div>
      </div>
      @endif

      <hr class="my-8 h-0.3 border-t-0 bg-neutral-100 dark:bg-white/10" />

      <!-- Title Section -->
      <div class="text-left px-4">
        <h1 class="text-3xl font-bold mb-4">{{ $article->title }}</h1>
        @if($article->excerpt)
        <p class="text-lg font-light mb-4">{{ \Illuminate\Support\Str::limit(strip_tags($article->excerpt), 156) }}</p>
        @endif
      </div>

      <!-- Article Content Section -->
      <div class="prose lg:prose-xl">
        {!! $article->content !!}
      </div>
    </div>

    <!-- Right Section: Sticky Sidebar (Component) -->
    <div class="lg:col-span-1">
      <div class="sticky top-16 space-y-8">
        <x-sidebar :popularArticles="$popularArticles" :categories="$categories" />
      </div>
    </div>

  </div>

  <!-- Back to Articles List -->
  <a href="{{ route('admin.articles.index') }}" class="mt-8 inline-block text-blue-600 hover:underline">Back to
    Articles</a>
</x-admin-layout>