@if(auth()->user() && !auth()->user()->hasVerifiedEmail())
    <div class="bg-yellow-50 dark:bg-yellow-900 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <x-lucide-alert-triangle class="h-5 w-5 text-yellow-400" />
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700 dark:text-yellow-200">
                    {{ __('Your email address is not verified.') }}
                    <form class="inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="underline text-sm text-yellow-700 dark:text-yellow-200 hover:text-yellow-900 dark:hover:text-yellow-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </form>
                </p>
            </div>
        </div>
    </div>
@endif 