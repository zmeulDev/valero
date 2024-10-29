@if (session('success') || session('error') || session('info') || session('warning'))
@php
$type = session('success') ? 'success' : (session('error') ? 'error' : (session('info') ? 'info' : 'warning'));
$message = session($type);
$icons = [
    'success' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>',
    'error' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>',
    'info' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>',
    'warning' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>'
];
$styles = [
    'success' => [
        'bg' => 'bg-green-50',
        'border' => 'border-green-400',
        'text' => 'text-green-800',
        'icon' => 'text-green-400'
    ],
    'error' => [
        'bg' => 'bg-red-50',
        'border' => 'border-red-400',
        'text' => 'text-red-800',
        'icon' => 'text-red-400'
    ],
    'info' => [
        'bg' => 'bg-blue-50',
        'border' => 'border-blue-400',
        'text' => 'text-blue-800',
        'icon' => 'text-blue-400'
    ],
    'warning' => [
        'bg' => 'bg-yellow-50',
        'border' => 'border-yellow-400',
        'text' => 'text-yellow-800',
        'icon' => 'text-yellow-400'
    ]
];
@endphp

<div x-data="{ show: true }" 
     x-init="setTimeout(() => show = false, 5000)" 
     x-show="show"
     x-transition:enter="transform ease-out duration-300 transition"
     x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
     x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
     x-transition:leave="transition ease-in duration-100"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed bottom-5 right-5 w-full max-w-sm pl-4 z-50"
     style="z-index: 9999;">
    
    <div class="rounded-lg p-4 shadow-lg {{ $styles[$type]['bg'] }} {{ $styles[$type]['border'] }} border">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <div class="{{ $styles[$type]['icon'] }}">
                    {!! $icons[$type] !!}
                </div>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-medium {{ $styles[$type]['text'] }}">
                    {{ ucfirst($type) }}
                </p>
                <p class="mt-1 text-sm {{ $styles[$type]['text'] }} opacity-90">
                    {{ $message }}
                </p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button @click="show = false" 
                        class="inline-flex {{ $styles[$type]['text'] }} hover:opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $styles[$type]['border'] }} rounded-md">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endif