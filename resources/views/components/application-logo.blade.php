@php
use App\Models\Setting;
@endphp

<img src="{{ asset('brand/logo.png') }}?v={{ Setting::get('logo_version', '1') }}" alt="{{ config('app.name') }} Logo" {{ $attributes }}>