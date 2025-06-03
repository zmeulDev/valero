<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header
            icon="layout-dashboard"
            title="{{ __('admin.dashboard.title') }}"
            description="{{ __('admin.dashboard.description') }}"
        >
            <x-slot:actions>
                <a href="{{ route('admin.articles.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <x-lucide-plus-circle class="w-4 h-4 mr-2" />
                    {{ __('admin.articles.new_article') }}
                </a>
            </x-slot:actions>

            <x-slot:stats>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <x-admin.stats-card 
                        icon="book-open" 
                        label="{{ __('admin.dashboard.total_articles') }}" 
                        :value="$articleCount" 
                    />
                    <x-admin.stats-card 
                        icon="check-circle" 
                        iconColor="green" 
                        label="{{ __('admin.dashboard.published') }}" 
                        :value="$publishedArticles" 
                    />
                    <x-admin.stats-card 
                        icon="clock" 
                        iconColor="yellow" 
                        label="{{ __('admin.dashboard.scheduled') }}" 
                        :value="$scheduledArticles" 
                    />
                    <x-admin.stats-card 
                        icon="eye" 
                        iconColor="purple" 
                        label="{{ __('admin.dashboard.total_views') }}" 
                        :value="$totalViews" 
                    />
                </div>
            </x-slot:stats>
        </x-admin.page-header>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Latest Articles Section - Now spans 2 columns -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                                <x-lucide-book-open class="w-5 h-5 mr-2 text-indigo-500" />
                                {{ __('admin.dashboard.latest_articles') }}
                            </h2>
                            <a href="{{ route('admin.articles.index') }}" 
                               class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                {{ __('admin.common.view') }}
                                <x-lucide-chevron-right class="w-4 h-4 ml-1" />
                            </a>
                        </div>

                        @if ($articles->isEmpty())
                            <x-nothing-found />
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                {{ __('admin.common.title') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                {{ __('admin.dashboard.author') }}
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                                {{ __('admin.dashboard.status') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($articles as $article)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center">
                                                        <div class="h-10 w-10 flex-shrink-0">
                                                            @if($article->media->firstWhere('is_cover', true)->image_path ?? false)
                                                                <img class="h-10 w-10 rounded-lg object-cover" 
                                                                     src="{{ asset('storage/' . $article->media->firstWhere('is_cover', true)->image_path) }}" 
                                                                     alt="">
                                                            @else
                                                                <div class="h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                                    <x-lucide-image class="h-6 w-6 text-gray-400" />
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                                {{ $article->title }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 dark:text-white">{{ $article->user->name }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($article->scheduled_at && $article->scheduled_at->isFuture())
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-800/20 dark:text-yellow-400">
                                                            <x-lucide-clock class="w-3 h-3 mr-1" />
                                                            {{ __('admin.status.scheduled') }} ({{ $article->scheduled_at->format('M d, Y H:i') }})
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-800/20 dark:text-green-400">
                                                            <x-lucide-check-circle class="w-3 h-3 mr-1" />
                                                            {{ __('admin.status.published') }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Activity/Stats Section -->
                <div class="space-y-6">
                    <!-- Quick Stats -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center mb-6">
                                <x-lucide-activity class="w-5 h-5 mr-2 text-indigo-500" />
                                {{ __('admin.dashboard.quick_stats') }}
                            </h2>
                            <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <div class="px-4 py-5 bg-gray-50 dark:bg-gray-700/50 shadow rounded-lg overflow-hidden sm:p-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        {{ __('admin.dashboard.avg_views_per_article') }}
                                    </dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                                        {{ $avgViewsPerArticle }}
                                    </dd>
                                </div>
                                <div class="px-4 py-5 bg-gray-50 dark:bg-gray-700/50 shadow rounded-lg overflow-hidden sm:p-6">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        {{ __('admin.dashboard.active_users') }}
                                    </dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                                        {{ $activeUsers }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center mb-6">
                                <x-lucide-clock class="w-5 h-5 mr-2 text-indigo-500" />
                                {{ __('admin.dashboard.recent_activity') }} 
                            </h2>
                            <div class="flow-root">
                                <ul role="list" class="-mb-8">
                                    @foreach($recentActivity as $activity)
                                        <li>
                                            <div class="relative pb-8">
                                                @if(!$loop->last)
                                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        <span class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                            @if($activity['type'] === 'article_created')
                                                                <x-lucide-file-text class="h-4 w-4 text-white" />
                                                            @else
                                                                <x-lucide-user class="h-4 w-4 text-white" />
                                                            @endif
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                        <div>
                                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                                @if($activity['type'] === 'article_created')
                                                                    {{ __('admin.dashboard.new_article') }}
                                                                    <a href="{{ $activity['url'] }}" class="font-medium text-gray-900 dark:text-white">
                                                                        "{{ $activity['title'] }}"
                                                                    </a> 
                                                                    by {{ $activity['user'] }}
                                                                @else
                                                                    <a href="{{ $activity['url'] }}" class="font-medium text-gray-900 dark:text-white">
                                                                        {{ $activity['user'] }}
                                                                    </a> 
                                                                    {{ __('admin.dashboard.logged_in') }}
                                                                @endif
                                                            </p>
                                                        </div>
                                                        <div class="text-right text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                            {{ Carbon\Carbon::parse($activity['date'])->diffForHumans() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>