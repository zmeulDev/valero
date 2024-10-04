@php
use App\Models\Setting;
@endphp

<img src="{{ asset('storage/brand/logo.png') }}?v={{ Setting::get('logo_version', '1') }}" alt="{{ config('app.name') }} Logo" {{ $attributes ->merge(['class' => 'h-16 w-16 dark:text-white']) }}> 