@if (session('success') || session('error') || session('info') || session('warning'))
@php
$type = session('success') ? 'success' : (session('error') ? 'error' : (session('info') ? 'info' : 'warning'));
$message = session($type);
$icons = [
    'success' => '<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path><path d="m9 12 2 2 4-4"></path></svg>',
    'error' => '<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
    'info' => '<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>',
    'warning' => '<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>'
];
$styles = [
    'success' => [
        'wrapper' => 'bg-green-50 dark:bg-green-900/50',
        'container' => 'border-green-400/50 dark:border-green-500/50',
        'icon' => 'text-green-400 dark:text-green-300',
        'title' => 'text-green-800 dark:text-green-200',
        'message' => 'text-green-700 dark:text-green-300',
        'button' => 'bg-green-50 dark:bg-green-900/50 text-green-500 dark:text-green-300 hover:bg-green-100 dark:hover:bg-green-900 focus:ring-green-600 dark:focus:ring-green-500',
        'progress' => 'bg-green-100 dark:bg-green-800'
    ],
    'error' => [
        'wrapper' => 'bg-red-50 dark:bg-red-900/50',
        'container' => 'border-red-400/50 dark:border-red-500/50',
        'icon' => 'text-red-400 dark:text-red-300',
        'title' => 'text-red-800 dark:text-red-200',
        'message' => 'text-red-700 dark:text-red-300',
        'button' => 'bg-red-50 dark:bg-red-900/50 text-red-500 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-900 focus:ring-red-600 dark:focus:ring-red-500',
        'progress' => 'bg-red-100 dark:bg-red-800'
    ],
    'info' => [
        'wrapper' => 'bg-blue-50 dark:bg-blue-900/50',
        'container' => 'border-blue-400/50 dark:border-blue-500/50',
        'icon' => 'text-blue-400 dark:text-blue-300',
        'title' => 'text-blue-800 dark:text-blue-200',
        'message' => 'text-blue-700 dark:text-blue-300',
        'button' => 'bg-blue-50 dark:bg-blue-900/50 text-blue-500 dark:text-blue-300 hover:bg-blue-100 dark:hover:bg-blue-900 focus:ring-blue-600 dark:focus:ring-blue-500',
        'progress' => 'bg-blue-100 dark:bg-blue-800'
    ],
    'warning' => [
        'wrapper' => 'bg-yellow-50 dark:bg-yellow-900/50',
        'container' => 'border-yellow-400/50 dark:border-yellow-500/50',
        'icon' => 'text-yellow-400 dark:text-yellow-300',
        'title' => 'text-yellow-800 dark:text-yellow-200',
        'message' => 'text-yellow-700 dark:text-yellow-300',
        'button' => 'bg-yellow-50 dark:bg-yellow-900/50 text-yellow-500 dark:text-yellow-300 hover:bg-yellow-100 dark:hover:bg-yellow-900 focus:ring-yellow-600 dark:focus:ring-yellow-500',
        'progress' => 'bg-yellow-100 dark:bg-yellow-800'
    ]
];
@endphp

<div x-data="{ 
        show: true,
        progress: 100,
        progressInterval: null
    }" 
    x-init="
        progressInterval = setInterval(() => {
            progress = Math.max(0, progress - 1);
            if (progress === 0) {
                clearInterval(progressInterval);
                setTimeout(() => show = false, 300);
            }
        }, 50);
        setTimeout(() => {
            clearInterval(progressInterval);
            show = false;
        }, 5000);
    "
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed bottom-5 right-5 w-full max-w-sm z-50"
    @click="show = false"
    role="alert"
    aria-live="assertive">
    
    <div class="relative overflow-hidden rounded-lg border {{ $styles[$type]['container'] }} shadow-lg">
        <div class="{{ $styles[$type]['wrapper'] }} p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="{{ $styles[$type]['icon'] }}">
                        {!! $icons[$type] !!}
                    </div>
                </div>
                <div class="ml-3 w-0 flex-1">
                    <p class="text-sm font-medium {{ $styles[$type]['title'] }}">
                        {{ ucfirst($type) }}
                    </p>
                    <p class="mt-1 text-sm {{ $styles[$type]['message'] }}">
                        {{ $message }}
                    </p>
                </div>
                <div class="ml-4 flex flex-shrink-0">
                    <button type="button" 
                            @click="show = false"
                            class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $styles[$type]['button'] }}">
                        <span class="sr-only">{{ __('admin.common.close') }}</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Progress bar -->
        <div class="absolute bottom-0 left-0 h-1 transition-all duration-150" 
             :style="{ width: `${progress}%` }"
             :class="'{{ $styles[$type]['progress'] }}'">
        </div>
    </div>
</div>
@endif