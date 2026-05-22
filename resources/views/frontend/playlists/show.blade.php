<x-playlist-layout :popular-articles="$popularArticles" :categories="$categories">
    <x-slot:seo>
        @php
            $coverMedia = $playlist->articles->first()?->media->firstWhere('is_cover', true);
            $ogImage = $coverMedia?->image_path ? url('storage/' . $coverMedia->image_path) : url(asset('storage/brand/logo.png'));
            $playlistUrl = url(route('frontend.playlists.show', $playlist->slug));
            $seoDescription = \App\Helpers\SeoHelper::smartTruncate($playlist->description, 160);
            $twitterHandle = config('app_twitter_handle') ? '@' . ltrim(config('app_twitter_handle'), '@') : '';
            $ogLocale = match(app()->getLocale()) { 'ro' => 'ro_RO', 'es' => 'es_ES', default => 'en_US' };
        @endphp

        @if($coverMedia?->image_path)
        <link rel="preload" as="image" href="{{ $ogImage }}">
        @endif

        <title>{{ $playlist->title }} - {{ config('app_name') }}</title>
        <meta name="description" content="{{ $seoDescription }}">
        <meta property="og:locale" content="{{ $ogLocale }}">
        <meta property="og:title" content="{{ $playlist->title }} - {{ config('app_name') }}">
        <meta property="og:description" content="{{ $seoDescription }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ $playlistUrl }}">
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:site_name" content="{{ config('app_name') }}">
        <link rel="canonical" href="{{ $playlistUrl }}">

        @if($twitterHandle)
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="{{ $twitterHandle }}">
        <meta name="twitter:title" content="{{ $playlist->title }}">
        <meta name="twitter:description" content="{{ $seoDescription }}">
        <meta name="twitter:image" content="{{ $ogImage }}">
        @endif

        <!-- BreadcrumbList Schema -->
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": "{{ url(route('home')) }}"
                },
                {
                    "@type": "ListItem",
                    "position": 2,
                    "name": "Playlists",
                    "item": "{{ url(route('frontend.playlists.index')) }}"
                },
                {
                    "@type": "ListItem",
                    "position": 3,
                    "name": "{{ $playlist->title }}"
                }
            ]
        }
        </script>
    </x-slot:seo>

    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center text-indigo-600 dark:text-indigo-400 mb-2">
                <a href="{{ route('frontend.playlists.index') }}"
                    class="hover:underline flex items-center text-sm font-medium">
                    <x-lucide-arrow-left class="w-4 h-4 mr-1" />
                    {{ __('frontend.playlists.all_playlists') }}
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $playlist->title }}</h1>
            @if($playlist->description)
                <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed">{{ $playlist->description }}
                </p>
            @endif
            <div class="flex items-center mt-4 text-sm text-gray-500 space-x-4">
                <span
                    class="flex items-center bg-indigo-50 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-200 px-3 py-1 rounded-full font-medium">
                    <x-lucide-layers class="w-4 h-4 mr-2" />
                    {{ $playlist->articles->count() }} {{ __('frontend.playlists.articles') }}
                </span>
                <span class="flex items-center">
                    <x-lucide-user class="w-4 h-4 mr-1" />
                    {{ __('frontend.playlists.by') }} {{ $playlist->user->name }}
                </span>
            </div>
        </div>

        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($playlist->articles as $index => $article)
                <div
                    class="p-6 flex items-start hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors relative group">
                    <div class="flex-shrink-0 mr-4 mt-1 flex flex-col items-center">
                        <span
                            class="flex items-center justify-center h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 font-bold text-sm ring-4 ring-white dark:ring-gray-800 z-10">
                            {{ $index + 1 }}
                        </span>
                        @if($index < $playlist->articles->count() - 1)
                            <div class="w-0.5 bg-gray-200 dark:bg-gray-700 h-full -mb-6 mt-1 absolute top-10 left-9">
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('articles.index', ['slug' => $article->slug, 'playlist' => $playlist->slug]) }}"
                            class="block focus:outline-none">
                            <h3
                                class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                {{ $article->title }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 line-clamp-2 mb-3 text-sm">
                                {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 150) }}
                            </p>
                            <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 space-x-4">
                                <span class="flex items-center">
                                    <x-lucide-clock class="w-3 h-3 mr-1" />
                                    {{ $article->reading_time }}
                                </span>
                                <span class="flex items-center">
                                    <x-lucide-calendar class="w-3 h-3 mr-1" />
                                    {{ $article->created_at->format('M j, Y') }}
                                </span>
                            </div>
                        </a>
                    </div>
                    @if($article->cover_image)
                        <div class="hidden sm:block ml-4 flex-shrink-0">
                            <img src="{{ asset('storage/' . $article->cover_image->image_path) }}" alt="{{ $article->title }}"
                                @if($article->cover_image->dimensions)
                                    width="{{ $article->cover_image->dimensions['width'] ?? 144 }}"
                                    height="{{ $article->cover_image->dimensions['height'] ?? 96 }}"
                                @endif
                                class="h-24 w-36 object-cover rounded-lg shadow-sm"
                                loading="lazy" decoding="async"
                            >
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-playlist-layout>
