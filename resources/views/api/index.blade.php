<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header
            icon="key"
            title="{{ __('API Tokens') }}"
            description="Manage your API tokens for accessing the application programmatically"
            :breadcrumbs="[['label' => __('API Tokens')]]"
        />
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @livewire('api.api-token-manager')
        </div>
    </div>
</x-admin-layout>
