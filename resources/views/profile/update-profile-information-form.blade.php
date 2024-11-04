<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    {{ __('Profile Information') }}
                </h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Update your account\'s profile information and email address.') }}
                </p>
            </div>
            <div class="flex-shrink-0">
                <x-lucide-user class="w-8 h-8 text-gray-400" />
            </div>
        </div>
    </div>

    <form wire:submit="updateProfileInformation" class="p-6 space-y-6">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}">
                <!-- Profile Photo -->
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        <!-- Current Profile Photo -->
                        <div class="relative">
                            <img src="{{ $this->user->profile_photo_url }}" 
                                 alt="{{ $this->user->name }}" 
                                 class="h-16 w-16 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700">
                            
                            @if ($this->user->profile_photo_path)
                                <button type="button" 
                                        wire:click="deleteProfilePhoto" 
                                        class="absolute -top-2 -right-2 bg-red-100 rounded-full p-1 text-red-600 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <x-lucide-x class="w-4 h-4" />
                                </button>
                            @endif
                        </div>
                    </div>

                    <div>
                        <x-button-secondary type="button" x-on:click.prevent="$refs.photo.click()">
                            <x-lucide-camera class="w-4 h-4 mr-2" />
                            {{ __('Change Photo') }}
                        </x-button-secondary>

                        <input type="file" 
                               class="hidden"
                               wire:model.live="photo"
                               x-ref="photo"
                               x-on:change="photoName = $refs.photo.files[0].name">

                        <x-input-error for="photo" class="mt-2" />
                    </div>
                </div>
            </div>
        @endif

        <!-- Name -->
        <div>
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" 
                    type="text" 
                    class="mt-1 block w-full" 
                    wire:model="state.name" 
                    required 
                    autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" 
                    type="email" 
                    class="mt-1 block w-full" 
                    wire:model="state.email" 
                    required 
                    autocomplete="username" />
            <x-input-error for="email" class="mt-2" />

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button type="button"
                                class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300"
                                wire:click.prevent="sendEmailVerification">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if ($this->verificationLinkSent)
                        <p class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center justify-end">
            <x-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled" wire:target="photo">
                <x-lucide-save class="w-4 h-4 mr-2" />
                {{ __('Save') }}
            </x-button>
        </div>
    </form>
</div>
