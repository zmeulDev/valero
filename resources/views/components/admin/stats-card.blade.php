@props([
    'icon',
    'iconColor' => 'indigo',
    'label',
    'value'
])

<div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 rounded-lg">
    <div class="flex items-center">
        <div class="flex-shrink-0 bg-{{ $iconColor }}-100 dark:bg-{{ $iconColor }}-900/50 rounded-md p-3">
            <x-dynamic-component :component="'lucide-'.$icon" class="h-6 w-6 text-{{ $iconColor }}-600 dark:text-{{ $iconColor }}-400" />
        </div>
        <div class="ml-4">
            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</div>
            <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $value }}</div>
        </div>
    </div>
</div>
