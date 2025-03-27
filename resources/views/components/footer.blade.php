@php
    use App\Models\Setting;
@endphp

<footer class="bg-gray-900 text-white text-center p-6 mt-6">
    <!-- Social Icons Section -->
    <div class="flex justify-center space-x-6 mb-4">
        @if(Setting::get('app_socialgithub'))
            <a href="{{ Setting::get('app_socialgithub') }}" 
               class="text-gray-400 hover:text-white transition-colors" 
               target="_blank" 
               rel="noopener noreferrer">
                <x-lucide-github class="w-6 h-6" />
            </a>
        @endif

        @if(Setting::get('app_socialtwitter'))
            <a href="{{ Setting::get('app_socialtwitter') }}" 
               class="text-gray-400 hover:text-white transition-colors" 
               target="_blank" 
               rel="noopener noreferrer">
                <x-lucide-twitter class="w-6 h-6" />
            </a>
        @endif

        @if(Setting::get('app_sociallinkedin'))
            <a href="{{ Setting::get('app_sociallinkedin') }}" 
               class="text-gray-400 hover:text-white transition-colors" 
               target="_blank" 
               rel="noopener noreferrer">
                <x-lucide-linkedin class="w-6 h-6" />
            </a>
        @endif

        @if(Setting::get('app_socialinstagram'))
            <a href="{{ Setting::get('app_socialinstagram') }}" 
               class="text-gray-400 hover:text-white transition-colors" 
               target="_blank" 
               rel="noopener noreferrer">
                <x-lucide-instagram class="w-6 h-6" />
            </a>
        @endif

        @if(Setting::get('app_socialyoutube'))
            <a href="{{ Setting::get('app_socialyoutube') }}" 
               class="text-gray-400 hover:text-white transition-colors" 
               target="_blank" 
               rel="noopener noreferrer">
                <x-lucide-youtube class="w-6 h-6" />
            </a>
        @endif
    </div>

    <!-- Links -->
    <div class="flex justify-center space-x-4 mb-4 text-sm">
        <a href="{{ route('cookies.policy') }}" 
           class="text-gray-400 hover:text-white transition-colors">
            Cookie Policy
        </a>
        <span class="text-gray-600">|</span>
        <button onclick="resetCookieConsent()" 
                class="text-gray-400 hover:text-white transition-colors">
            Reset Cookie Settings
        </button>
    </div>

    <!-- Copyright -->
    <div class="text-sm">
        &copy; {{ date('Y') }} {{ config('app_name') ?: env('APP_NAME', 'Valero') }}. Made with <a href="https://valero.app" target="_blank" class="text-indigo-400 hover:text-indigo-300">Valero</a>. All Rights Reserved.
        <span class="text-xs text-gray-500 dark:text-gray-400">v.{{ config('app.version') }}</span>
    </div>

<!-- Start ProfitShare Zone -->
<script type="text/javascript">
(function(){
    var bsa = document.createElement("script");
    bsa.type = "text/javascript";
    bsa.async = true;
    bsa.src = "//l.profitshare.ro/files_shared/lps/js/Lof/ZF.js?v=Setting::get('app_profitshare')";
    (document.getElementsByTagName("head")[0]||document.getElementsByTagName("body")[0]).appendChild(bsa);
})();
</script>
<!-- End ProfitShare Zone -->		
</footer>