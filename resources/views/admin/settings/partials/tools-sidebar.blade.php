<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm rounded-lg overflow-hidden">
    <!-- Header -->
    <div class="border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 px-6 py-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white flex items-center">
            <x-lucide-settings class="w-5 h-5 mr-2 text-indigo-500" />
            {{ __('admin.settings.tools') }}
        </h3>
    </div>

    <!-- Content -->
    <div class="p-6 space-y-6">
        <!-- Sitemap Section -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white flex items-center">
                    <x-lucide-map class="w-4 h-4 mr-2 text-indigo-500" />
                    {{ __('admin.settings.sitemap_management') }}
                </h4>
                <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ 
                    file_exists(public_path('sitemap.xml')) 
                        ? 'bg-green-100 text-green-800 dark:bg-green-800/20 dark:text-green-400' 
                        : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800/20 dark:text-yellow-400' 
                }}">
                    {{ file_exists(public_path('sitemap.xml')) ? __('admin.settings.active') : __('admin.settings.not_found') }}
                </span>
            </div>

            <!-- Sitemap Stats -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('admin.settings.last_updated') }}</div>
                    <div class="text-sm text-gray-900 dark:text-white">
                        {{ file_exists(public_path('sitemap.xml')) 
                            ? date('M d, Y H:i', filemtime(public_path('sitemap.xml'))) 
                            : 'Never' }}
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('admin.settings.indexed_urls') }}</div>
                    <div class="text-sm text-gray-900 dark:text-white">
                        {{ file_exists(public_path('sitemap.xml')) 
                            ? substr_count(file_get_contents(public_path('sitemap.xml')), '<url>') . ' URLs'
                            : '0 URLs' }}
                    </div>
                </div>
            </div>

            <!-- Sitemap URL -->
            <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4 mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('admin.settings.sitemap_url') }}</label>
                <div class="flex items-center space-x-2">
                    <input type="text" 
                           value="{{ url('sitemap.xml') }}" 
                           readonly 
                           class="flex-1 text-sm bg-white dark:bg-gray-700 p-2 rounded border border-gray-200 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white">
                    <a href="{{ url('sitemap.xml') }}" 
                       target="_blank" 
                       class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        <x-lucide-external-link class="w-5 h-5" />
                    </a>
                </div>
            </div>

            <!-- Generate Button -->
            <form action="{{ route('admin.sitemap.generate') }}" method="GET">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <x-lucide-refresh-cw class="w-4 h-4 mr-2" />
                    {{ __('admin.settings.regenerate_sitemap') }}
                </button>
            </form>
        </div>

        <hr class="border-gray-200 dark:border-gray-700">

        <!-- Cache Section -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white flex items-center">
                    <x-lucide-database class="w-4 h-4 mr-2 text-indigo-500" />
                    {{ __('admin.settings.cache_management') }}
                </h4>
                <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800/20 dark:text-blue-400">
                    {{ __('admin.settings.cache_version', ['version' => cache_version()]) }}
                </span>
            </div>

            <div class="space-y-3">
                <!-- Application Cache -->
                <form action="{{ route('admin.clear-cache') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        <x-lucide-refresh-cw class="w-4 h-4 mr-2" />
                        {{ __('admin.settings.clear_application_cache') }}
                    </button>
                </form>

                <!-- System Cache (Development Only) -->
                @if(app()->environment('local', 'development'))
                    <a href="{{ route('admin.optimize-clear') }}" 
                       class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                        <x-lucide-trash class="w-4 h-4 mr-2" />
                        {{ __('admin.settings.clear_system_cache') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
