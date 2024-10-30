<x-admin-layout>
    <x-slot name="header">
        <div class="bg-white">
            <div class="border-b border-t border-gray-200">
                <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Left side -->
                        <div class="flex-1 flex items-center">
                            <x-lucide-settings class="w-8 h-8 text-indigo-600 mr-3" />
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 leading-7">
                                    {{ __('Application Settings') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    Manage your application settings and configurations
                                </p>
                            </div>
                        </div>

                        <!-- Right side -->
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                                Back to Dashboard
                            </a>
                        </div>
                    </div>

                    <!-- Breadcrumbs -->
                    <div class="py-4">
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol role="list" class="flex items-center space-x-4">
                                <li>
                                    <div>
                                        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-gray-500">
                                            <x-lucide-home class="flex-shrink-0 h-5 w-5" />
                                            <span class="sr-only">Home</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <x-lucide-chevron-right class="flex-shrink-0 h-5 w-5 text-gray-400" />
                                        <span class="ml-4 text-sm font-medium text-indigo-600">Settings</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Main Settings Panel -->
                <div class="lg:col-span-3 space-y-6">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Brand Settings Card -->
                        <div class="bg-white mb-4 rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="border-b border-gray-200">
                                <div class="px-5 py-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Brand Settings</h3>
                                    <p class="mt-1 text-sm text-gray-500">Customize your brand identity and basic information</p>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                    <!-- Logo Upload -->
                                    <div class="space-y-4">
                                        <label class="block text-sm font-medium text-gray-700">Brand Logo</label>
                                        <div class="p-4 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 hover:border-gray-300 transition-colors duration-200">
                                            <div class="space-y-2">
                                                <img src="{{ asset('storage/brand/logo.png') }}" 
                                                     alt="Current Logo"
                                                     class="h-32 w-32 object-contain rounded-lg mx-auto">
                                                <input type="file" 
                                                       name="logo" 
                                                       class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"
                                                       accept="image/*">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Basic Info -->
                                    <div class="md:col-span-2 space-y-6">
                                        <div>
                                            <label for="app_name" class="block text-sm font-medium text-gray-700">App Name</label>
                                            <input type="text" 
                                                   id="app_name" 
                                                   name="app_name"
                                                   class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                   value="{{ $settings['app_name'] ?? '' }}" 
                                                   required>
                                        </div>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                            <div>
                                                <label for="app_url" class="block text-sm font-medium text-gray-700">App URL</label>
                                                <input type="url" 
                                                       id="app_url" 
                                                       name="app_url"
                                                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                                       value="{{ $settings['app_url'] ?? '' }}" 
                                                       required>
                                            </div>
                                            <div>
                                                <label for="app_timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                                                <select id="app_timezone" 
                                                        name="app_timezone"
                                                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                    <option value="UTC" {{ ($settings['app_timezone'] ?? '') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                                    <option value="America/New_York" {{ ($settings['app_timezone'] ?? '') == 'America/New_York' ? 'selected' : '' }}>Eastern Time</option>
                                                    <!-- Add more timezone options as needed -->
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- API Integration Card -->
                        <div class="bg-white mb-4 rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="border-b border-gray-200">
                                <div class="px-5 py-4">
                                    <h3 class="text-lg font-semibold text-gray-900">API Integrations</h3>
                                    <p class="mt-1 text-sm text-gray-500">Configure your third-party API integrations</p>
                                </div>
                            </div>
                            <div class="p-5 space-y-6">
                                <!-- TinyMCE -->
                                <div>
                                    <label for="app_tinymce" class="block text-sm font-medium text-gray-700">TinyMCE API Key</label>
                                    <input type="text" 
                                           id="app_tinymce" 
                                           name="app_tinymce"
                                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           value="{{ $settings['app_tinymce'] ?? '' }}" 
                                           required>
                                    <p class="mt-2 text-sm text-gray-500">
                                        Get your API key from 
                                        <a href="https://www.tiny.cloud/my-account/integrate/#more" 
                                           class="text-indigo-600 hover:text-indigo-800" 
                                           target="_blank">TinyMCE Dashboard</a>
                                    </p>
                                </div>

                                <!-- Google Search Console -->
                                <div>
                                    <label for="app_googlesearchmeta" class="block text-sm font-medium text-gray-700">Google Search Console Meta Tag</label>
                                    <input type="text" 
                                           id="app_googlesearchmeta" 
                                           name="app_googlesearchmeta"
                                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           value="{{ $settings['app_googlesearchmeta'] ?? '' }}" 
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Card -->
                        <div class="bg-white mb-4 rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                            <div class="border-b border-gray-200">
                                <div class="px-5 py-4">
                                    <h3 class="text-lg font-semibold text-gray-900">Social Media</h3>
                                    <p class="mt-1 text-sm text-gray-500">Connect your social media profiles</p>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <!-- Social Media Inputs -->
                                    @php
                                        $socialPlatforms = [
                                            'instagram' => [
                                                'label' => 'Instagram Profile',
                                                'icon' => 'instagram',
                                                'url' => 'instagram.com'
                                            ],
                                            'facebook' => [
                                                'label' => 'Facebook Profile',
                                                'icon' => 'facebook',
                                                'url' => 'facebook.com'
                                            ],
                                            'github' => [
                                                'label' => 'GitHub Profile',
                                                'icon' => 'github',
                                                'url' => 'github.com'
                                            ],
                                            'twitter' => [
                                                'label' => 'Twitter Profile',
                                                'icon' => 'twitter',
                                                'url' => 'twitter.com'
                                            ],
                                            'linkedin' => [
                                                'label' => 'LinkedIn Profile',
                                                'icon' => 'linkedin',
                                                'url' => 'linkedin.com'
                                            ]
                                        ];
                                    @endphp

                                    @foreach ($socialPlatforms as $platform => $data)
                                        <div>
                                            <label for="app_social{{ $platform }}" class="block text-sm font-medium text-gray-700">
                                                {{ $data['label'] }}
                                            </label>
                                            <div class="mt-1 relative rounded-lg shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    @switch($platform)
                                                        @case('instagram')
                                                            <x-lucide-instagram class="h-5 w-5 text-gray-400" />
                                                        @break
                                                        @case('facebook')
                                                            <x-lucide-facebook class="h-5 w-5 text-gray-400" />
                                                            @break
                                                        @case('github')
                                                            <x-lucide-github class="h-5 w-5 text-gray-400" />
                                                            @break
                                                        @case('twitter')
                                                            <x-lucide-twitter class="h-5 w-5 text-gray-400" />
                                                            @break
                                                        @case('linkedin')
                                                            <x-lucide-linkedin class="h-5 w-5 text-gray-400" />
                                                            @break
                                                    @endswitch
                                                </div>
                                                <input type="url" 
                                                       id="app_social{{ $platform }}" 
                                                       name="app_social{{ $platform }}"
                                                       class="block w-full pl-10 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                                                       value="{{ $settings['app_social'.$platform] ?? '' }}"
                                                       placeholder="https://{{ $data['url'] }}/username">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center mt-4 justify-end space-x-3">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <x-lucide-save class="h-5 w-5 mr-2" />
                                Save Settings
                            </button>
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
