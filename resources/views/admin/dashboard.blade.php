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
            <!-- Activity/Stats Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Quick Stats -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700 transition-all duration-200 hover:shadow-md">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center mb-6">
                                <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg mr-3">
                                    <x-lucide-activity class="w-5 h-5 text-green-600 dark:text-green-400" />
                                </div>
                                {{ __('admin.dashboard.quick_stats') }}
                            </h2>
                            <dl class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                                <div class="px-4 py-5 bg-gray-50 dark:bg-gray-700/30 shadow-sm rounded-lg overflow-hidden sm:p-6 border border-gray-100 dark:border-gray-700/50">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        {{ __('admin.dashboard.avg_views_per_article') }}
                                    </dt>
                                    <dd class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white">
                                        {{ $avgViewsPerArticle }}
                                    </dd>
                                </div>
                                <div class="px-4 py-5 bg-gray-50 dark:bg-gray-700/30 shadow-sm rounded-lg overflow-hidden sm:p-6 border border-gray-100 dark:border-gray-700/50">
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

                    <!-- Popular Categories -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700 transition-all duration-200 hover:shadow-md">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center mb-6">
                                <div class="p-2 bg-pink-100 dark:bg-pink-900/30 rounded-lg mr-3">
                                    <x-lucide-folder class="w-5 h-5 text-pink-600 dark:text-pink-400" />
                                </div>
                                {{ __('admin.dashboard.popular_categories') }}
                            </h2>
                            @if($topCategories->isEmpty())
                                <x-nothing-found />
                            @else
                                <div class="space-y-4">
                                    @php $maxCount = $topCategories->first()->articles_count ?? 1; @endphp
                                    @foreach($topCategories as $category)
                                        <div class="group">
                                            <div class="flex items-center justify-between mb-1">
                                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                                    {{ $category->name }}
                                                </a>
                                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded-full">
                                                    {{ $category->articles_count }}
                                                </span>
                                            </div>
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                                <div class="bg-gradient-to-r from-indigo-500 to-purple-500 h-2 rounded-full transition-all duration-500 ease-out group-hover:from-indigo-400 group-hover:to-purple-400" 
                                                     style="width: {{ ($category->articles_count / $maxCount) * 100 }}%"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700 transition-all duration-200 hover:shadow-md">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center mb-6">
                                <div class="p-2 bg-orange-100 dark:bg-orange-900/30 rounded-lg mr-3">
                                    <x-lucide-clock class="w-5 h-5 text-orange-600 dark:text-orange-400" />
                                </div>
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
                                                        <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white dark:ring-gray-800 {{ $activity['type'] === 'article_created' ? 'bg-indigo-500' : 'bg-green-500' }}">
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
                                                                    <a href="{{ $activity['url'] }}" class="font-medium text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                                                        "{{ $activity['title'] }}"
                                                                    </a> 
                                                                    by <span class="text-gray-900 dark:text-white font-medium">{{ $activity['user'] }}</span>
                                                                @else
                                                                    <a href="{{ $activity['url'] }}" class="font-medium text-gray-900 dark:text-white hover:text-green-600 dark:hover:text-green-400 transition-colors">
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

            <!-- Latest Articles Section -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700 transition-all duration-200 hover:shadow-md"
                 x-data="{
                    currentStatus: '{{ request('status', '') }}',
                    isLoading: false,
                    async fetchArticles(status) {
                        if (this.currentStatus === status && !this.isLoading) return;
                        this.isLoading = true;
                        this.currentStatus = status;
                        
                        try {
                            const response = await axios.get('{{ route('admin.dashboard') }}', { 
                                params: { status: status },
                                headers: { 'X-Requested-With': 'XMLHttpRequest' }
                            });
                            this.$refs.articlesContainer.innerHTML = response.data;
                            
                            // Update URL
                            const url = new URL(window.location);
                            if(status) {
                                url.searchParams.set('status', status);
                            } else {
                                url.searchParams.delete('status');
                            }
                            window.history.pushState({}, '', url);
                            
                        } catch (error) {
                            console.error('Error fetching articles:', error);
                        } finally {
                            this.isLoading = false;
                        }
                    }
                 }">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center">
                                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg mr-3">
                                    <x-lucide-book-open class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                                </div>
                                {{ __('admin.dashboard.latest_articles') }}
                                <span x-show="isLoading" x-transition class="ml-2 text-sm text-gray-500">
                                    <x-lucide-loader-2 class="w-4 h-4 animate-spin" />
                                </span>
                            </h2>
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center bg-gray-100 dark:bg-gray-700/50 rounded-lg p-1">
                                    <button @click="fetchArticles('')" 
                                       type="button"
                                       class="px-3 py-1 text-xs font-medium rounded-md transition-all"
                                       :class="currentStatus === '' ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200'">
                                        {{ __('admin.common.all') ?? 'All' }}
                                    </button>
                                    <button @click="fetchArticles('published')" 
                                       type="button"
                                       class="px-3 py-1 text-xs font-medium rounded-md transition-all"
                                       :class="currentStatus === 'published' ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200'">
                                        {{ __('admin.status.published') }}
                                    </button>
                                    <button @click="fetchArticles('scheduled')" 
                                       type="button"
                                       class="px-3 py-1 text-xs font-medium rounded-md transition-all"
                                       :class="currentStatus === 'scheduled' ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200'">
                                        {{ __('admin.status.scheduled') }}
                                    </button>
                                </div>
                                <a href="{{ route('admin.articles.index') }}" 
                                   class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">
                                    {{ __('admin.common.view') }}
                                    <x-lucide-chevron-right class="w-4 h-4 ml-1" />
                                </a>
                            </div>
                        </div>

                        <div x-ref="articlesContainer">
                            <x-admin.dashboard-articles-table :articles="$articles" />
                        </div>
                    </div>
                </div>
            <!-- Top Performing Articles -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden border border-gray-200 dark:border-gray-700 transition-all duration-200 hover:shadow-md">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center mb-6">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg mr-3">
                             <x-lucide-trending-up class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        {{ __('admin.dashboard.top_articles') }}
                    </h2>
                    @if($topArticles->isEmpty())
                         <x-nothing-found />
                    @else
                        <div class="overflow-x-auto ring-1 ring-black ring-opacity-5 rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('admin.common.title') }}
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('admin.dashboard.views') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($topArticles as $index => $article)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 group">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <span class="text-xs font-medium text-gray-400 mr-4 w-4 text-center">{{ $index + 1 }}</span>
                                                    <div class="h-10 w-10 flex-shrink-0 relative">
                                                        @if($article->cover_image && $article->cover_image->image_path)
                                                            <img class="h-10 w-10 rounded-lg object-cover ring-2 ring-gray-100 dark:ring-gray-700 group-hover:ring-indigo-500/50 dark:group-hover:ring-indigo-400/50 transition-all" 
                                                                 src="{{ asset('storage/' . $article->cover_image->image_path) }}" 
                                                                 alt="">
                                                        @else
                                                            <div class="h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center ring-2 ring-gray-100 dark:ring-gray-700">
                                                                <x-lucide-image class="h-5 w-5 text-gray-400" />
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="ml-4 min-w-0">
                                                        <a href="{{ route('admin.articles.edit', $article) }}" class="text-sm font-medium text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 line-clamp-1 group-hover:underline decoration-2 underline-offset-2 decoration-indigo-200 dark:decoration-indigo-800">
                                                            {{ $article->title }}
                                                        </a>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                            by <span class="text-gray-900 dark:text-gray-300">{{ $article->user->name }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/50 transition-colors">
                                                    <x-lucide-eye class="w-3.5 h-3.5 mr-1" />
                                                    {{ number_format($article->views) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>


        </div>
    </div>
</x-admin-layout>