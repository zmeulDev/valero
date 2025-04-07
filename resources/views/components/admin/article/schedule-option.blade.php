@props(['scheduledArticles'])

<div class="space-y-2" 
    x-data="calendarData()"
    x-init="scheduledArticles = {{ json_encode($scheduledArticles) }}; init()">
    <div class="flex items-center justify-between">
        <label class="block text-md font-medium text-gray-700 dark:text-gray-300">
            Scheduled Articles
        </label>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
            {{ $scheduledArticles->count() }} scheduled
        </span>
    </div>
    
    @if($scheduledArticles->isEmpty())
        <div class="text-center py-6 bg-gray-50 dark:bg-gray-700 rounded-md border border-gray-200 dark:border-gray-600">
            <x-lucide-calendar-off class="w-8 h-8 mx-auto text-gray-400 dark:text-gray-500 mb-2" />
            <p class="text-sm text-gray-500 dark:text-gray-400">No articles currently scheduled</p>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-md overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm">
            <!-- Calendar Header -->
            <div class="bg-indigo-50 dark:bg-indigo-900/30 px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-indigo-700 dark:text-indigo-300">
                        <span x-text="months[currentMonth] + ' ' + currentYear"></span>
                    </h3>
                    <div class="flex space-x-2">
                        <button type="button" 
                                @click="goToPreviousMonth()"
                                :disabled="isLoading"
                                class="p-1 rounded-full text-indigo-600 hover:text-indigo-900 hover:bg-indigo-100 dark:text-indigo-400 dark:hover:text-indigo-300 dark:hover:bg-indigo-900/50 disabled:opacity-50 disabled:cursor-not-allowed">
                            <x-lucide-chevron-left class="w-4 h-4" />
                        </button>
                        <button type="button" 
                                @click="goToNextMonth()"
                                :disabled="isLoading"
                                class="p-1 rounded-full text-indigo-600 hover:text-indigo-900 hover:bg-indigo-100 dark:text-indigo-400 dark:hover:text-indigo-300 dark:hover:bg-indigo-900/50 disabled:opacity-50 disabled:cursor-not-allowed">
                            <x-lucide-chevron-right class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Calendar Grid -->
            <div class="p-4">
                <!-- Days of week header -->
                <div class="grid grid-cols-7 gap-1 text-center text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">
                    <template x-for="day in days" :key="day">
                        <div x-text="day"></div>
                    </template>
                </div>
                
                <!-- Calendar days grid -->
                <div class="grid grid-cols-7 gap-1">
                    <template x-for="(day, index) in calendarDays" :key="index">
                        <div class="relative h-20 p-1 border border-gray-100 dark:border-gray-700 rounded-md"
                             :class="{
                                 'bg-indigo-50 dark:bg-indigo-900/20': day.isToday,
                                 'text-gray-300 dark:text-gray-600': !day.isCurrentMonth
                             }">
                            <div class="flex justify-between">
                                <span class="text-xs font-medium" 
                                      :class="{'text-indigo-600 dark:text-indigo-400': day.isToday}">
                                    <span x-text="day.day"></span>
                                </span>
                                <template x-if="day.scheduledArticles.length > 0">
                                    <span class="inline-flex items-center justify-center w-4 h-4 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                        <span x-text="day.scheduledArticles.length"></span>
                                    </span>
                                </template>
                            </div>
                            
                            <template x-if="day.scheduledArticles.length > 0">
                                <div class="mt-1 space-y-1">
                                    <template x-for="(article, articleIndex) in day.scheduledArticles.slice(0, 2)" :key="articleIndex">
                                        <div class="text-xs truncate bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 px-1 py-0.5 rounded">
                                            <span x-text="article.title"></span>
                                        </div>
                                    </template>
                                    <template x-if="day.scheduledArticles.length > 2">
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            +<span x-text="day.scheduledArticles.length - 2"></span> more
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
            
            <!-- Calendar Footer -->
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <button type="button" 
                                @click="goToToday()"
                                class="flex items-center text-xs text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                            <div class="w-3 h-3 rounded-full bg-indigo-100 mr-2"></div>
                            <span>Today</span>
                        </button>
                    </div>
                    <a href="{{ route('admin.articles.scheduled') }}" class="text-xs text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                        View all scheduled articles
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
