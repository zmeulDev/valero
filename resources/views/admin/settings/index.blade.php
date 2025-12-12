<x-admin-layout>
    <x-notification />
    <x-slot name="header">
        <x-admin.page-header
            icon="settings"
            title="{{ __('admin.settings.title') }}"
            description="{{ __('admin.settings.description') }}"
            :breadcrumbs="[['label' => __('admin.settings.title')]]"
        >
            <x-slot:actions>
                <button type="submit" form="settings-form"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-lucide-save class="w-4 h-4 mr-2" />
                    {{ __('admin.common.save') }}    
                </button>
            </x-slot:actions>
        </x-admin.page-header>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2" x-data="{ activeTab: 'brand' }">
                    <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Tab Navigation -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
                            <div class="border-b border-gray-200 dark:border-gray-700">
                                <nav class="-mb-px flex space-x-2 px-4 overflow-x-auto" aria-label="Tabs">
                                    <!-- Brand Tab -->
                                    <button 
                                        type="button"
                                        @click="activeTab = 'brand'"
                                        :class="activeTab === 'brand' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                        class="group inline-flex items-center py-4 px-3 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                                        <x-lucide-briefcase 
                                            :class="activeTab === 'brand' ? 'text-indigo-500 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300'"
                                            class="w-5 h-5 mr-2 transition-colors" />
                                        <span>Brand</span>
                                    </button>

                                    <!-- SEO Tab -->
                                    <button 
                                        type="button"
                                        @click="activeTab = 'seo'"
                                        :class="activeTab === 'seo' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                        class="group inline-flex items-center py-4 px-3 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                                        <x-lucide-search 
                                            :class="activeTab === 'seo' ? 'text-indigo-500 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300'"
                                            class="w-5 h-5 mr-2 transition-colors" />
                                        <span>SEO</span>
                                    </button>

                                    <!-- API Tab -->
                                    <button 
                                        type="button"
                                        @click="activeTab = 'api'"
                                        :class="activeTab === 'api' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                        class="group inline-flex items-center py-4 px-3 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                                        <x-lucide-key 
                                            :class="activeTab === 'api' ? 'text-indigo-500 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300'"
                                            class="w-5 h-5 mr-2 transition-colors" />
                                        <span>API</span>
                                    </button>

                                    <!-- Social Media Tab -->
                                    <button 
                                        type="button"
                                        @click="activeTab = 'social'"
                                        :class="activeTab === 'social' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                        class="group inline-flex items-center py-4 px-3 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                                        <x-lucide-share-2 
                                            :class="activeTab === 'social' ? 'text-indigo-500 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300'"
                                            class="w-5 h-5 mr-2 transition-colors" />
                                        <span>Social Media</span>
                                    </button>

                                    <!-- Profitshare Tab -->
                                    <button 
                                        type="button"
                                        @click="activeTab = 'profitshare'"
                                        :class="activeTab === 'profitshare' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                        class="group inline-flex items-center py-4 px-3 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                                        <x-lucide-dollar-sign 
                                            :class="activeTab === 'profitshare' ? 'text-indigo-500 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300'"
                                            class="w-5 h-5 mr-2 transition-colors" />
                                        <span>{{ __('admin.settings.profitshare') }}</span>
                                    </button>
                                </nav>
                            </div>
                        </div>

                        <!-- Tab Panels -->
                        <div class="space-y-6">
                            <!-- Brand Settings Panel -->
                            <div x-show="activeTab === 'brand'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                                <x-admin.card>
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
                            </div>

                            <!-- SEO Settings Panel -->
                            <div x-show="activeTab === 'seo'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                                <x-admin.card>
                                    <div class="grid grid-cols-1 gap-6">
                                        <x-admin.form.text-input
                                            name="app_seo_title"
                                            label="SEO Title Suffix"
                                            :value="$settings['app_seo_title'] ?? 'Latest Articles & Insights'"
                                            placeholder="Latest Articles & Insights"
                                            required
                                        />
                                        <x-admin.form.textarea
                                            name="app_seo_description"
                                            label="SEO Meta Description"
                                            :value="$settings['app_seo_description'] ?? ''"
                                            placeholder="Discover the latest articles, insights, and updates..."
                                            rows="3"
                                            required
                                        />
                                        <x-admin.form.text-input
                                            name="app_seo_og_title"
                                            label="Open Graph Title"
                                            :value="$settings['app_seo_og_title'] ?? ''"
                                            placeholder="Leave empty to use SEO Title"
                                        />
                                        <x-admin.form.textarea
                                            name="app_seo_og_description"
                                            label="Open Graph Description"
                                            :value="$settings['app_seo_og_description'] ?? ''"
                                            placeholder="Leave empty to use SEO Description"
                                            rows="3"
                                        />
                                        <x-admin.form.text-input
                                            name="app_seo_keywords"
                                            label="SEO Keywords (comma-separated)"
                                            :value="$settings['app_seo_keywords'] ?? ''"
                                            placeholder="articles, blog, news, insights"
                                        />
                                    </div>
                                </x-admin.card>
                            </div>

                            <!-- API Settings Panel -->
                            <div x-show="activeTab === 'api'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                                <x-admin.card>
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
                            </div>

                            <!-- Social Media Panel -->
                            <div x-show="activeTab === 'social'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                                <x-admin.card>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                        @foreach ($socialPlatforms as $platform => $data)
                                            <x-admin.form.text-input
                                                type="url"
                                                name="app_social{{ $platform }}"
                                                :label="$data['label']"
                                                :value="$settings['app_social'.$platform] ?? ''"
                                                :placeholder="'https://' . $data['url'] . '/username'">
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

                            <!-- Profitshare Panel -->
                            <div x-show="activeTab === 'profitshare'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                                <x-admin.card>
                                    <div class="grid grid-cols-1 gap-6">
                                        <x-admin.form.text-input    
                                            name="app_profitshare"  
                                            label="{{ __('admin.settings.profitshare_ro_id') }}"
                                            :value="$settings['app_profitshare'] ?? ''"
                                            required
                                        />
                                    </div>
                                </x-admin.card>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    @include('admin.settings.partials.tools-sidebar')
                </div>
            </div>
        </div>
    </div>

    <!-- Add the modal component at the bottom if needed -->
    <x-admin.modal-confirm-delete type="setting" />
</x-admin-layout>
