<x-admin-layout>
    <x-slot name="header"> 
    <div class="bg-white">
            <div class="border-b border-t border-gray-200">
                <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <!-- Left side -->
                        <div class="flex-1 flex items-center">
                            <x-lucide-users class="w-8 h-8 text-indigo-600 mr-3" />
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 leading-7">
                                    {{ __('Team Management') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-500">
                                    Manage your team members, their roles and permissions
                                </p>
                            </div>
                        </div>

                        <!-- Right side -->
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.teams.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                <x-lucide-user-plus class="w-4 h-4 mr-2" />
                                Add Team Member
                            </a>
                        </div>
                    </div>

                    <!-- Breadcrumbs -->
                    <div class="py-4">
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol role="list" class="flex items-center space-x-4">
                                <li>
                                    <div>
                                        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-gray-500">
                                            <x-lucide-home class="flex-shrink-0 h-5 w-5" />
                                            <span class="sr-only">Home</span>
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <x-lucide-chevron-right class="flex-shrink-0 h-5 w-5 text-gray-400" />
                                        <a href="#" class="ml-4 text-sm font-medium text-indigo-600 hover:text-indigo-700">Team Management</a>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 py-4">
                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                                    <x-lucide-users class="h-6 w-6 text-indigo-600" />
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-500">Total Members</div>
                                    <div class="text-lg font-semibold text-gray-900">{{ $users->total() }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                    <x-lucide-check-circle class="h-6 w-6 text-green-600" />
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-500">Active Members</div>
                                    <div class="text-lg font-semibold text-gray-900">
                                        {{ $users->where('is_active', true)->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                                    <x-lucide-shield class="h-6 w-6 text-purple-600" />
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-500">Admins</div>
                                    <div class="text-lg font-semibold text-gray-900">
                                        {{ $users->where('role', 'admin')->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Team Members Table -->
            <div class="bg-white shadow-sm rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role & Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Last Activity
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" 
                                                     src="{{ $user->profile_photo_url }}" 
                                                     alt="{{ $user->name }}">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $user->email }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                                   ($user->role === 'editor' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                <x-lucide-shield class="w-3 h-3 mr-1" />
                                                {{ ucfirst($user->role) }}
                                            </span>
                                            <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                <x-lucide-{{ $user->is_active ? 'check-circle' : 'x-circle' }} class="w-3 h-3 mr-1" />
                                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            Member since {{ $user->created_at->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('admin.teams.edit', $user) }}" 
                                               class="text-indigo-600 hover:text-indigo-900 inline-flex items-center">
                                                <x-lucide-pencil class="w-4 h-4 mr-1" />
                                                Edit
                                            </a>
                                            @if ($user->id !== auth()->id())
                                                <button type="button"
                                                        x-data
                                                        x-on:click="$dispatch('open-modal', 'confirm-user-deletion-{{ $user->id }}')"
                                                        class="text-red-600 hover:text-red-900 inline-flex items-center">
                                                    <x-lucide-trash-2 class="w-4 h-4 mr-1" />
                                                    Delete
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modals -->
    @foreach ($users as $user)
        @if ($user->id !== auth()->id())
            <div x-data="{ show: false }"
                 x-show="show"
                 x-cloak
                 @open-modal.window="if ($event.detail === 'confirm-user-deletion-{{ $user->id }}') show = true"
                 class="relative z-50"
                 aria-labelledby="modal-title" 
                 role="dialog" 
                 aria-modal="true">
                <!-- Background backdrop -->
                <div x-show="show" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="fixed inset-0 z-50 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div x-show="show"
                             x-transition:enter="ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave="ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             @click.away="show = false"
                             @keydown.escape.window="show = false"
                             class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                            
                            <!-- Modal Header -->
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <x-lucide-alert-triangle class="h-6 w-6 text-red-600" />
                                    </div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
                                            Delete Team Member
                                        </h3>
                                        
                                        <!-- User Info -->
                                        <div class="mt-4 flex items-center space-x-4">
                                            <img class="h-12 w-12 rounded-full" 
                                                 src="{{ $user->profile_photo_url }}" 
                                                 alt="{{ $user->name }}">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                            </div>
                                        </div>

                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">
                                                Are you sure you want to delete this team member? This action cannot be undone.
                                                All of their data will be permanently removed from the system.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <form action="{{ route('admin.teams.destroy', $user) }}" 
                                      method="POST" 
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                                        <x-lucide-trash-2 class="w-4 h-4 mr-2" />
                                        Delete Member
                                    </button>
                                </form>
                                <button type="button" 
                                        @click="show = false"
                                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</x-admin-layout>
