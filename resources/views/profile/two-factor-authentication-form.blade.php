<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
    <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
            @if ($this->enabled)
                @if ($showingConfirmation)
                    {{ __('Finish enabling two factor authentication.') }}
                @else
                    {{ __('You have enabled two factor authentication.') }}
                @endif
            @else
                {{ __('You have not enabled two factor authentication.') }}
            @endif
        </h3>

        <div class="mt-3 max-w-xl text-sm text-gray-600 dark:text-gray-400">
            <p>
                {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4">
                    <p class="font-semibold text-sm text-gray-600 dark:text-gray-400">
                        @if ($showingConfirmation)
                            {{ __('To finish enabling two factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.') }}
                        @else
                            {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application or enter the setup key.') }}
                        @endif
                    </p>

                    <div class="mt-4 p-4 inline-block bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                        {!! $this->user->twoFactorQrCodeSvg() !!}
                    </div>

                    <div class="mt-4 max-w-xl text-sm">
                        <p class="font-semibold text-gray-600 dark:text-gray-400">
                            {{ __('Setup Key') }}: <span class="font-mono text-sm">{{ decrypt($this->user->two_factor_secret) }}</span>
                        </p>
                    </div>

                    @if ($showingConfirmation)
                        <div class="mt-4">
                            <x-label for="code" value="{{ __('Code') }}" />
                            <div class="relative">
                                <x-input id="code" 
                                        type="text" 
                                        name="code" 
                                        class="block mt-1 w-1/2" 
                                        inputmode="numeric" 
                                        autofocus 
                                        autocomplete="one-time-code"
                                        wire:model="code"
                                        wire:keydown.enter="confirmTwoFactorAuthentication" />
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <x-lucide-key class="w-5 h-5 text-gray-400" />
                                </div>
                            </div>
                            <x-input-error for="code" class="mt-2" />
                        </div>
                    @endif
                </div>
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4">
                    <p class="font-semibold text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
                    </p>

                    <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                        <div class="grid gap-1 max-w-xl font-mono text-sm">
                            @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                                <div class="text-gray-600 dark:text-gray-400">{{ $code }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endif

        <div class="mt-5 space-x-3">
            @if (! $this->enabled)
                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <x-button type="button" wire:loading.attr="disabled">
                        <x-lucide-shield class="w-4 h-4 mr-2" />
                        {{ __('Enable') }}
                    </x-button>
                </x-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <x-button-secondary class="mr-3">
                            <x-lucide-refresh-cw class="w-4 h-4 mr-2" />
                            {{ __('Regenerate Recovery Codes') }}
                        </x-button-secondary>
                    </x-confirms-password>
                @elseif ($showingConfirmation)
                    <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                        <x-button type="button" class="mr-3" wire:loading.attr="disabled">
                            <x-lucide-check class="w-4 h-4 mr-2" />
                            {{ __('Confirm') }}
                        </x-button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showRecoveryCodes">
                        <x-button-secondary class="mr-3">
                            <x-lucide-key class="w-4 h-4 mr-2" />
                            {{ __('Show Recovery Codes') }}
                        </x-button-secondary>
                    </x-confirms-password>
                @endif

                @if ($showingConfirmation)
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-button-secondary wire:loading.attr="disabled">
                            {{ __('Cancel') }}
                        </x-button-secondary>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <x-danger-button wire:loading.attr="disabled">
                            <x-lucide-shield-off class="w-4 h-4 mr-2" />
                            {{ __('Disable') }}
                        </x-danger-button>
                    </x-confirms-password>
                @endif
            @endif
        </div>
    </div>
</div>
