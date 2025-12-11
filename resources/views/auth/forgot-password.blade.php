<x-guest-layout>
    <x-auth.card>
        <x-slot name="logo">
            <x-auth.logo />
        </x-slot>

        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ __('frontend.auth.forgot_password') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ __('frontend.auth.forgot_password_description') }}
            </p>
        </div>

        <!-- Status Message -->
        @session('status')
            <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
                <p class="text-sm font-medium text-green-600 dark:text-green-400">
                    {{ $value }}
                </p>
            </div>
        @endsession

        <!-- Validation Errors -->
        <x-validation-errors class="mb-6" />

        <!-- Forgot Password Form -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email Field -->
            <div>
                <x-label for="email" value="{{ __('frontend.auth.email') }}" class="text-gray-900 dark:text-white" />
                <div class="mt-2 relative">
                    <x-input 
                        id="email"
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        autocomplete="username"
                        placeholder="{{ __('frontend.auth.enter_email') }}"
                        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200"
                    />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <x-button 
                    type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    {{ __('frontend.auth.send_reset_link') }}
                </x-button>
            </div>

            <!-- Back to Login Link -->
            <div class="text-center">
                <a href="{{ route('login') }}" 
                   class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors duration-200">
                    ← {{ __('frontend.auth.back_to_login') }}
                </a>
            </div>
        </form>
    </x-auth.card>
</x-guest-layout>
