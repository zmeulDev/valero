@if(!request()->routeIs('home'))
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200/50 dark:border-gray-700/50">
    <div class="p-4">
        <!-- Header -->
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                {{ __('frontend.sidebar.share_this_article') }}
            </h3>
            <x-lucide-share-2 class="w-4 h-4 text-gray-400" />
        </div>

        <!-- Share Options -->
        <div class="flex flex-wrap gap-2">
            <!-- Facebook -->
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" 
               target="_blank"
               rel="noopener noreferrer" 
               class="flex items-center justify-center p-2 rounded-md bg-white dark:bg-gray-800 border border-gray-200/50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700 group transition-colors">
                <x-lucide-facebook class="w-5 h-5 text-gray-400 group-hover:text-blue-500" />
                <span class="sr-only">{{ __('frontend.common.share_on_facebook') }}</span>
            </a>

            <!-- Twitter -->
            <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTitle) }}"
               target="_blank"
               rel="noopener noreferrer"
               class="flex items-center justify-center p-2 rounded-md bg-white dark:bg-gray-800 border border-gray-200/50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700 group transition-colors">
                <x-lucide-twitter class="w-5 h-5 text-gray-400 group-hover:text-sky-500" />
                <span class="sr-only">{{ __('frontend.common.share_on_twitter') }}</span>
            </a>

            <!-- LinkedIn -->
            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($shareUrl) }}&title={{ urlencode($shareTitle) }}"
               target="_blank"
               rel="noopener noreferrer"
               class="flex items-center justify-center p-2 rounded-md bg-white dark:bg-gray-800 border border-gray-200/50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700 group transition-colors">
                <x-lucide-linkedin class="w-5 h-5 text-gray-400 group-hover:text-blue-500" />
                <span class="sr-only">{{ __('frontend.common.share_on_linkedin') }}</span>
            </a>

            <!-- WhatsApp -->
            <a href="https://api.whatsapp.com/send?text={{ urlencode($shareTitle) }}%20{{ urlencode($shareUrl) }}"
               target="_blank"
               rel="noopener noreferrer"
               class="flex items-center justify-center p-2 rounded-md bg-white dark:bg-gray-800 border border-gray-200/50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700 group transition-colors">
                <x-lucide-message-circle class="w-5 h-5 text-gray-400 group-hover:text-green-500" />
                <span class="sr-only">{{ __('frontend.common.share_on_whatsapp') }}</span>
            </a>

            <!-- Copy Link Button -->
            <button type="button" 
                    x-data="{ 
                        copied: false,
                        copyToClipboard() {
                            const url = '{{ $shareUrl }}';
                            if (navigator.clipboard && window.isSecureContext) {
                                navigator.clipboard.writeText(url)
                                    .then(() => {
                                        this.copied = true;
                                        setTimeout(() => this.copied = false, 2000);
                                    })
                                    .catch(() => this.fallbackCopyToClipboard(url));
                            } else {
                                this.fallbackCopyToClipboard(url);
                            }
                        },
                        fallbackCopyToClipboard(text) {
                            const textArea = document.createElement('textarea');
                            textArea.value = text;
                            textArea.style.position = 'fixed';
                            textArea.style.left = '-999999px';
                            textArea.style.top = '-999999px';
                            document.body.appendChild(textArea);
                            textArea.focus();
                            textArea.select();
                            try {
                                document.execCommand('copy');
                                this.copied = true;
                                setTimeout(() => this.copied = false, 2000);
                            } catch (err) {
                                console.error('Failed to copy:', err);
                            }
                            document.body.removeChild(textArea);
                        }
                    }"
                    @click="copyToClipboard()"
                    class="flex items-center justify-center p-2 rounded-md bg-white dark:bg-gray-800 border border-gray-200/50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700 group transition-colors">
                <template x-if="!copied">
                    <x-lucide-link class="w-5 h-5 text-gray-400 group-hover:text-indigo-500" />
                </template>
                <template x-if="copied">
                    <x-lucide-check class="w-5 h-5 text-green-500" />
                </template>
                <span class="sr-only" x-text="copied ? '{{ __('frontend.common.link_copied') }}' : '{{ __('frontend.common.copy_link') }}'"></span>
            </button>
        </div>
    </div>
</div>
@endif