@if(!request()->routeIs('home'))
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-lg">
    <div class="p-6 space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Share this article
            </h3>
            <div class="h-8 w-8 rounded-full bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center">
                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                </svg>
            </div>
        </div>

        <!-- Share Buttons Grid -->
        <div class="grid grid-cols-3 gap-4">
            <!-- Facebook -->
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" 
               target="_blank"
               rel="noopener noreferrer" 
               class="aspect-square rounded-2xl flex flex-col items-center justify-center gap-2 bg-white dark:bg-gray-800 border border-gray-200/50 dark:border-gray-700/50 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:border-blue-200 dark:hover:border-blue-800 group">
                <div class="w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center transition-transform duration-300 group-hover:-translate-y-1">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">Facebook</span>
            </a>

            <!-- Twitter -->
            <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTitle) }}"
               target="_blank"
               rel="noopener noreferrer"
               class="aspect-square rounded-2xl flex flex-col items-center justify-center gap-2 bg-white dark:bg-gray-800 border border-gray-200/50 dark:border-gray-700/50 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:border-sky-200 dark:hover:border-sky-800 group">
                <div class="w-8 h-8 rounded-full bg-sky-50 dark:bg-sky-900/30 flex items-center justify-center transition-transform duration-300 group-hover:-translate-y-1">
                    <svg class="w-4 h-4 text-sky-600 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-600 dark:text-gray-400 group-hover:text-sky-600 dark:group-hover:text-sky-400">Twitter</span>
            </a>

            <!-- LinkedIn -->
            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($shareUrl) }}&title={{ urlencode($shareTitle) }}"
               target="_blank"
               rel="noopener noreferrer"
               class="aspect-square rounded-2xl flex flex-col items-center justify-center gap-2 bg-white dark:bg-gray-800 border border-gray-200/50 dark:border-gray-700/50 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:border-blue-200 dark:hover:border-blue-800 group">
                <div class="w-8 h-8 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center transition-transform duration-300 group-hover:-translate-y-1">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                        <rect width="4" height="12" x="2" y="9" />
                        <circle cx="4" cy="4" r="2" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-600 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400">LinkedIn</span>
            </a>

            <!-- WhatsApp -->
            <a href="https://api.whatsapp.com/send?text={{ urlencode($shareTitle) }}%20{{ urlencode($shareUrl) }}"
               target="_blank"
               rel="noopener noreferrer"
               class="aspect-square rounded-2xl flex flex-col items-center justify-center gap-2 bg-white dark:bg-gray-800 border border-gray-200/50 dark:border-gray-700/50 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:border-green-200 dark:hover:border-green-800 group">
                <div class="w-8 h-8 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center transition-transform duration-300 group-hover:-translate-y-1">
                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-600 dark:text-gray-400 group-hover:text-green-600 dark:group-hover:text-green-400">WhatsApp</span>
            </a>

            <!-- Copy Link Button -->
            <button type="button" 
                    x-data="{ 
                        copied: false,
                        copyToClipboard() {
                            const textArea = document.createElement('textarea');
                            textArea.value = '{{ $shareUrl }}';
                            document.body.appendChild(textArea);
                            textArea.select();
                            try {
                                document.execCommand('copy');
                                this.copied = true;
                                setTimeout(() => this.copied = false, 2000);
                            } catch (err) {
                                console.error('Failed to copy text:', err);
                            }
                            document.body.removeChild(textArea);
                        }
                    }"
                    @click="copyToClipboard()"
                    class="aspect-square rounded-2xl flex flex-col items-center justify-center gap-2 bg-white dark:bg-gray-800 border border-gray-200/50 dark:border-gray-700/50 transition-all duration-300 hover:scale-105 hover:shadow-lg hover:border-indigo-200 dark:hover:border-indigo-800 group relative">
                <div class="w-8 h-8 rounded-full bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center transition-transform duration-300 group-hover:-translate-y-1">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" 
                         x-show="!copied"
                         fill="none" 
                         stroke="currentColor" 
                         viewBox="0 0 24 24">
                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                    </svg>
                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" 
                         x-show="copied"
                         x-cloak
                         fill="none" 
                         stroke="currentColor" 
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" 
                              stroke-linejoin="round" 
                              stroke-width="2" 
                              d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-600 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400" x-text="copied ? 'Copied!' : 'Copy Link'"></span>
            </button>
        </div>
    </div>
</div>
@endif