<div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
    <form wire:submit="updateProfileInformation" class="p-6 space-y-6">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{
                photoName: null, 
                photoPreview: null,
                clearPreview() {
                    this.photoPreview = null;
                    this.photoName = null;
                }
            }" 
            x-init="$wire.on('saved', () => { 
                clearPreview(); 
                setTimeout(() => window.location.reload(), 800); 
            })"
            class="mb-6">
                <!-- Profile Photo Section -->
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                    <div class="flex-shrink-0">
                        <!-- Current Profile Photo -->
                        <div class="relative">
                            <!-- Show new photo preview or current photo -->
                            <div class="relative">
                                <img x-show="photoPreview" 
                                     :src="photoPreview" 
                                     alt="{{ $this->user->name }}" 
                                     class="h-24 w-24 sm:h-32 sm:w-32 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-lg"
                                     style="display: none;">
                                
                                <img x-show="!photoPreview" 
                                     src="{{ $this->user->profile_photo_url }}" 
                                     alt="{{ $this->user->name }}" 
                                     class="h-24 w-24 sm:h-32 sm:w-32 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-lg"
                                     wire:loading.class="opacity-50"
                                     wire:target="photo,updateProfileInformation">
                            </div>
                            
                            @if ($this->user->profile_photo_path)
                                <button type="button" 
                                        wire:click="deleteProfilePhoto" 
                                        x-on:click="clearPreview()"
                                        class="absolute top-0 right-0 bg-red-500 hover:bg-red-600 rounded-full p-2 text-white shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors"
                                        title="{{ __('Remove photo') }}">
                                    <x-lucide-trash-2 class="w-4 h-4" />
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="flex-1 text-center sm:text-left">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">
                            {{ __('Profile Photo') }}
                        </h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            {{ __('Upload a new profile photo. Recommended size: 400x400px') }}
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-3">
                            <x-button-secondary type="button" 
                                              x-on:click.prevent="$refs.photo.click()"
                                              class="inline-flex items-center justify-center">
                                <x-lucide-upload class="w-4 h-4 mr-2" />
                                {{ __('Select New Photo') }}
                            </x-button-secondary>

                            @if ($this->user->profile_photo_path)
                                <x-button-secondary type="button"
                                                  wire:click="deleteProfilePhoto"
                                                  x-on:click="clearPreview()"
                                                  class="inline-flex items-center justify-center text-red-600 hover:text-red-700 dark:text-red-400">
                                    <x-lucide-x class="w-4 h-4 mr-2" />
                                    {{ __('Remove Photo') }}
                                </x-button-secondary>
                            @endif
                        </div>

                        <input type="file" 
                               class="hidden"
                               wire:model.live="photo"
                               x-ref="photo"
                               accept="image/*"
                               x-on:change="
                                   photoName = $refs.photo.files[0].name;
                                   const reader = new FileReader();
                                   reader.onload = (e) => {
                                       photoPreview = e.target.result;
                                   };
                                   reader.readAsDataURL($refs.photo.files[0]);
                               ">

                        <x-input-error for="photo" class="mt-2" />
                        
                        <p x-show="photoName" class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                            <span x-text="photoName"></span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="px-3 bg-white dark:bg-gray-800 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Account Information') }}
                    </span>
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
                <div class="mt-3 p-4 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 rounded-lg">
                    <div class="flex items-start">
                        <x-lucide-alert-circle class="w-5 h-5 text-yellow-400 mr-3 flex-shrink-0 mt-0.5" />
                        <div class="flex-1">
                            <p class="text-sm font-medium text-yellow-800 dark:text-yellow-300">
                                {{ __('Your email address is unverified.') }}
                            </p>
                            <button type="button"
                                    class="mt-2 inline-flex items-center text-sm font-medium text-yellow-700 hover:text-yellow-600 dark:text-yellow-400 dark:hover:text-yellow-300 underline transition-colors"
                                    wire:click.prevent="sendEmailVerification">
                                <x-lucide-mail class="w-4 h-4 mr-1" />
                                {{ __('Click here to re-send the verification email.') }}
                            </button>

                            @if ($this->verificationLinkSent)
                                <div class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-md">
                                    <div class="flex items-center">
                                        <x-lucide-check-circle class="w-5 h-5 text-green-500 mr-2" />
                                        <p class="text-sm font-medium text-green-700 dark:text-green-300">
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <x-action-message class="text-sm font-medium" on="saved">
                    <div class="flex items-center text-green-600 dark:text-green-400">
                        <x-lucide-check-circle class="w-5 h-5 mr-2" />
                        {{ __('Saved successfully!') }}
                    </div>
                </x-action-message>

                <x-button type="submit" wire:loading.attr="disabled" wire:target="photo,updateProfileInformation" class="ml-auto">
                    <span wire:loading.remove wire:target="photo,updateProfileInformation">
                        <x-lucide-save class="w-4 h-4 mr-2" />
                        {{ __('Save Changes') }}
                    </span>
                    <span wire:loading wire:target="photo,updateProfileInformation">
                        <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ __('Saving...') }}
                    </span>
                </x-button>
            </div>
        </div>
    </form>
</div>
