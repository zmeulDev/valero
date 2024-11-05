<x-home-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-6">Cookie Policy</h1>

                    <div class="prose dark:prose-invert max-w-none">
                        <!-- Introduction -->
                        <div class="mb-8">
                            <p class="mb-4">Last updated: {{ now()->format('F d, Y') }}</p>
                            <p class="mb-4">This Cookie Policy explains how {{ config('app_name') }} ("we", "us", and "our") uses cookies and similar technologies to recognize you when you visit our website. It explains what these technologies are and why we use them, as well as your rights to control our use of them.</p>
                        </div>

                        <!-- Cookie Categories -->
                        @foreach(Cookies::getCategories() as $category)
                            <div class="mb-8">
                                <h2 class="text-xl font-semibold mb-4">{{ $category->title }}</h2>
                                <div class="overflow-x-auto bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead>
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cookie</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Description</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Duration</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($category->getCookies() as $cookie)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $cookie->name }}</td>
                                                    <td class="px-6 py-4 text-sm">{{ $cookie->description }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                        {{ \Carbon\CarbonInterval::minutes($cookie->duration)->cascade() }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach

                        <!-- Cookie Management -->
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold mb-4">Manage Your Cookie Preferences</h2>
                            <p class="mb-4">You can change your cookie preferences at any time. Here you can accept all cookies, only essential cookies, or reset your choices.</p>
                            
                            <div class="mt-6 flex flex-wrap gap-4">
                                <button onclick="acceptAllCookies()" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <x-lucide-check class="w-4 h-4 mr-2" />
                                    Accept All Cookies
                                </button>

                                <button onclick="acceptEssentialCookies()" 
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <x-lucide-shield-check class="w-4 h-4 mr-2" />
                                    Essential Cookies Only
                                </button>

                                <button onclick="resetCookieConsent()" 
                                        class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <x-lucide-refresh-cw class="w-4 h-4 mr-2" />
                                    Reset Cookie Preferences
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function acceptAllCookies() {
            document.cookie = 'cookie_consent=all; path=/; max-age=' + (60 * 60 * 24 * 365);
            localStorage.setItem('cookie_consent', 'all');
            window.location.reload();
        }

        function acceptEssentialCookies() {
            document.cookie = 'cookie_consent=essentials; path=/; max-age=' + (60 * 60 * 24 * 365);
            localStorage.setItem('cookie_consent', 'essentials');
            window.location.reload();
        }

        function resetCookieConsent() {
            document.cookie = 'cookie_consent=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
            localStorage.removeItem('cookie_consent');
            window.location.reload();
        }
    </script>
</x-home-layout> 