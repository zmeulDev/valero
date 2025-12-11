<x-guest-layout>
    <x-auth.card>
        <x-slot name="logo">
            <x-auth.logo />
        </x-slot>

        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ __('frontend.auth.confirm_password') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ __('frontend.auth.confirm_password_description') }}
            </p>
        </div>

        <!-- Validation Errors -->
        <x-validation-errors class="mb-6" />

        <!-- Confirm Password Form -->
        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6" x-data="authForm()">
            @csrf

            <!-- Password Field -->
            <div>
                <x-label for="password" value="{{ __('frontend.auth.password') }}" class="text-gray-900 dark:text-white" />
                <div class="mt-2 relative">
                    <x-input 
                        id="password"
                        x-bind:type="showPassword ? 'text' : 'password'"
                        name="password" 
                        required 
                        autocomplete="current-password"
                        autofocus
                        placeholder="{{ __('frontend.auth.enter_password') }}"
                        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200"
                    />
                    <button 
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                        <svg x-show="!showPassword" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg x-show="showPassword" x-cloak class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <x-button 
                    type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    {{ __('frontend.auth.confirm') }}
                </x-button>
            </div>
        </form>
    </x-auth.card>
</x-guest-layout>
