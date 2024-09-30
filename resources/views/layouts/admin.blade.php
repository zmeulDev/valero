<!-- resources/views/components/admin-layout.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Admin Panel' }} - {{ config('app.name', 'Laravel') }}</title>
  <link rel="icon" href="{{ asset('images/favicon.ico') }}">

  <!-- Include CSS -->
  @vite('resources/css/app.css')

  <!-- Livewire Styles -->
  @livewireStyles

  <!-- Alpine.js for interactivity -->
  <script src="//unpkg.com/alpinejs" defer></script>
  <!-- Add TinyMCE from CDN -->
  <script src="https://cdn.tiny.cloud/1/bv93eolog256rjjmx5j999y08i8co7rb78h3ow8lxcmgbt5n/tinymce/6/tinymce.min.js"
    referrerpolicy="origin"></script>


</head>

<body class="bg-gray-100">

  <!-- Navigation Component -->
  <header>
    <x-admin.navigation-admin />
  </header>

  <!-- Main Content -->
  <div class="container mx-auto mt-6">
    {{ $slot }}
  </div>

  <!-- Footer -->
  <x-footer />

  <!-- Livewire Scripts -->
  @livewireScripts

  <!-- Custom Valero Admin JS -->
  @vite('resources/js/valero-admin.js')

</body>

</html>