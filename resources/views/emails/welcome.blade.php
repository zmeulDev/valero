<x-mail::message>
    # Welcome to {{ config('app_name') }}

    Thank you for registering with us.

    <x-mail::button :url="route('home')">
        Visit Website
    </x-mail::button>

    Thanks,<br>
    {{ config('app_name') }}
</x-mail::message>