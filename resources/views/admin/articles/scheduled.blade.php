
<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header
            icon="calendar"
            title="{{ __('Scheduled Articles') }}"
            description="View and manage scheduled articles"
            :breadcrumbs="[
                ['label' => 'Articles', 'url' => route('admin.articles.index')],
                ['label' => 'Scheduled']
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('admin.articles.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <x-lucide-plus class="w-4 h-4 mr-2" />
                    New Article
                </a>
            </x-slot:actions>
        </x-admin.page-header>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            @if($articles->isEmpty())
                <div class="text-center py-12">
                    <x-lucide-calendar class="mx-auto h-12 w-12 text-gray-400" />
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No scheduled articles</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new article.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <x-lucide-plus class="-ml-1 mr-2 h-5 w-5" />
                            New Article
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                    <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($articles as $article)
                            <li class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-150">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        @if($article->media->firstWhere('is_cover', true))
                                            <img class="h-12 w-12 rounded-lg object-cover" 
                                                 src="{{ asset('storage/' . $article->media->firstWhere('is_cover', true)->image_path) }}" 
                                                 alt="{{ $article->title }}">
                                        @else
                                            <div class="h-12 w-12 rounded-lg bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                                <x-lucide-image class="h-6 w-6 text-gray-400 dark:text-gray-500" />
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $article->title }}
                                        </p>
                                        <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                                            <span>{{ $article->category->name }}</span>
                                            <span>•</span>
                                            <span>Scheduled for {{ $article->scheduled_at->format('M d, Y H:i') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.articles.edit', $article) }}" 
                                           class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                                            <x-lucide-pencil class="h-4 w-4" />
                                        </a>
                                        <a href="{{ route('admin.articles.show', $article) }}" 
                                           class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                                            <x-lucide-eye class="h-4 w-4" />
                                        </a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
