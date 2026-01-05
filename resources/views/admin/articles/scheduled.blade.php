<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header
            icon="calendar"
            title="{{ __('admin.articles.scheduled_articles') }}"
            description="{{ __('admin.articles.description') }}"
            :breadcrumbs="[
                ['label' => __('admin.articles.breadcrumbs'), 'url' => route('admin.articles.index')],
                ['label' => __('admin.articles.scheduled')]
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('admin.articles.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <x-lucide-plus-circle class="w-4 h-4 mr-2" />
                    {{ __('admin.articles.new_article') }}
                </a>
            </x-slot:actions>
        </x-admin.page-header>
    </x-slot>

    <div class="py-6" x-data="{
        calendarArticles: {{ $calendarArticles->toJson() }},
        currentDate: new Date(),
        
        get daysInMonth() {
            return new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 0).getDate();
        },
        
        get firstDayOfMonth() {
            return new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), 1).getDay();
        },
        
        get monthName() {
            return this.currentDate.toLocaleString('default', { month: 'long' });
        },
        
        prevMonth() {
            this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() - 1, 1);
        },
        
        nextMonth() {
            this.currentDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth() + 1, 1);
        },
        
        isToday(day) {
            const today = new Date();
            return day === today.getDate() && 
                   this.currentDate.getMonth() === today.getMonth() && 
                   this.currentDate.getFullYear() === today.getFullYear();
        },
        
        getArticlesForDay(day) {
            const year = this.currentDate.getFullYear();
            const month = String(this.currentDate.getMonth() + 1).padStart(2, '0');
            const dayStr = String(day).padStart(2, '0');
            const dateStr = `${year}-${month}-${dayStr}`;
            
            return this.calendarArticles.filter(a => a.date === dateStr);
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Search and Filter Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                    <!-- Search Bar -->
                    <form method="GET" action="{{ route('admin.articles.scheduled') }}" class="relative flex-1 w-full sm:max-w-md">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-lucide-search class="h-4 w-4 text-gray-400" />
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full pl-10 pr-10 py-2 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent sm:text-sm transition-colors duration-200"
                                placeholder="{{ __('admin.common.search') }}...">
                            @if(request('search'))
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <a href="{{ route('admin.articles.scheduled', request()->except('search', 'page')) }}"
                                        class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors"
                                        title="{{ __('admin.common.clear') }}">
                                        <x-lucide-x class="h-4 w-4" />
                                    </a>
                                </div>
                            @endif
                        </div>
                    </form>

                    <!-- Category Filter -->
                    <div class="w-full sm:w-auto relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="w-full sm:w-auto inline-flex items-center justify-between px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            <div class="flex items-center">
                                <x-lucide-filter class="h-4 w-4 mr-2 text-gray-500 dark:text-gray-400" />
                                <span>{{ $selectedCategory ? $categories->find($selectedCategory)->name : __('admin.articles.all_categories') }}</span>
                            </div>
                            <x-lucide-chevron-down class="h-4 w-4 ml-2 text-gray-400" />
                        </button>

                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 z-10 mt-2 w-56 rounded-lg shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none"
                            style="display: none;">
                            <div class="py-1" role="menu">
                                <a href="{{ route('admin.articles.scheduled', request()->except('category', 'page')) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    {{ __('admin.articles.all_categories') }}
                                </a>
                                @foreach($categories as $category)
                                    <a href="{{ route('admin.articles.scheduled', array_merge(request()->except('page'), ['category' => $category->id])) }}"
                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 {{ $selectedCategory == $category->id ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300' : '' }}">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar Widget -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <x-lucide-calendar class="w-5 h-5 mr-2 text-indigo-500" />
                        <span x-text="`${monthName} ${currentDate.getFullYear()}`"></span>
                    </h2>
                    <div class="flex items-center space-x-2">
                        <button @click="prevMonth()" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <x-lucide-chevron-left class="w-5 h-5 text-gray-600 dark:text-gray-400" />
                        </button>
                        <button @click="nextMonth()" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <x-lucide-chevron-right class="w-5 h-5 text-gray-600 dark:text-gray-400" />
                        </button>
                    </div>
                </div>
                
                <div class="grid grid-cols-7 gap-1 mb-2">
                    <template x-for="day in ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']">
                        <div class="text-center text-xs font-medium text-gray-500 dark:text-gray-400 py-2" x-text="day"></div>
                    </template>
                </div>
                
                <div class="grid grid-cols-7 gap-1">
                    <template x-for="blank in firstDayOfMonth">
                        <div class="h-24 bg-gray-50/50 dark:bg-gray-800/50 rounded-lg"></div>
                    </template>
                    
                    <template x-for="day in daysInMonth">
                        <div class="h-24 border border-gray-100 dark:border-gray-700 rounded-lg p-2 relative group hover:border-indigo-500 dark:hover:border-indigo-500 transition-colors bg-white dark:bg-gray-800"
                             :class="{ 'ring-2 ring-indigo-500 ring-offset-2 dark:ring-offset-gray-900': isToday(day) }">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300" x-text="day"></span>
                            
                            <!-- Scheduled Indicators -->
                            <div class="mt-1 space-y-1 overflow-y-auto max-h-[3.5rem] scrollbar-hide">
                                <template x-for="article in getArticlesForDay(day)">
                                    <a :href="article.url" 
                                       class="block text-xs truncate rounded px-1.5 py-0.5 bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors"
                                       :title="`${article.time} - ${article.title}`">
                                        <span x-text="article.time" class="opacity-75 mr-1 text-[10px]"></span>
                                        <span x-text="article.title"></span>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            @if($articles->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <div class="mx-auto h-12 w-12 text-gray-400 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                        <x-lucide-calendar class="h-6 w-6" />
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.articles.no_scheduled_articles') }}</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 max-w-sm mx-auto">{{ __('admin.articles.get_started_by_creating_a_new_article') }}</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.articles.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            <x-lucide-plus class="-ml-1 mr-2 h-5 w-5" />
                            {{ __('admin.articles.new_article') }}
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden ring-1 ring-black ring-opacity-5">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('admin.common.title') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('admin.common.category') }}
                                    </th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        {{ __('admin.articles.scheduled_for') }}
                                    </th>
                                    <th scope="col" class="relative px-6 py-3.5">
                                        <span class="sr-only">{{ __('admin.common.actions') }}</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($articles as $article)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200 group">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0 relative">
                                                    @if($article->media->firstWhere('is_cover', true)->image_path ?? false)
                                                        <img src="{{ asset('storage/' . $article->media->firstWhere('is_cover', true)->image_path) }}" 
                                                             alt="{{ $article->title }}"
                                                             class="h-10 w-10 rounded-lg object-cover ring-2 ring-gray-100 dark:ring-gray-700 group-hover:ring-indigo-500/50 dark:group-hover:ring-indigo-400/50 transition-all">
                                                    @else
                                                        <div class="h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center ring-2 ring-gray-100 dark:ring-gray-700">
                                                            <x-lucide-image class="h-5 w-5 text-gray-400" />
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4 min-w-0 flex-1">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white line-clamp-1 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                                        {{ $article->title }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                        {{ __('admin.articles.by') }} <span class="text-gray-700 dark:text-gray-300">{{ $article->user->name }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $article->category ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-800' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                                {{ $article->category?->name ?? __('admin.articles.uncategorized') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 ring-1 ring-inset ring-yellow-600/20 w-fit">
                                                    <x-lucide-clock class="w-3 h-3 mr-1" />
                                                    {{ $article->scheduled_at->diffForHumans() }}
                                                </span>
                                                <span class="text-xs text-gray-400 mt-1 pl-1">
                                                    {{ $article->scheduled_at->format('M j, Y H:i') }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end items-center space-x-2">
                                                <a href="{{ route('admin.articles.show', $article) }}" 
                                                   class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors p-1"
                                                   title="{{ __('admin.common.view') }}">
                                                    <x-lucide-eye class="h-5 w-5" />
                                                </a>
                                                <a href="{{ route('admin.articles.edit', $article) }}" 
                                                   class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors p-1"
                                                   title="{{ __('admin.common.edit') }}">
                                                    <x-lucide-pencil class="h-5 w-5" />
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="mt-6">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
