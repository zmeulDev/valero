<x-admin-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Application Settings') }}
    </h2>
  </x-slot>
  

  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
      <p class="mt-2 text-sm text-gray-600">Manage your app settings</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <!-- Main Settings (3 columns) -->
        <div class="md:col-span-3">
            <div class="bg-white border border-gray-200 shadow-xs rounded-lg overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
                    <h3 class="text-lg font-medium text-gray-900">General Settings</h3>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-8">
                            <!-- Logo and App Name side by side -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <!-- Logo -->
                                <div class="space-y-3">
                                    <x-label for="logo" value="{{ __('Brand Logo') }}" class="text-base" />
                                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 hover:border-gray-300 transition-colors duration-200">
                                        <img src="{{ asset('storage/brand/logo.png') }}" alt="Current Logo"
                                            class="h-32 w-32 object-cover rounded-lg shadow-sm mx-auto">
                                    </div>
                                    <input id="logo" name="logo" type="file"
                                        class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"
                                        accept="image/*" />
                                </div>

                                <!-- Settings -->
                                <div class="md:col-span-2 space-y-6">
                                    <!-- App Name -->
                                    <div>
                                        <x-label for="app_name" value="{{ __('App Name') }}" class="text-base" />
                                        <x-input id="app_name" name="app_name" type="text" 
                                            class="mt-1.5 block w-full bg-gray-50 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                            :value="$settings['app_name'] ?? ''" required />
                                    </div>

                                    <!-- URL and Timezone -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        <div>
                                            <x-label for="app_url" value="{{ __('App URL') }}" class="text-base" />
                                            <x-input id="app_url" name="app_url" type="url" 
                                                class="mt-1.5 block w-full bg-gray-50 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                                :value="$settings['app_url'] ?? ''" required />
                                        </div>
                                        <div>
                                            <x-label for="app_timezone" value="{{ __('Timezone') }}" class="text-base" />
                                            <x-input id="app_timezone" name="app_timezone" type="text" 
                                                class="mt-1.5 block w-full bg-gray-50 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                                :value="$settings['app_timezone'] ?? ''" required />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- API Integrations -->
                            <div class="border-t border-gray-200 pt-8 space-y-6">
                                <h4 class="text-lg font-medium text-gray-900 mb-4">API Integrations</h4>
                                
                                <!-- TinyMCE -->
                                <div>
                                    <x-label for="app_tinymce" value="{{ __('TinyMCE API Key') }}" class="text-base" />
                                    <x-input id="app_tinymce" name="app_tinymce" type="text" 
                                        class="mt-1.5 block w-full bg-gray-50 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                        :value="$settings['app_tinymce'] ?? ''" required />
                                    <p class="mt-1.5 text-sm text-gray-500">Get your API key from <a href="https://www.tiny.cloud/my-account/integrate/#more" class="text-indigo-600 hover:text-indigo-800" target="_blank">TinyMCE Dashboard</a></p>
                                </div>

                                <!-- Google Search Console -->
                                <div>
                                    <x-label for="app_googlesearchmeta" value="{{ __('Google Search Console Meta Tag') }}" class="text-base" />
                                    <x-input id="app_googlesearchmeta" name="app_googlesearchmeta" type="text" 
                                        class="mt-1.5 block w-full bg-gray-50 border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                        :value="$settings['app_googlesearchmeta'] ?? ''" required />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-6 border-t border-gray-200">
                            <x-button class="ml-4">
                                {{ __('Save Settings') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- SEO Sidebar (1 column) -->
        <div class="md:col-span-1">
            @include('admin.settings.partials.seo-sidebar')
        </div>
    </div>
</x-admin-layout>
