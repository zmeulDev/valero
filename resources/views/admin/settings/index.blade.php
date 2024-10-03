<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Application Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <x-label for="app_name" value="{{ __('App Name') }}" />
                            <x-input id="app_name" name="app_name" type="text" class="mt-1 block w-full" :value="$settings['app_name'] ?? ''" required />
                        </div>
                        <div>
                            <x-label for="app_url" value="{{ __('App URL') }}" />
                            <x-input id="app_url" name="app_url" type="url" class="mt-1 block w-full" :value="$settings['app_url'] ?? ''" required />
                        </div>
                        <div>
                            <x-label for="app_timezone" value="{{ __('App Timezone') }}" />
                            <x-input id="app_timezone" name="app_timezone" type="text" class="mt-1 block w-full" :value="$settings['app_timezone'] ?? ''" required />
                        </div>
                        <div>
                            <x-label for="logo" value="{{ __('Logo') }}" />
                            <input id="logo" name="logo" type="file" class="mt-1 block w-full" accept="image/*" />
                            <img src="{{ asset('storage/brand/logo.png') }}" alt="Current Logo" class="mt-2 h-12">
                        </div>
                        <!-- Add more fields for other settings -->
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Save Settings') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>