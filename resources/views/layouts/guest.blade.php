<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('storage/brand/favicon.ico') }}">
  <title>{{ config('app_name', 'Valero') }}</title>



  <!-- Vite Assets -->
  @vite(['resources/js/valero-frontend.js'])

  <!-- Styles -->
  @livewireStyles
</head>

<body>


  <div class="font-sans text-gray-900 antialiased">
    {{ $slot }}
  </div>

  @livewireScripts
</body>

</html>