<x-admin-layout>
    <div x-data="{ 
        showDeleteModal: false,
        itemToDelete: null,
        openDeleteModal(id) {
            this.itemToDelete = id;
            this.showDeleteModal = true;
        }
    }">
        <x-slot name="header">
            <x-admin.page-header
                icon="users"
                title="{{ __('admin.partners.title') }}"
                description="{{ __('admin.partners.description') }}"
                :breadcrumbs="[
                    ['label' => __('admin.settings.title'), 'url' => route('admin.settings.index')],
                    ['label' => __('admin.partners.title')]
                ]"
            >
                <x-slot:actions>
                    <a href="{{ route('admin.partners.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <x-lucide-user-plus class="w-4 h-4 mr-2" />
                        {{ __('admin.partners.create') }}
                    </a>
                </x-slot:actions>
            </x-admin.page-header>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Search and Filter Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
                    <div class="p-4 sm:p-6 space-y-4">
                        <form method="GET" action="{{ route('admin.partners.index') }}" 
                              class="flex flex-col sm:flex-row gap-4">
                            <!-- Search Input -->
                            <div class="flex-1">
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <x-lucide-search class="h-5 w-5 text-gray-400" />
                                    </div>
                                    <input type="text"
                                           name="search"
                                           value="{{ request('search') }}"
                                           class="block w-full pl-10 pr-12 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                           placeholder="{{ __('admin.partners.search_partners') }}">
                                    @if(request('search'))
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <a href="{{ route('admin.partners.index') }}" class="text-gray-400 hover:text-gray-500">
                                                <x-lucide-x class="h-5 w-5" />
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Status Filter -->
                            <div class="sm:w-48">
                                <select name="status" 
                                        onchange="this.form.submit()"
                                        class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">{{ __('admin.partners.all_status') }}</option>
                                    @foreach($statusOptions as $value => $label)
                                        <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Position Filter -->
                            <div class="sm:w-48">
                                <select name="position" 
                                        onchange="this.form.submit()"
                                        class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">{{ __('admin.partners.all_positions') }}</option>
                                    @foreach(\App\Http\Controllers\Admin\AdminPartnersController::POSITIONS as $value => $label)
                                        <option value="{{ $value }}" {{ request('position') === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Trashed Filter -->
                            <div class="sm:w-48">
                                <select name="trashed" 
                                        onchange="this.form.submit()"
                                        class="block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    @foreach($trashedOptions as $value => $label)
                                        <option value="{{ $value }}" {{ request('trashed') === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Partners Table -->
                <x-admin.card>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Partner</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Link Settings</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Position</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Dates</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($partners as $partner)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    @if($partner->image)
                                                        <img src="{{ asset('storage/' . $partner->image) }}" 
                                                             alt="{{ $partner->name }}" 
                                                             class="h-10 w-10 rounded-lg object-cover">
                                                    @else
                                                        <div class="h-10 w-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                            <x-lucide-image class="h-6 w-6 text-gray-400" />
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $partner->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ Str::limit($partner->text, 50) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                <a href="{{ $partner->full_url }}" 
                                                   target="_blank" 
                                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">
                                                    {{ Str::limit($partner->link, 30) }}
                                                </a>
                                            </div>
                                            <div class="mt-1 text-xs text-gray-500 dark:text-gray-400 space-y-1">
                                                <div>Target: <span class="font-mono">{{ $partner->target_attribute }}</span></div>
                                                <div>Rel: <span class="font-mono">{{ $partner->rel_attribute }}</span></div>
                                                @if(!empty($partner->seo['utm_source']))
                                                    <div>UTM: {{ $partner->seo['utm_source'] }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $status = $controller->getPartnerStatus($partner);
                                            @endphp
                                            
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status['classes'] }}"
                                                  data-partner-id="{{ $partner->id }}"
                                                  data-status="{{ $status['status'] }}">
                                                <x-dynamic-component :component="'lucide-' . $status['icon']" class="w-4 h-4 mr-1" />
                                                {{ $status['label'] }}
                                            </span>
                                            
                                            @if($partner->expiration_date)
                                                <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                                    Until {{ $partner->expiration_date->format('M d, Y') }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                {{ \App\Http\Controllers\Admin\AdminPartnersController::POSITIONS[$partner->position] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                @if($partner->start_date)
                                                    <div>Start: {{ $partner->start_date->format('M d, Y') }}</div>
                                                @endif
                                                @if($partner->expiration_date)
                                                    <div>End: {{ $partner->expiration_date->format('M d, Y') }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end items-center space-x-3">
                                                <!-- Edit is always available -->
                                                <a href="{{ route('admin.partners.edit', $partner->id) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300" 
                                                   title="Edit partner">
                                                    <x-lucide-pencil class="w-5 h-5" />
                                                </a>

                                                @if($partner->trashed())
                                                    <!-- Archived partners can be reactivated or permanently deleted -->
                                                    <form action="{{ route('admin.partners.restore', $partner->id) }}" 
                                                          method="POST" 
                                                          class="inline-block">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" 
                                                                title="Reactivate partner">
                                                            <x-lucide-refresh-cw class="w-5 h-5" />
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.partners.force-delete', $partner->id) }}" 
                                                          method="POST" 
                                                          class="inline-block"
                                                          onsubmit="return confirm('This will permanently delete the partner. Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" 
                                                                title="Delete partner">
                                                            <x-lucide-trash-2 class="w-5 h-5" />
                                                        </button>
                                                    </form>
                                                @else
                                                    @php
                                                        $status = $controller->getPartnerStatus($partner);
                                                    @endphp

                                                    @if($status['status'] === 'inactive')
                                                        <!-- Archive button for inactive partners -->
                                                        <form action="{{ route('admin.partners.destroy', $partner->id) }}" 
                                                              method="POST" 
                                                              class="inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300" 
                                                                    title="Archive inactive partner">
                                                                <x-lucide-archive class="w-5 h-5" />
                                                            </button>
                                                        </form>
                                                    
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col items-center justify-center py-8">
                                                <x-lucide-users class="w-12 h-12 mb-4 text-gray-400" />
                                                <p class="text-sm">{{ __('admin.partners.no_partners') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($partners->hasPages())
                        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                            {{ $partners->links() }}
                        </div>
                    @endif
                </x-admin.card>
            </div>
        </div>

        <!-- Delete Modal -->
        <x-admin.modal-confirm-delete 
            type="partner"
            x-show="showDeleteModal"
            @click.away="showDeleteModal = false"
        />
    </div>
</x-admin-layout>