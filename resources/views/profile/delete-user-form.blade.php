<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
    <div class="p-6">
        <!-- Warning Alert -->
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg">
            <div class="flex items-start">
                <x-lucide-alert-triangle class="w-6 h-6 text-red-500 mt-0.5 mr-3 flex-shrink-0" />
                <div>
                    <h4 class="text-sm font-semibold text-red-800 dark:text-red-300 mb-1">
                        {{ __('Danger Zone') }}
                    </h4>
                    <p class="text-sm text-red-700 dark:text-red-400">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
            <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                    {{ __('Delete This Account') }}
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    {{ __('This action cannot be undone.') }}
                </p>
            </div>
            <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled" class="flex items-center ml-4">
                <x-lucide-trash-2 class="w-4 h-4 mr-2" />
                {{ __('Delete Account') }}
            </x-danger-button>
        </div>

        <!-- Delete User Confirmation Modal -->
        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">
                <div class="flex items-center">
                    <x-lucide-alert-triangle class="w-6 h-6 text-red-500 mr-2" />
                    {{ __('Delete Account') }}
                </div>
            </x-slot>

            <x-slot name="content">
                <div class="space-y-4">
                    {{ __('Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}

                    <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                        <div class="relative">
                            <x-input type="password" 
                                    class="mt-1 block w-3/4"
                                    autocomplete="current-password"
                                    placeholder="{{ __('Password') }}"
                                    x-ref="password"
                                    wire:model="password"
                                    wire:keydown.enter="deleteUser" />
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <x-lucide-lock class="h-5 w-5 text-gray-400" />
                            </div>
                        </div>
                        <x-input-error for="password" class="mt-2" />
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-button-secondary wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-button-secondary>

                <x-danger-button class="ml-3" wire:click="deleteUser" wire:loading.attr="disabled">
                    <x-lucide-trash-2 class="w-4 h-4 mr-2" />
                    {{ __('Delete Account') }}
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </div>
</div>
