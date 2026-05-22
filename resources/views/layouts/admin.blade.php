<!-- resources/views/components/admin-layout.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ?? 'Admin Panel' }} - {{ config('app_name', 'Valero') }}</title>
  <link rel="icon" href="{{ asset('storage/brand/favicon.ico') }}">
  <meta name="theme-color" content="#0ea5e9">
  <script src="https://cdn.tiny.cloud/1/{{ config('app_tinymce') }}/tinymce/6/tinymce.min.js"
    referrerpolicy="origin"></script>
  <script src="https://cdn.jsdelivr.net/npm/showdown/dist/showdown.min.js"></script>

  <!-- Vite Assets -->
  @vite(['resources/js/valero-admin.js'])
  @livewireStyles

</head>

<body class="min-h-screen bg-background text-text">

  <div class="flex flex-col min-h-screen">
    <!-- Navigation -->
    <x-admin.navigation />

    <!-- Flash Messages - Using notification component instead -->

    <!-- Page Header -->
    @if (isset($header))
      {{ $header }}
    @endif

    <!-- Main Content -->
    <main class="flex-grow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{ $slot }}
      </div>
    </main>

    <!-- Footer -->
    <x-footer />
  </div>

  <!-- Scripts -->
  @livewireScripts
  @stack('scripts')
</body>

</html>
