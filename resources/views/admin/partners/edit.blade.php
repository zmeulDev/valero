<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header
            icon="user-round-pen"
            title="Edit Partner"
            description="Update partner advertisement details"
            :breadcrumbs="[
                ['label' => 'Settings', 'url' => route('admin.settings.index')],
                ['label' => 'Partners', 'url' => route('admin.partners.index')],
                ['label' => 'Edit Partner']
            ]"
        >
            <x-slot:actions>
                <a href="{{ route('admin.partners.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                    Back to Partners
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
                                label="Name"
                                :value="old('name', $partner->name)"
                                required
                            />

                            <!-- Link -->
                            <x-admin.form.text-input
                                name="link"
                                label="Link"
                                :value="old('link', $partner->link)"
                                type="url"
                            />
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                            <x-admin.form.select
                                name="position"
                                label="Position"
                                :options="\App\Http\Controllers\Admin\AdminPartnersController::POSITIONS"
                                :selected="old('position', $partner->position)"
                                required
                            >
                                <x-slot:help>
                                    Choose where this partner ad will be displayed
                                </x-slot:help>
                            </x-admin.form.select>

                            <x-admin.form.date-input
                                name="start_date"
                                label="Start Date"
                                :value="old('start_date', $partner->start_date?->format('Y-m-d'))"
                                :help="'When this ad should start showing'"
                            />

                            <x-admin.form.date-input
                                name="expiration_date"
                                label="Expiration Date"
                                :value="old('expiration_date', $partner->expiration_date?->format('Y-m-d'))"
                                :help="'When this ad should stop showing'"
                            />
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Image -->
                            <x-admin.form.file-input
                                name="image"
                                label="Image"
                                :currentImage="$partner->image ? asset('storage/' . $partner->image) : null"
                                :help="'Recommended size: 600x300px'"
                            />

                            <!-- Text -->
                            <div>
                                <x-admin.form.textarea
                                    name="text"
                                    label="Text"
                                    :value="old('text', $partner->text)"
                                    rows="4"
                                />
                            </div>
                        </div>

                        <!-- SEO Settings -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Link Settings</h4>
                            <div class="space-y-6">
                                <!-- Link Target -->
                                <div>
                                    <x-admin.form.select
                                        name="seo[target]"
                                        label="Link Target"
                                        :options="[
                                            '_blank' => 'New Window (_blank)',
                                            '_self' => 'Same Window (_self)'
                                        ]"
                                        :selected="old('seo.target', $partner->seo['target'] ?? '_blank')"
                                    >
                                        <x-slot:help>
                                            Choose how the partner link will open when clicked
                                        </x-slot:help>
                                    </x-admin.form.select>
                                </div>

                                <!-- Link Rel -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Link Attributes</label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                        Select the relationship attributes for the link
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
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">UTM Parameters</label>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Add tracking parameters to the partner link
                                    </p>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <x-admin.form.text-input
                                            name="seo[utm_source]"
                                            label="UTM Source"
                                            :value="old('seo.utm_source', $partner->seo['utm_source'] ?? '')"
                                            placeholder="e.g., partner_website"
                                        >
                                            <x-slot:help>
                                                Identifies which site sent the traffic
                                            </x-slot:help>
                                        </x-admin.form.text-input>

                                        <x-admin.form.text-input
                                            name="seo[utm_medium]"
                                            label="UTM Medium"
                                            :value="old('seo.utm_medium', $partner->seo['utm_medium'] ?? '')"
                                            placeholder="e.g., banner"
                                        >
                                            <x-slot:help>
                                                Identifies what type of link was used
                                            </x-slot:help>
                                        </x-admin.form.text-input>

                                        <x-admin.form.text-input
                                            name="seo[utm_campaign]"
                                            label="UTM Campaign"
                                            :value="old('seo.utm_campaign', $partner->seo['utm_campaign'] ?? '')"
                                            placeholder="e.g., spring_sale"
                                        >
                                            <x-slot:help>
                                                Identifies a specific product promotion or strategic campaign
                                            </x-slot:help>
                                        </x-admin.form.text-input>

                                        <x-admin.form.text-input
                                            name="seo[utm_term]"
                                            label="UTM Term"
                                            :value="old('seo.utm_term', $partner->seo['utm_term'] ?? '')"
                                            placeholder="e.g., running+shoes"
                                        >
                                            <x-slot:help>
                                                Identifies search terms
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
                            Update Partner
                        </x-admin.form.submit-button>
                    </div>
                </form>
            </x-admin.card>
        </div>
    </div>
</x-admin-layout>