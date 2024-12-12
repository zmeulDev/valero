@if(app()->environment('local'))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    @if($css)
        <link rel="stylesheet" href="{{ $css }}">
    @endif
    @if($js)
        <script src="{{ $js }}" defer></script>
    @endif
@endif 