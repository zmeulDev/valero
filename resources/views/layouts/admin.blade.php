<!-- resources/views/components/admin-layout.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ?? 'Admin Panel' }} - {{ config('app.name', 'Laravel') }}</title>
  <link rel="icon" href="{{ asset('storage/brand/favicon.ico') }}">

  <!-- Styles -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
  <script src="https://cdn.tiny.cloud/1/{{ config('app_tinymce') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <style>[x-cloak] { display: none !important; }</style>

</head>

<body class="min-h-screen bg-gray-50 dark:bg-gray-900">

  <div class="flex flex-col min-h-screen">
    <!-- Navigation -->
    <x-admin.navigation-admin />

    <!-- Flash Messages -->
    <x-notification />

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
  @vite('resources/js/valero-admin.js')
  @livewireScripts
  @stack('scripts')
</body>

</html>