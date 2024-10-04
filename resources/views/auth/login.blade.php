<x-guest-layout>
  <div class="font-[sans-serif] min-h-screen flex items-center justify-center py-6 px-4 bg-cover bg-center">
    <div class="grid md:grid-cols-2 items-center gap-4 max-w-6xl w-full">
      <div class="hidden md:block lg:h-[600px] md:h-[600px]">
        <img src="storage/brand/auth_background.png" class="w-full h-full object-cover" alt="Authentication Background" />
      </div>
      <div
        class="border border-gray-300 rounded-lg p-6 max-w-md shadow-[0_2px_22px_-4px_rgba(93,96,127,0.2)] max-md:mx-auto bg-white">
        <div class="flex justify-center mb-8">
          <x-auth.authentication-card-logo class="w-26 h-26" />
        </div>
        <x-validation-errors class="mb-4" />

        @session('status')
        <div class="mb-4 font-medium text-sm text-green-600">
          {{ $value }}
        </div>
        @endsession

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
          @csrf
          <div class="mb-8">
            <h3 class="text-gray-800 text-3xl font-extrabold">Sign in</h3>
            <p class="text-gray-500 text-sm mt-4 leading-relaxed">Sign in to your account and explore a world of
              possibilities. Your journey begins here.</p>
          </div>

          <div>
            <x-label for="email" value="{{ __('Email') }}" class="text-gray-800 text-sm mb-2 block" />
            <div class="relative flex items-center">
              <x-input id="email"
                class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="Enter email" />
              <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb"
                class="w-[18px] h-[18px] absolute right-4" viewBox="0 0 24 24">
                <circle cx="10" cy="7" r="6" data-original="#000000"></circle>
                <path
                  d="M14 15H6a5 5 0 0 0-5 5 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 5 5 0 0 0-5-5zm8-4h-2.59l.3-.29a1 1 0 0 0-1.42-1.42l-2 2a1 1 0 0 0 0 1.42l2 2a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42l-.3-.29H22a1 1 0 0 0 0-2z"
                  data-original="#000000"></path>
              </svg>
            </div>
          </div>

          <div>
            <x-label for="password" value="{{ __('Password') }}" class="text-gray-800 text-sm mb-2 block" />
            <div class="relative flex items-center">
              <x-input id="password"
                class="w-full text-sm text-gray-800 border border-gray-300 px-4 py-3 rounded-lg outline-blue-600"
                type="password" name="password" required autocomplete="current-password" placeholder="Enter password" />
              <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb"
                class="w-[18px] h-[18px] absolute right-4 cursor-pointer" viewBox="0 0 128 128"
                onclick="togglePassword()">
                <path
                  d="M64 104C22.127 104 1.367 67.496.504 65.943a4 4 0 0 1 0-3.887C1.367 60.504 22.127 24 64 24s62.633 36.504 63.496 38.057a4 4 0 0 1 0 3.887C126.633 67.496 105.873 104 64 104zM8.707 63.994C13.465 71.205 32.146 96 64 96c31.955 0 50.553-24.775 55.293-31.994C114.535 56.795 95.854 32 64 32 32.045 32 13.447 56.775 8.707 63.994zM64 88c-13.234 0-24-10.766-24-24s10.766-24 24-24 24 10.766 24 24-10.766 24-24 24zm0-40c-8.822 0-16 7.178-16 16s7.178 16 16 16 16-7.178 16-16-7.178-16-16-16z"
                  data-original="#000000"></path>
              </svg>
            </div>
          </div>

          <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center">
              <x-checkbox id="remember_me" name="remember"
                class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
              <label for="remember_me" class="ml-3 block text-sm text-gray-800">
                {{ __('Remember me') }}
              </label>
            </div>

            @if (Route::has('password.request'))
            <div class="text-sm">
              <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline font-semibold">
                {{ __('Forgot your password?') }}
              </a>
            </div>
            @endif
          </div>

          <div class="!mt-8">
            <x-button
              class="w-full shadow-xl py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none">
              {{ __('Log in') }}
            </x-button>
          </div>

          <p class="text-sm !mt-8 text-center text-gray-800">{{ __("Don't have an account") }} <a
              href="{{ route('register') }}"
              class="text-blue-600 font-semibold hover:underline ml-1 whitespace-nowrap">{{ __('Register here') }}</a>
          </p>
        </form>
      </div>
    </div>
  </div>

  <script>
  function togglePassword() {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
  }
  </script>
</x-guest-layout>