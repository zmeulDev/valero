@php
    $controller = app()->make(\App\Http\Controllers\Admin\AdminPartnersController::class);
    $partner = $controller->getActivePartnerByPosition('sidebar');
@endphp

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200/50 dark:border-gray-700/50">
    <div class="p-4 border-b border-gray-200/50 dark:border-gray-700/50">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                {{ $partner ? 'Featured Partner' : 'Partner Space' }}
            </h3>
            <x-lucide-external-link class="w-4 h-4 text-gray-400" />
        </div>
    </div>

    @if($partner)
        <div class="p-4">
            <a href="{{ $partner->full_url }}" 
               target="{{ $partner->target_attribute }}"
               rel="{{ $partner->rel_attribute }}"
               class="block space-y-4 hover:opacity-90 transition-opacity">
                
                @if($partner->image)
                    <div class="relative rounded-lg overflow-hidden bg-gray-100 dark:bg-gray-900">
                        <img src="{{ asset('storage/' . $partner->image) }}" 
                             alt="{{ $partner->name }}" 
                             class="w-full h-full object-cover"
                             loading="lazy">
                    </div>
                @endif

                <div class="space-y-2">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $partner->name }}
                    </h4>
                    
                    @if($partner->text)
                        <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">
                            {{ $partner->text }}
                        </p>
                    @endif
                </div>
            </a>
        </div>
    @else
        <div class="p-6 flex flex-col items-center justify-center text-center">
            <div class="w-12 h-12 mb-3 rounded-full bg-gray-100 dark:bg-gray-700/50 flex items-center justify-center">
                <x-lucide-briefcase class="w-6 h-6 text-gray-400 dark:text-gray-500" />
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                This space is available for partnership
            </p>
        </div>
    @endif
</div>