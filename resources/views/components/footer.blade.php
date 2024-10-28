@php
    use App\Models\Setting;
@endphp

<footer class="bg-gray-800 text-white text-center p-4 mt-6">
    <!-- Social Icons Section -->
    <div class="flex justify-center space-x-4 mb-4">
        @if(Setting::get('app_socialgithub'))
            <a href="{{ Setting::get('app_socialgithub') }}" 
               class="text-gray-400 hover:text-white transition-colors" 
               target="_blank" 
               rel="noopener noreferrer">
                <x-lucide-github class="w-5 h-5" />
            </a>
        @endif

        @if(Setting::get('app_socialtwitter'))
            <a href="{{ Setting::get('app_socialtwitter') }}" 
               class="text-gray-400 hover:text-white transition-colors" 
               target="_blank" 
               rel="noopener noreferrer">
                <x-lucide-twitter class="w-5 h-5" />
            </a>
        @endif

        @if(Setting::get('app_sociallinkedin'))
            <a href="{{ Setting::get('app_sociallinkedin') }}" 
               class="text-gray-400 hover:text-white transition-colors" 
               target="_blank" 
               rel="noopener noreferrer">
                <x-lucide-linkedin class="w-5 h-5" />
            </a>
        @endif

        @if(Setting::get('app_socialinstagram'))
            <a href="{{ Setting::get('app_socialinstagram') }}" 
               class="text-gray-400 hover:text-white transition-colors" 
               target="_blank" 
               rel="noopener noreferrer">
                <x-lucide-instagram class="w-5 h-5" />
            </a>
        @endif

        @if(Setting::get('app_socialyoutube'))
            <a href="{{ Setting::get('app_socialyoutube') }}" 
               class="text-gray-400 hover:text-white transition-colors" 
               target="_blank" 
               rel="noopener noreferrer">
                <x-lucide-youtube class="w-5 h-5" />
            </a>
        @endif
    </div>

    <!-- Copyright -->
    &copy; {{ date('Y') }} {{ config('app_name') ?: env('APP_NAME', 'Valero') }}. Made with <a href="https://valero.app" target="_blank">Valero</a> All Rights Reserved.
</footer>
