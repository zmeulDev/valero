<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO -->
    <title>{{ __('frontend.playlists.title') }} - {{ config('app.name') }}</title>
    <meta name="description" content="{{ __('frontend.playlists.description') }}">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/valero-frontend.js'])
    @livewireStyles

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="icon" href="{{ asset('storage/brand/favicon.ico') }}">
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100"
    x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
    <x-navigation />

    <!-- Main Content -->
    <main class="container mx-auto">
        <div class="container mx-auto px-4 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-3 space-y-8">

                <div
                    class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ __('frontend.playlists.title') }}</h1>
                        <p class="text-gray-500 dark:text-gray-400 mt-1">{{ __('frontend.playlists.description') }}</p>
                    </div>

                    <div class="p-6 grid gap-6 md:grid-cols-2">
                        @forelse($playlists as $playlist)
                            <a href="{{ route('frontend.playlists.show', $playlist) }}"
                                class="block p-6 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-indigo-500 dark:hover:border-indigo-500 transition-colors group">
                                <h3
                                    class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    {{ $playlist->title }}
                                </h3>
                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-4">
                                    <x-lucide-layers class="w-4 h-4 mr-1" />
                                    {{ $playlist->articles_count }} {{ __('frontend.playlists.articles') }}
                                </div>
                                @if($playlist->description)
                                    <p class="text-gray-600 dark:text-gray-300 line-clamp-3 mb-4">
                                        {{ $playlist->description }}
                                    </p>
                                @endif
                                <div class="text-indigo-600 dark:text-indigo-400 text-sm font-medium group-hover:underline">
                                    {{ __('frontend.playlists.view_series') }} &rarr;
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 col-span-2 text-center py-8">{{ __('admin.playlists.no_playlists') }}
                            </p>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $playlists->links() }}
                    </div>
                </div>
            </div>
            <!-- Sidebar -->
            <x-sidebar.sidebar :popularArticles="$popularArticles" :categories="$categories" />
        </div>
    </main>

    <x-footer />
    <x-scroll-top />
</body>

</html>