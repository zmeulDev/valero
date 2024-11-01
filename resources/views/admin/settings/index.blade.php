<x-admin-layout>
    <x-notification />
    <x-slot name="header">
        <x-admin.page-header
            icon="settings"
            title="{{ __('Settings') }}"
            description="Configure your application settings"
            :breadcrumbs="[['label' => 'Settings']]"
        >
            <x-slot:actions>
                <button type="submit" form="settings-form"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-lucide-save class="w-4 h-4 mr-2" />
                    Save Changes
                </button>
            </x-slot:actions>
        </x-admin.page-header>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <!-- Brand Settings Card -->
                            <x-admin.card>
                                <x-slot:header>
                                    <div class="flex items-center">
                                        <x-lucide-briefcase class="w-5 h-5 text-indigo-500 mr-2" />
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Brand Settings</h3>
                                    </div>
                                </x-slot:header>

                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                    <x-admin.form.text-input
                                        name="app_name"
                                        label="Application Name"
                                        :value="$settings['app_name'] ?? ''"
                                        required
                                    />
                                    <x-admin.form.text-input
                                        name="app_url"
                                        label="Application URL"
                                        :value="$settings['app_url'] ?? ''"
                                        required
                                    />
                                    <x-admin.form.select-input
                                        name="app_timezone"
                                        label="Timezone"
                                        :value="$settings['app_timezone'] ?? 'UTC'"
                                        :options="timezone_identifiers_list()"
                                        required
                                    />
                                    <x-admin.form.file-input
                                        name="logo"
                                        label="Logo"
                                        :currentImage="asset($settings['app_logo'] ?? 'storage/brand/logo.png') . '?v=' . ($settings['app_logo_version'] ?? '1')"
                                    />
                                </div>
                            </x-admin.card>

                            <!-- API Settings Card -->
                            <x-admin.card>
                                <x-slot:header>
                                    <div class="flex items-center">
                                        <x-lucide-key class="w-5 h-5 text-indigo-500 mr-2" />
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">API Settings</h3>
                                    </div>
                                </x-slot:header>

                                <div class="grid grid-cols-1 gap-6">
                                    <x-admin.form.text-input
                                        name="app_tinymce"
                                        label="TinyMCE API Key"
                                        :value="$settings['app_tinymce'] ?? ''"
                                        required
                                    />
                                    <x-admin.form.text-input
                                        name="app_googlesearchmeta"
                                        label="Google Search Console Meta"
                                        :value="$settings['app_googlesearchmeta'] ?? ''"
                                        required
                                    />
                                </div>
                            </x-admin.card>

                            <!-- Social Media Card -->
                            <x-admin.card>
                                <x-slot:header>
                                    <div class="flex items-center">
                                        <x-lucide-share-2 class="w-5 h-5 text-indigo-500 mr-2" />
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Social Media</h3>
                                    </div>
                                </x-slot:header>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    @foreach ($socialPlatforms as $platform => $data)
                                        <x-admin.form.text-input
                                            type="url"
                                            name="app_social{{ $platform }}"
                                            :label="$data['label']"
                                            :value="$settings['app_social'.$platform] ?? ''"
                                            :placeholder="'https://' . $data['url'] . '/username'"
                                        >
                                            <x-slot:prefix>
                                                <x-dynamic-component 
                                                    :component="'lucide-' . $data['icon']"
                                                    class="h-5 w-5 text-gray-400"
                                                />
                                            </x-slot:prefix>
                                        </x-admin.form.text-input>
                                    @endforeach
                                </div>
                            </x-admin.card>
                        </div>
                    </form>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    @include('admin.settings.partials.seo-sidebar')
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
