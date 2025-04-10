<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header
            icon="user-round-pen"
            title="{{ __('admin.partners.edit') }}"
            description="{{ __('admin.partners.update_partner_details') }}"
            :breadcrumbs="[
                ['label' => __('admin.settings.title'), 'url' => route('admin.settings.index')],
                ['label' => __('admin.partners.title'), 'url' => route('admin.partners.index')],
                ['label' => __('admin.partners.edit')]
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('admin.partners.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                    {{ __('admin.partners.back_to_partners') }}
                </a>
            </x-slot:actions>
        </x-admin.page-header>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.card>
                <form action="{{ route('admin.partners.update', $partner) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Name -->
                            <x-admin.form.text-input
                                name="name"
                                label="{{ __('admin.partners.name') }}"
                                :value="old('name', $partner->name)"
                                required
                            />

                            <!-- Link -->
                            <x-admin.form.text-input
                                name="link"
                                label="{{ __('admin.partners.link') }}"
                                :value="old('link', $partner->link)"
                                type="url"
                            />
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                            <x-admin.form.select
                                name="position"
                                label="{{ __('admin.partners.position') }}"
                                :options="\App\Http\Controllers\Admin\AdminPartnersController::POSITIONS"
                                :selected="old('position', $partner->position)"
                                required
                            >
                                <x-slot:help>
                                    {{ __('admin.partners.choose_where_this_partner_ad_will_be_displayed') }}
                                </x-slot:help>
                            </x-admin.form.select>

                            <x-admin.form.date-input
                                name="start_date"
                                label="{{ __('admin.partners.start_date') }}"
                                :value="old('start_date', $partner->start_date?->format('Y-m-d'))"
                                :help="'When this ad should start showing'"
                            />

                            <x-admin.form.date-input
                                name="expiration_date"
                                label="{{ __('admin.partners.expiration_date') }}"
                                :value="old('expiration_date', $partner->expiration_date?->format('Y-m-d'))"
                                :help="'When this ad should stop showing'"
                            />
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Image -->
                            <x-admin.form.file-input
                                name="image"
                                label="{{ __('admin.partners.image') }}"
                                :currentImage="$partner->image ? asset('storage/' . $partner->image) : null"
                                :help="'Recommended size: 600x300px'"
                            />

                            <!-- Text -->
                            <div>
                                <x-admin.form.textarea
                                    name="text"
                                    label="{{ __('admin.partners.text') }}"
                                    :value="old('text', $partner->text)"
                                    rows="4"
                                />
                            </div>
                        </div>

                        <!-- SEO Settings -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">{{ __('admin.partners.link_settings') }}</h4>
                            <div class="space-y-6">
                                <!-- Link Target -->
                                <div>
                                    <x-admin.form.select
                                        name="seo[target]"
                                        label="{{ __('admin.partners.link_target') }}"
                                        :options="[
                                            '_blank' => 'New Window (_blank)',
                                            '_self' => 'Same Window (_self)'
                                        ]"
                                        :selected="old('seo.target', $partner->seo['target'] ?? '_blank')"
                                    >
                                        <x-slot:help>
                                            {{ __('admin.partners.choose_how_the_partner_link_will_open_when_clicked') }}
                                        </x-slot:help>
                                    </x-admin.form.select>
                                </div>

                                <!-- Link Rel -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('admin.partners.link_attributes') }}</label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                        {{ __('admin.partners.select_the_relationship_attributes_for_the_link') }}
                                    </p>
                                    <div class="space-y-2">
                                        @php
                                            $relAttributes = ['nofollow', 'sponsored', 'noopener', 'noreferrer'];
                                            $currentRels = isset($partner->seo['rel']) ? 
                                                (is_array($partner->seo['rel']) ? 
                                                    $partner->seo['rel'] : 
                                                    explode(' ', $partner->seo['rel'])
                                                ) : [];
                                        @endphp
                                        
                                        @foreach($relAttributes as $rel)
                                            <label class="inline-flex items-center mr-4">
                                                <input type="checkbox" 
                                                       name="seo[rel][]" 
                                                       value="{{ $rel }}"
                                                       {{ in_array($rel, $currentRels) ? 'checked' : '' }}
                                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $rel }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- UTM Parameters -->
                                <div class="space-y-4">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('admin.partners.utm_parameters') }}</label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ __('admin.partners.add_tracking_parameters_to_the_partner_link') }}
                                    </p>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <x-admin.form.text-input
                                            name="seo[utm_source]"
                                            label="{{ __('admin.partners.utm_source') }}"
                                            :value="old('seo.utm_source', $partner->seo['utm_source'] ?? '')"
                                            placeholder="e.g., partner_website"
                                        >
                                            <x-slot:help>
                                                {{ __('admin.partners.identifies_which_site_sent_the_traffic') }}
                                            </x-slot:help>
                                        </x-admin.form.text-input>

                                        <x-admin.form.text-input
                                            name="seo[utm_medium]"
                                            label="{{ __('admin.partners.utm_medium') }}"
                                            :value="old('seo.utm_medium', $partner->seo['utm_medium'] ?? '')"
                                            placeholder="e.g., banner"
                                        >
                                            <x-slot:help>
                                                {{ __('admin.partners.identifies_what_type_of_link_was_used') }}
                                            </x-slot:help>
                                        </x-admin.form.text-input>

                                        <x-admin.form.text-input
                                            name="seo[utm_campaign]"
                                            label="{{ __('admin.partners.utm_campaign') }}"
                                            :value="old('seo.utm_campaign', $partner->seo['utm_campaign'] ?? '')"
                                            placeholder="e.g., spring_sale"
                                        >
                                            <x-slot:help>
                                                {{ __('admin.partners.identifies_a_specific_product_promotion_or_strategic_campaign') }}
                                            </x-slot:help>
                                        </x-admin.form.text-input>

                                        <x-admin.form.text-input
                                            name="seo[utm_term]"
                                            label="{{ __('admin.partners.utm_term') }}"
                                            :value="old('seo.utm_term', $partner->seo['utm_term'] ?? '')"
                                            placeholder="e.g., running+shoes"
                                        >
                                            <x-slot:help>
                                                {{ __('admin.partners.identifies_search_terms') }}
                                            </x-slot:help>
                                        </x-admin.form.text-input>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-6 flex justify-end">
                        <x-admin.form.submit-button>
                            <x-lucide-save class="w-4 h-4 mr-2" />
                            {{ __('admin.partners.update_partner') }}
                        </x-admin.form.submit-button>
                    </div>
                </form>
            </x-admin.card>
        </div>
    </div>
</x-admin-layout>