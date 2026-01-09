@php
    $controller = app()->make(\App\Http\Controllers\Admin\AdminPartnersController::class);
    $partner = $controller->getActivePartnerByPosition('sidebar');
@endphp

<div class="bg-surface rounded-lg shadow-sm border border-border">
    <div class="p-4 border-b border-border">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-medium text-text">
                {{ $partner ? __('frontend.sidebar.featured_partner') : __('frontend.sidebar.partner_space') }}
            </h3>
            <x-lucide-external-link class="w-4 h-4 text-muted" />
        </div>
    </div>

    @if($partner)
        <div class="p-4">
            <a href="{{ $partner->full_url }}" target="{{ $partner->target_attribute }}" rel="{{ $partner->rel_attribute }}"
                class="block space-y-4 hover:opacity-90 transition-opacity">

                @if($partner->image)
                    <div class="relative rounded-lg overflow-hidden bg-background">
                        <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}"
                            class="w-full h-full object-cover" loading="lazy">
                    </div>
                @endif

                <div class="space-y-2">
                    <h4 class="text-sm font-medium text-text">
                        {{ $partner->name }}
                    </h4>

                    @if($partner->text)
                        <p class="text-sm text-muted line-clamp-2">
                            {{ $partner->text }}
                        </p>
                    @endif
                </div>
            </a>
        </div>
    @else
        <div class="p-6 flex flex-col items-center justify-center text-center">
            <div class="w-12 h-12 mb-3 rounded-full bg-background flex items-center justify-center">
                <x-lucide-briefcase class="w-6 h-6 text-muted" />
            </div>
            <p class="text-sm text-muted">
                {{ __('frontend.sidebar.this_space_is_available_for_partnership') }}
            </p>
        </div>
    @endif
</div>