<x-admin-layout>
    <x-slot name="header">
        <x-admin.page-header
            icon="user"
            title="{{ __('Profile Settings') }}"
            description="Manage your account settings and security preferences"
        >
            <x-slot:actions>
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2" />
                    {{ __('Back to Dashboard') }}
                </a>
            </x-slot:actions>
        </x-admin.page-header>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Profile Header Card -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="px-6 py-8">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                        <!-- Profile Photo -->
                        <div class="relative flex-shrink-0">
                            <img class="h-24 w-24 rounded-full object-cover border-4 border-white shadow-xl" 
                                 src="{{ auth()->user()->profile_photo_url }}" 
                                 alt="{{ auth()->user()->name }}" />
                            <div class="absolute bottom-0 right-0 h-6 w-6 rounded-full bg-green-400 border-4 border-white"></div>
                        </div>

                        <!-- User Info -->
                        <div class="flex-1 text-center sm:text-left">
                            <h2 class="text-2xl font-bold text-white">
                                {{ auth()->user()->name }}
                            </h2>
                            <p class="text-indigo-100 mt-1">{{ auth()->user()->email }}</p>
                            
                            <div class="mt-4 flex flex-wrap gap-3 justify-center sm:justify-start">
                                <div class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm">
                                    <x-lucide-shield class="w-4 h-4 text-white mr-2" />
                                    <span class="text-sm font-medium text-white">{{ ucfirst(auth()->user()->role) }}</span>
                                </div>
                                <div class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm">
                                    <x-lucide-calendar class="w-4 h-4 text-white mr-2" />
                                    <span class="text-sm font-medium text-white">{{ __('Member since') }} {{ auth()->user()->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabbed Content -->
            <div x-data="{ activeTab: 'profile' }">
                <!-- Tab Navigation -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <nav class="-mb-px flex space-x-2 px-4 overflow-x-auto" aria-label="Tabs">
                            <!-- Profile Tab -->
                            <button 
                                type="button"
                                @click="activeTab = 'profile'"
                                :class="activeTab === 'profile' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="group inline-flex items-center py-4 px-3 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                                <x-lucide-user 
                                    :class="activeTab === 'profile' ? 'text-indigo-500 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300'"
                                    class="w-5 h-5 mr-2 transition-colors" />
                                <span>{{ __('Profile') }}</span>
                            </button>

                            <!-- Password Tab -->
                            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                                <button 
                                    type="button"
                                    @click="activeTab = 'password'"
                                    :class="activeTab === 'password' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                    class="group inline-flex items-center py-4 px-3 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                                    <x-lucide-lock 
                                        :class="activeTab === 'password' ? 'text-indigo-500 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300'"
                                        class="w-5 h-5 mr-2 transition-colors" />
                                    <span>{{ __('Password') }}</span>
                                </button>
                            @endif

                            <!-- Two Factor Tab -->
                            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                                <button 
                                    type="button"
                                    @click="activeTab = 'two-factor'"
                                    :class="activeTab === 'two-factor' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                    class="group inline-flex items-center py-4 px-3 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                                    <x-lucide-shield-check 
                                        :class="activeTab === 'two-factor' ? 'text-indigo-500 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300'"
                                        class="w-5 h-5 mr-2 transition-colors" />
                                    <span>{{ __('Two-Factor') }}</span>
                                </button>
                            @endif

                            <!-- Sessions Tab -->
                            <button 
                                type="button"
                                @click="activeTab = 'sessions'"
                                :class="activeTab === 'sessions' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                class="group inline-flex items-center py-4 px-3 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                                <x-lucide-monitor 
                                    :class="activeTab === 'sessions' ? 'text-indigo-500 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300'"
                                    class="w-5 h-5 mr-2 transition-colors" />
                                <span>{{ __('Sessions') }}</span>
                            </button>

                            <!-- Delete Account Tab -->
                            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                                <button 
                                    type="button"
                                    @click="activeTab = 'delete'"
                                    :class="activeTab === 'delete' ? 'border-red-500 text-red-600 dark:text-red-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300'"
                                    class="group inline-flex items-center py-4 px-3 border-b-2 font-medium text-sm transition-colors whitespace-nowrap">
                                    <x-lucide-alert-triangle 
                                        :class="activeTab === 'delete' ? 'text-red-500 dark:text-red-400' : 'text-gray-400 group-hover:text-gray-500 dark:group-hover:text-gray-300'"
                                        class="w-5 h-5 mr-2 transition-colors" />
                                    <span>{{ __('Delete Account') }}</span>
                                </button>
                            @endif
                        </nav>
                    </div>
                </div>

                <!-- Tab Panels -->
                <div class="space-y-6">
                    <!-- Profile Information Panel -->
                    @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                        <div x-show="activeTab === 'profile'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                            @livewire('profile.update-profile-information-form')
                        </div>
                    @endif

                    <!-- Password Panel -->
                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                        <div x-show="activeTab === 'password'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                            @livewire('profile.update-password-form')
                        </div>
                    @endif

                    <!-- Two Factor Authentication Panel -->
                    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                        <div x-show="activeTab === 'two-factor'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                            @livewire('profile.two-factor-authentication-form')
                        </div>
                    @endif

                    <!-- Browser Sessions Panel -->
                    <div x-show="activeTab === 'sessions'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                        @livewire('profile.logout-other-browser-sessions-form')
                    </div>

                    <!-- Delete Account Panel -->
                    @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                        <div x-show="activeTab === 'delete'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100">
                            @livewire('profile.delete-user-form')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
