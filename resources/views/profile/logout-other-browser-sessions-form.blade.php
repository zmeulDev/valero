<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
    <div class="p-6 space-y-6">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
        </div>

        @if (count($this->sessions) > 0)
            <div class="mt-5 space-y-6">
                <!-- Other Browser Sessions -->
                @foreach ($this->sessions as $session)
                    <div class="flex items-center">
                        <div>
                            @if ($session->agent->isDesktop())
                                <x-lucide-monitor class="w-8 h-8 text-gray-500" />
                            @else
                                <x-lucide-smartphone class="w-8 h-8 text-gray-500" />
                            @endif
                        </div>

                        <div class="ml-3">
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }} - 
                                {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                            </div>

                            <div>
                                <div class="text-xs text-gray-500">
                                    {{ $session->ip_address }},

                                    @if ($session->is_current_device)
                                        <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                    @else
                                        {{ __('Last active') }} {{ $session->last_active }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex items-center mt-5">
            <x-button wire:click="confirmLogout" wire:loading.attr="disabled">
                <x-lucide-log-out class="w-4 h-4 mr-2" />
                {{ __('Log Out Other Browser Sessions') }}
            </x-button>

            <x-action-message class="ml-3" on="loggedOut">
                {{ __('Done.') }}
            </x-action-message>
        </div>
    </div>

    <!-- Log Out Other Devices Confirmation Modal -->
    <x-dialog-modal wire:model.live="confirmingLogout">
        <x-slot name="title">
            <div class="flex items-center">
                <x-lucide-log-out class="w-6 h-6 mr-2 text-gray-500" />
                {{ __('Log Out Other Browser Sessions') }}
            </div>
        </x-slot>

        <x-slot name="content">
            {{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}

            <div class="mt-4">
                <x-input type="password" 
                         class="mt-1 block w-3/4"
                         autocomplete="current-password"
                         placeholder="{{ __('Password') }}"
                         x-ref="password"
                         wire:model="password"
                         wire:keydown.enter="logoutOtherBrowserSessions" />

                <x-input-error for="password" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-button-secondary wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-button-secondary>

            <x-button class="ml-3" wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled">
                {{ __('Log Out Other Browser Sessions') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
