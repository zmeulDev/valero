<x-guest-layout>
    <x-auth.card>
        <x-slot name="logo">
            <x-auth.logo />
        </x-slot>

        <div x-data="{ recovery: false }">
            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    {{ __('frontend.auth.two_factor_challenge') }}
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400" x-show="!recovery">
                    {{ __('frontend.auth.two_factor_description') }}
                </p>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400" x-cloak x-show="recovery">
                    {{ __('frontend.auth.recovery_code_description') }}
                </p>
            </div>

            <!-- Validation Errors -->
            <x-validation-errors class="mb-6" />

            <!-- Two-Factor Form -->
            <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-6">
                @csrf

                <!-- Authentication Code -->
                <div x-show="!recovery">
                    <x-label for="code" value="{{ __('frontend.auth.code') }}" class="text-gray-900 dark:text-white" />
                    <div class="mt-2">
                        <x-input 
                            id="code"
                            type="text" 
                            name="code" 
                            inputmode="numeric"
                            autofocus
                            x-ref="code"
                            autocomplete="one-time-code"
                            placeholder="{{ __('frontend.auth.enter_code') }}"
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200 text-center text-2xl tracking-widest font-mono"
                        />
                    </div>
                </div>

                <!-- Recovery Code -->
                <div x-cloak x-show="recovery">
                    <x-label for="recovery_code" value="{{ __('frontend.auth.recovery_code') }}" class="text-gray-900 dark:text-white" />
                    <div class="mt-2">
                        <x-input 
                            id="recovery_code"
                            type="text" 
                            name="recovery_code" 
                            x-ref="recovery_code"
                            autocomplete="one-time-code"
                            placeholder="{{ __('frontend.auth.enter_recovery_code') }}"
                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-colors duration-200 text-center font-mono"
                        />
                    </div>
                </div>

                <!-- Toggle Link & Submit Button -->
                <div class="flex items-center justify-between gap-4">
                    <!-- Toggle Button -->
                    <button 
                        type="button" 
                        class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 underline transition-colors duration-200"
                        x-show="!recovery" 
                        @click="recovery = true; $nextTick(() => { $refs.recovery_code.focus() })">
                        {{ __('frontend.auth.use_recovery_code') }}
                    </button>

                    <button 
                        type="button" 
                        class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 underline transition-colors duration-200" 
                        x-cloak
                        x-show="recovery" 
                        @click="recovery = false; $nextTick(() => { $refs.code.focus() })">
                        {{ __('frontend.auth.use_authentication_code') }}
                    </button>

                    <!-- Submit Button -->
                    <x-button 
                        type="submit"
                        class="flex justify-center py-3 px-6 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                        {{ __('frontend.auth.log_in') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-auth.card>
</x-guest-layout>
