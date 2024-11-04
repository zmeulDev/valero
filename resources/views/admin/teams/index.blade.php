<x-admin-layout>
    <x-admin.data-manager :items="$users->items()">
        <x-slot name="header">
            <x-admin.page-header
                icon="users"
                title="{{ __('Team Management') }}"
                description="Manage your team members, their roles and permissions"
                :breadcrumbs="[['label' => 'Teams']]"
            >
                <x-slot:actions>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.teams.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            <x-lucide-user-plus class="w-4 h-4 mr-2" />
                            Add Member
                        </a>
                    </div>
                </x-slot:actions>

                <x-slot:stats>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <x-admin.stats-card 
                            icon="users" 
                            label="Total Members" 
                            :value="$users->total()" 
                        />
                        <x-admin.stats-card 
                            icon="shield" 
                            label="Admins" 
                            :value="$users->where('role', 'admin')->count()" 
                        />
                        <x-admin.stats-card 
                            icon="user" 
                            label="Regular Users" 
                            :value="$users->where('role', 'user')->count()" 
                        />
                    </div>
                </x-slot:stats>
            </x-admin.page-header>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-admin.table :headers="['Member', 'Role & Status', 'Articles & Activity', 'Actions']">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <div class="h-12 w-12 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center ring-2 ring-indigo-600/10 dark:ring-indigo-400/10">
                                            <x-lucide-user class="h-6 w-6 text-indigo-600 dark:text-indigo-400" />
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <x-admin.user-role-badge :role="$user->role" />
                                <x-admin.user-status-badge :active="$user->is_active" />
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $user->articles_count }} {{ Str::plural('Article', $user->articles_count) }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        Last active {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center space-x-3">
                                    <a href="{{ route('admin.teams.edit', $user) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        <x-lucide-pencil class="w-5 h-5" />
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <button type="button"
                                                @click="openDeleteModal({{ $user->id }})"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            <x-lucide-trash-2 class="w-5 h-5" />
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </x-admin.table>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        <!-- Delete Modal -->
        <x-admin.modal-confirm-delete type="team member" />
    </x-admin.data-manager>
</x-admin-layout>
