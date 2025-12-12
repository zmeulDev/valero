<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
    <form wire:submit="updatePassword" class="p-6 space-y-6">
        <div class="mb-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </div>
        <div>
            <x-label for="current_password" value="{{ __('Current Password') }}" />
            <div class="relative">
                <x-input id="current_password" 
                        type="password" 
                        class="mt-1 block w-full" 
                        wire:model="state.current_password" 
                        autocomplete="current-password" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <x-lucide-key class="w-5 h-5 text-gray-400" />
                </div>
            </div>
            <x-input-error for="current_password" class="mt-2" />
        </div>

        <div>
            <x-label for="password" value="{{ __('New Password') }}" />
            <div class="relative">
                <x-input id="password" 
                        type="password" 
                        class="mt-1 block w-full" 
                        wire:model="state.password" 
                        autocomplete="new-password" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <x-lucide-lock class="w-5 h-5 text-gray-400" />
                </div>
            </div>
            <x-input-error for="password" class="mt-2" />
        </div>

        <div>
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <div class="relative">
                <x-input id="password_confirmation" 
                        type="password" 
                        class="mt-1 block w-full" 
                        wire:model="state.password_confirmation" 
                        autocomplete="new-password" />
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <x-lucide-check class="w-5 h-5 text-gray-400" />
                </div>
            </div>
            <x-input-error for="password_confirmation" class="mt-2" />
        </div>

        <div class="flex items-center justify-end">
            <x-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button>
                <x-lucide-save class="w-4 h-4 mr-2" />
                {{ __('Save') }}
            </x-button>
        </div>
    </form>
</div>
