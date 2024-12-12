<x-admin-layout>

<div x-data="{
        showDeleteModal: false,
        itemToDelete: null,
        items: {{ $users->items() ? json_encode($users->items()) : '[]' }},
        
        openDeleteModal(id) {
            $dispatch('open-delete-modal', id);
        }
    }">

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
                <!-- Search Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
                    <div class="p-4 sm:p-6">
                        <!-- Search Bar -->
                        <form method="GET" action="{{ route('admin.teams.index') }}" 
                              x-data="{ 
                                  query: '{{ request('search') }}',
                                  updateSearch: function(value) {
                                      this.query = value;
                                      clearTimeout(this.timeout);
                                      this.timeout = setTimeout(() => {
                                          this.$refs.searchForm.submit();
                                      }, 300);
                                  }
                              }" 
                              x-ref="searchForm"
                              class="relative max-w-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-lucide-search class="h-5 w-5 text-gray-400" />
                            </div>
                            <input type="text"
                                   name="search"
                                   x-model="query"
                                   @input="updateSearch($event.target.value)"
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent sm:text-sm transition-colors duration-200"
                                   placeholder="Search team members..."
                                   x-ref="searchInput">
                            @if(request('search'))
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <a href="{{ route('admin.teams.index') }}" 
                                       class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"
                                       title="Clear search">
                                        <x-lucide-x class="h-5 w-5" />
                                    </a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Member
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Role & Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Activity
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($users as $user)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700" 
                                                         src="{{ $user->profile_photo_url }}" 
                                                         alt="{{ $user->name }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $user->name }}
                                                    </div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col gap-2">
                                                <span @class([
                                                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                                    'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300' => $user->role === 'admin',
                                                    'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300' => $user->role === 'editor',
                                                    'bg-gray-100 text-gray-800 dark:bg-gray-900/50 dark:text-gray-300' => $user->role === 'user',
                                                ])>
                                                    <x-lucide-shield class="w-3.5 h-3.5 mr-1" />
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                                <span @class([
                                                    'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                                    'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300' => $user->is_active,
                                                    'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300' => !$user->is_active,
                                                ])>
                                                    @if($user->is_active)
                                                        <x-lucide-check-circle class="w-3.5 h-3.5 mr-1" />
                                                        Active
                                                    @else
                                                        <x-lucide-x-circle class="w-3.5 h-3.5 mr-1" />
                                                        Inactive
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col gap-1">
                                                <span class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400">
                                                    <x-lucide-book-open class="w-4 h-4 mr-1.5" />
                                                    {{ $user->articles_count }} {{ Str::plural('Article', $user->articles_count) }}
                                                </span>
                                                <span class="inline-flex items-center text-xs text-gray-500 dark:text-gray-400">
                                                    <x-lucide-clock class="w-3.5 h-3.5 mr-1.5" />
                                                    {{ $user->last_login_at ? 'Last active ' . $user->last_login_at->diffForHumans() : 'Never logged in' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-3">
                                                <a href="{{ route('admin.teams.edit', $user) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                                   title="Edit member">
                                                    <x-lucide-pencil class="w-5 h-5" />
                                                </a>
                                                @if($user->id !== auth()->id())
                                                    <button @click="openDeleteModal({{ $user->id }})"
                                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                                            title="Delete member">
                                                        <x-lucide-trash class="w-5 h-5" />
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            <div class="flex flex-col items-center justify-center py-8">
                                                <x-lucide-users class="w-12 h-12 mb-4 text-gray-400" />
                                                <p class="text-sm">No team members found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Delete Modal -->
        <x-admin.modal-confirm-delete type="team member" />

</x-admin-layout>