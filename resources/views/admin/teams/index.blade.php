<x-admin-layout>
    <div x-data="teamManager()">
        <x-slot name="header">
            <x-admin.page-header
                icon="users"
                title="{{ __('Team Management') }}"
                description="Manage your team members, their roles and permissions"
                :breadcrumbs="[
                    ['label' => 'Teams']
                ]"
            >
                <x-slot:actions>
                    <a href="{{ route('admin.teams.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <x-lucide-user-plus class="w-4 h-4 mr-2" />
                        Add Member
                    </a>
                </x-slot:actions>

                <x-slot:stats>
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
                </x-slot:stats>
            </x-admin.page-header>
        </x-slot>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Member
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Role & Status
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Articles & Activity
                                    </th>
                                    <th scope="col" class="relative px-6 py-4">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
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
                                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-col space-y-1">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-200' : '' }}
                                                    {{ $user->role === 'editor' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200' : '' }}
                                                    {{ $user->role === 'user' ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200' : '' }}">
                                                    <span class="w-1.5 h-1.5 rounded-full 
                                                        {{ $user->role === 'admin' ? 'bg-purple-600' : '' }}
                                                        {{ $user->role === 'editor' ? 'bg-blue-600' : '' }}
                                                        {{ $user->role === 'user' ? 'bg-green-600' : '' }} 
                                                        mr-1.5">
                                                    </span>
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $user->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200' }}">
                                                    <span class="w-1.5 h-1.5 rounded-full 
                                                        {{ $user->is_active ? 'bg-green-600' : 'bg-red-600' }} 
                                                        mr-1.5">
                                                    </span>
                                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
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
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Member Modal -->
        <x-admin.modal name="add-member" :show="$errors->isNotEmpty()">
            <form action="{{ route('admin.teams.store') }}" method="POST" class="p-6">
                @csrf
                
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Add New Team Member
                </h2>

                <div class="space-y-6">
                    <x-admin.form.input
                        type="email"
                        name="email"
                        label="Email Address"
                        required
                        placeholder="member@example.com"
                    />

                    <x-admin.form.select
                        name="role"
                        label="Role"
                        :options="[
                            'user' => 'Regular User',
                            'editor' => 'Editor',
                            'admin' => 'Administrator'
                        ]"
                        required
                    />
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button"
                            @click="show = false"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Add Member
                    </button>
                </div>
            </form>
        </x-admin.modal>

        <!-- Delete Modal -->
        <x-admin.modal-confirm-delete 
            x-bind:show="showDeleteModal"
            x-bind:action="'/admin/teams/' + userToDelete"
            x-bind:name="userToDelete ? users.find(u => u.id === userToDelete)?.name : ''"
            type="team member"
        />
    </div>

    <script>
        function teamManager() {
            return {
                showDeleteModal: false,
                userToDelete: null,
                users: @json($users->items()),

                openDeleteModal(userId) {
                    this.userToDelete = userId;
                    this.showDeleteModal = true;
                }
            }
        }
    </script>
</x-admin-layout>
