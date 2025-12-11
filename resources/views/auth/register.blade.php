<x-guest-layout>
    <x-auth.card>
        <x-slot name="logo">
            <x-auth.logo />
        </x-slot>

        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ __('frontend.auth.create_account') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ __('frontend.auth.register_description') }}
            </p>
        </div>

        <!-- Validation Errors -->
        <x-validation-errors class="mb-6" />

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-6" x-data="authForm()">
            @csrf

            <!-- Name Field -->
            <div>
                <x-label for="name" value="{{ __('frontend.auth.name') }}" class="text-gray-900 dark:text-white" />
                <div class="mt-2">
                    <x-input 
                        id="name"
                        type="text" 
                        name="name" 
                        :value="old('name')" 
                        required 
                        autofocus 
                        autocomplete="name"
                        placeholder="{{ __('frontend.auth.enter_name') }}"
                        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200"
                    />
                </div>
            </div>

            <!-- Email Field -->
            <div>
                <x-label for="email" value="{{ __('frontend.auth.email') }}" class="text-gray-900 dark:text-white" />
                <div class="mt-2">
                    <x-input 
                        id="email"
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autocomplete="username"
                        placeholder="{{ __('frontend.auth.enter_email') }}"
                        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200"
                    />
                </div>
            </div>

            <!-- Password Field -->
            <div>
                <x-label for="password" value="{{ __('frontend.auth.password') }}" class="text-gray-900 dark:text-white" />
                <div class="mt-2 relative">
                    <x-input 
                        id="password"
                        x-bind:type="showPassword ? 'text' : 'password'"
                        name="password" 
                        required 
                        autocomplete="new-password"
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

            <!-- Password Confirmation Field -->
            <div>
                <x-label for="password_confirmation" value="{{ __('frontend.auth.password_confirmation') }}" class="text-gray-900 dark:text-white" />
                <div class="mt-2 relative">
                    <x-input 
                        id="password_confirmation"
                        x-bind:type="showPasswordConfirmation ? 'text' : 'password'"
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        placeholder="{{ __('frontend.auth.confirm_password') }}"
                        class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200"
                    />
                    <button 
                        type="button"
                        @click="showPasswordConfirmation = !showPasswordConfirmation"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                        <svg x-show="!showPasswordConfirmation" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <svg x-show="showPasswordConfirmation" x-cloak class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Terms and Privacy (if enabled) -->
            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <x-checkbox 
                            id="terms" 
                            name="terms" 
                            required
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded cursor-pointer"
                        />
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-gray-700 dark:text-gray-300 cursor-pointer">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<a href="'.route('terms.show').'" target="_blank" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">'.__('Terms of Service').'</a>',
                                'privacy_policy' => '<a href="'.route('policy.show').'" target="_blank" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </label>
                    </div>
                </div>
            @endif

            <!-- Submit Button -->
            <div>
                <x-button 
                    type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    {{ __('frontend.auth.register') }}
                </x-button>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('frontend.auth.already_registered') }}
                    <a href="{{ route('login') }}" 
                       class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors duration-200">
                        {{ __('frontend.auth.sign_in') }}
                    </a>
                </p>
            </div>
        </form>
    </x-auth.card>
</x-guest-layout>
