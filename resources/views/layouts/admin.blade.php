<!-- resources/views/components/admin-layout.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ?? 'Admin Panel' }} - {{ config('app.name', 'Laravel') }}</title>
  <link rel="icon" href="{{ asset('storage/brand/favicon.ico') }}">
  <script src="https://cdn.tiny.cloud/1/{{ config('app_tinymce') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <script src="https://cdn.jsdelivr.net/npm/showdown/dist/showdown.min.js"></script>

  <!-- Vite Assets -->
  @vite(['resources/css/app.css', 'resources/js/valero-admin.js'])
  @livewireStyles
  <style>[x-cloak] { display: none !important; }</style>

</head>

<body class="min-h-screen bg-gray-50 dark:bg-gray-900">

  <div class="flex flex-col min-h-screen">
    <!-- Navigation -->
    <x-admin.navigation-admin />

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-4 py-2 rounded shadow-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-500 text-white px-4 py-2 rounded shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    <script>
        // Auto-dismiss flash messages
        setTimeout(() => {
            const successMessage = document.querySelector('.bg-green-500');
            const errorMessage = document.querySelector('.bg-red-500');
            
            if (successMessage) successMessage.remove();
            if (errorMessage) errorMessage.remove();
        }, 5000);
    </script>

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