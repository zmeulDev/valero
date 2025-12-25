<x-admin-layout>
    <div x-data="{
        showDeleteModal: false,
        itemToDelete: null,
        
        openDeleteModal(id) {
            $dispatch('open-delete-modal', id);
        }
    }">
        <x-slot name="header">
            <x-admin.page-header icon="list" title="{{ __('admin.playlists.title') }}" description="{{ __('admin.playlists.description') }}"
                :breadcrumbs="[['label' => __('admin.playlists.title')]]">
                <x-slot:actions>
                    <a href="{{ route('admin.playlists.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        <x-lucide-plus-circle class="w-4 h-4 mr-2" />
                        {{ __('admin.playlists.new_playlist') }}
                    </a>
                </x-slot:actions>
            </x-admin.page-header>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                @if($playlists->count() > 0)
                    <div
                        class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('admin.common.title') }}</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('admin.common.slug') }}</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('admin.playlists.articles_count') }}</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            {{ __('admin.status.created_at') }}</th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($playlists as $playlist)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $playlist->title }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ Str::limit($playlist->description, 50) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $playlist->slug }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    {{ $playlist->articles_count }} {{ strtolower(__('admin.playlists.articles_count')) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $playlist->created_at->format('M j, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end items-center space-x-3">
                                                    <a href="{{ route('admin.playlists.edit', $playlist) }}"
                                                        class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300"
                                                        title="{{ __('admin.common.edit') }}">
                                                        <x-lucide-pencil class="h-5 w-5" />
                                                    </a>
                                                    <button @click="openDeleteModal({{ $playlist->id }})"
                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                        title="{{ __('admin.common.delete') }}">
                                                        <x-lucide-trash class="h-5 w-5" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <x-lucide-list class="mx-auto h-12 w-12 text-gray-400" />
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('admin.playlists.no_playlists') }}</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('admin.playlists.description') }}</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.playlists.create') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                <x-lucide-plus class="w-4 h-4 mr-2" />
                                {{ __('admin.playlists.create_playlist') }}
                            </a>
                        </div>
                    </div>
                @endif

                <div class="mt-6">
                    {{ $playlists->links() }}
                </div>
            </div>
        </div>

        <x-admin.modal-confirm-delete type="playlist" />
    </div>
</x-admin-layout>