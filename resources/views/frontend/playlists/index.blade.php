<x-playlist-layout :popular-articles="$popularArticles" :categories="$categories">
    <x-slot:seo>
        @php
        $seoData = new \RalphJSmit\Laravel\SEO\Support\SEOData(
            title: __('frontend.playlists.title'),
            description: __('frontend.playlists.description'),
        );
        @endphp
        {!! seo($seoData) !!}
    </x-slot:seo>

    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                {{ __('frontend.playlists.title') }}
            </h1>
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
</x-playlist-layout>