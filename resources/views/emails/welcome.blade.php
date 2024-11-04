<x-mail::message>
# Welcome to {{ config('app.name') }}

Thank you for registering with us.

<x-mail::button :url="route('home')">
Visit Website
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> 