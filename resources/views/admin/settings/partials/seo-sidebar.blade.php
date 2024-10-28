<div class="bg-white border border-gray-200 shadow-xs rounded-lg overflow-hidden">
    <!-- Header -->
    <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
        <h3 class="text-lg font-medium text-gray-900">SEO Tools</h3>
    </div>

    <!-- Content -->
    <div class="p-4 space-y-4">
        <!-- Sitemap Status Card -->
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-sm font-medium text-gray-900">Sitemap Status</h4>
                <span class="px-2 py-1 text-xs font-medium rounded-full {{ file_exists(public_path('sitemap.xml')) ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ file_exists(public_path('sitemap.xml')) ? 'Active' : 'Not Found' }}
                </span>
            </div>
            <p class="text-xs text-gray-600">
                Last updated: {{ file_exists(public_path('sitemap.xml')) ? date('M d, Y H:i', filemtime(public_path('sitemap.xml'))) : 'Never' }}
            </p>
            <p class="text-xs text-gray-600">
                Sitemap is updated automatically when articles are created, updated, or deleted.
            </p>
        </div>

        <!-- URL Count -->
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <h4 class="text-sm font-medium text-gray-900">Indexed URLs</h4>
                <span class="text-sm font-semibold text-gray-900">
                    {{ substr_count(file_get_contents(public_path('sitemap.xml')), '<url>') }} URLs
                </span>
            </div>
        </div>

        <!-- Generate Button -->
        <form action="{{ route('sitemap.generate') }}" method="GET" class="mt-4">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Regenerate Sitemap
            </button>
        </form>

        @if(session('success'))
            <div class="mt-3 p-2 bg-green-50 border border-green-200 rounded-md">
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Sitemap URL -->
        <div class="mt-4 p-4 bg-gray-50 rounded-lg">
            <h4 class="text-sm font-medium text-gray-900 mb-2">Sitemap URL</h4>
            <div class="flex items-center space-x-2">
                <input type="text" value="{{ url('sitemap.xml') }}" readonly class="flex-1 text-xs bg-white p-2 rounded border border-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <a href="{{ url('sitemap.xml') }}" target="_blank" class="p-2 text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
