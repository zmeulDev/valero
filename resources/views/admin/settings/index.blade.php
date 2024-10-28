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

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="md:col-span-2">
        <div class="bg-white border border-gray-200 shadow-xs rounded-lg overflow-hidden p-6">
          <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 gap-6">
              <div>
                <x-label for="app_name" value="{{ __('App Name') }}" />
                <x-input id="app_name" name="app_name" type="text" class="mt-1 block w-full"
                  :value="$settings['app_name'] ?? ''" required />
              </div>
              <div>
                <x-label for="app_url" value="{{ __('App URL') }}" />
                <x-input id="app_url" name="app_url" type="url" class="mt-1 block w-full"
                  :value="$settings['app_url'] ?? ''" required />
              </div>
              <div>
                <x-label for="app_timezone" value="{{ __('App Timezone') }}" />
                <x-input id="app_timezone" name="app_timezone" type="text" class="mt-1 block w-full"
                  :value="$settings['app_timezone'] ?? ''" required />
              </div>
              <div>
                <x-label for="app_tinymce"
                  value="{{ __('App TinyMCE') }} ( API: https://www.tiny.cloud/my-account/integrate/#more )" />
                <x-input id="app_tinymce" name="app_tinymce" type="text" class="mt-1 block w-full"
                  :value="$settings['app_tinymce'] ?? ''" required />
              </div>
              <div>
                <x-label for="app_googlesearchmeta" value="{{ __('Google Search Console Meta Tag') }}" />
                <x-input id="app_googlesearchmeta" name="app_googlesearchmeta" type="text" class="mt-1 block w-full"
                  :value="$settings['app_googlesearchmeta'] ?? ''" required />
              </div>
              <div>
                <x-label for="logo" value="{{ __('Logo') }}" />
                <input id="logo" name="logo" type="file"
                  class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                  accept="image/*" />

                <div class="mt-4">
                  <img src="{{ asset('storage/brand/logo.png') }}" alt="Current Logo"
                    class="h-32 w-32 object-cover rounded-lg border border-gray-300 shadow-md transition-transform duration-200 transform hover:scale-105">
                </div>
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
  </div>
</x-admin-layout>