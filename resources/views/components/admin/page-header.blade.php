@props([
    'icon',
    'title',
    'description',
    'breadcrumbs' => [],
    'actions' => null,
    'stats' => null
])

<div class="bg-white dark:bg-gray-900">
    <div class="border-b border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex justify-between items-center h-16">
                <div class="flex-1 flex items-center">
                    <x-dynamic-component :component="'lucide-'.$icon" class="w-8 h-8 text-indigo-600 dark:text-indigo-400 mr-3" />
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white leading-7">{{ $title }}</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $description }}</p>
                    </div>
                </div>

                @if($actions)
                    <div class="flex items-center space-x-4">{{ $actions }}</div>
                @endif
            </div>

            <!-- Breadcrumbs -->
            <div class="py-4">
                <x-admin.breadcrumbs :items="$breadcrumbs" />
            </div>

            <!-- Stats -->
            @if($stats)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 py-4">
                    {{ $stats }}
                </div>
            @endif
        </div>
    </div>
</div>