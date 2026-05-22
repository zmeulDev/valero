<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app_name', 'Valero') }}</title>
  <link rel="icon" href="{{ asset('storage/brand/favicon.ico') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/brand/apple-touch-icon.png') }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <meta name="theme-color" content="#0ea5e9">

  <!-- Vite Assets -->
  @vite(['resources/js/valero-frontend.js'])

  <!-- Styles -->
  @livewireStyles
</head>

<body>
  <div class="font-sans text-text bg-background antialiased">
    {{ $slot }}
  </div>

  @livewireScripts
</body>

</html>
