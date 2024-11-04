@php
use App\Models\Setting;
@endphp

<img src="{{ asset('storage/brand/logo.png') }}?v={{ Setting::get('logo_version', '1') }}" alt="{{ config('app_name') }} Logo" {{ $attributes ->merge(['class' => 'rounded-full object-cover h-16 w-16 dark:text-white']) }}> 