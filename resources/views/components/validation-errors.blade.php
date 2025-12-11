@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4']) }}>
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-red-600 dark:text-red-400 mt-0.5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <div class="flex-1">
                <h3 class="text-sm font-semibold text-red-800 dark:text-red-200">
                    {{ __('frontend.auth.validation_errors') }}
                </h3>
                <ul class="mt-2 space-y-1 text-sm text-red-700 dark:text-red-300">
                    @foreach ($errors->all() as $error)
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 dark:text-red-400 mt-0.5">•</span>
                            <span>{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif
