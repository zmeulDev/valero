@props(['scheduledArticles'])

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6" x-data="{
    calendarArticles: {{ $scheduledArticles->toJson() }},
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
        
        // Match article scheduled_at date part
        return this.calendarArticles.filter(a => {
            // Check if article.date exists (from controller mapping) or parse scheduled_at
            if (a.date) return a.date === dateStr;
            if (a.scheduled_at) return a.scheduled_at.substring(0, 10) === dateStr;
            return false;
        });
    }
}">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
            <x-lucide-calendar class="w-5 h-5 mr-2 text-indigo-500" />
            <span x-text="`${monthName} ${currentDate.getFullYear()}`"></span>
        </h2>
        <div class="flex items-center space-x-2">
            <button @click="prevMonth()" type="button"
                class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <x-lucide-chevron-left class="w-5 h-5 text-gray-600 dark:text-gray-400" />
            </button>
            <button @click="nextMonth()" type="button"
                class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
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
                        <div class="block text-xs truncate rounded px-1.5 py-0.5 bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors"
                            :title="`${article.scheduled_at ? new Date(article.scheduled_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : ''} - ${article.title}`">
                            <span
                                x-text="article.scheduled_at ? new Date(article.scheduled_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : ''"
                                class="opacity-75 mr-1 text-[10px]"></span>
                            <span x-text="article.title"></span>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>
</div>