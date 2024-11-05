<script>
    function resetCookieConsent() {
        // Clear the cookie
        document.cookie = 'cookie_consent=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        // Clear localStorage
        localStorage.removeItem('cookie_consent');
        // Reload the page
        window.location.reload();
    }
</script>

<div x-data="{ 
    open: true,
    init() {
        // Check for existing consent in cookies or localStorage
        this.open = !document.cookie.includes('cookie_consent=') && !localStorage.getItem('cookie_consent');
    },
    acceptAll() {
        this.open = false;
        // Set cookie
        document.cookie = 'cookie_consent=all; path=/; max-age=' + (60 * 60 * 24 * 365);
        // Also store in localStorage as backup
        localStorage.setItem('cookie_consent', 'all');
    },
    acceptEssentials() {
        this.open = false;
        // Set cookie
        document.cookie = 'cookie_consent=essentials; path=/; max-age=' + (60 * 60 * 24 * 365);
        // Also store in localStorage as backup
        localStorage.setItem('cookie_consent', 'essentials');
    }
}" 
x-show="open" 
class="fixed bottom-0 inset-x-0 pb-2 sm:pb-5 z-50">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="p-2 rounded-lg bg-white dark:bg-gray-800 shadow-lg sm:p-3">
            <div class="flex items-center justify-between flex-wrap">
                <div class="w-0 flex-1 flex items-center">
                    <span class="flex p-2 rounded-lg">
                        <x-lucide-cookie class="h-6 w-6 text-indigo-600 dark:text-indigo-400" />
                    </span>
                    <p class="ml-3 font-medium text-gray-900 dark:text-white truncate">
                        <span class="inline">
                            {{ __('cookieConsent.message') }}
                            <a href="{{ route('cookies.policy') }}" 
                               class="underline text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                                {{ __('cookieConsent.learnMore') }}
                            </a>
                        </span>
                    </p>
                </div>
                <div class="mt-2 flex-shrink-0 w-full sm:mt-0 sm:w-auto">
                    <div class="flex space-x-4">
                        <button @click="acceptAll()"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <x-lucide-check class="w-4 h-4 mr-2" />
                            {{ __('cookieConsent.accept.all') }}
                        </button>

                        <button @click="acceptEssentials()"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <x-lucide-shield-check class="w-4 h-4 mr-2" />
                            {{ __('cookieConsent.accept.essentials') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 