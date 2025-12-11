<div class="flex flex-col gap-4 items-center">
    <a href="/" class="transition-transform duration-200 hover:scale-105">
        <img src="{{ asset('storage/brand/logo.png') }}" 
             alt="{{ config('app.name') }} Logo" 
             {{ $attributes->merge(['class' => 'h-16 w-auto']) }}>
    </a>
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
        {{ config('app.name') }}
    </h1>
</div>