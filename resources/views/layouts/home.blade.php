<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  {!! seo() !!}
  <link rel="icon" href="{{ asset('images/favicon.ico') }}">
  <!-- Include CSS -->
  @vite('resources/css/app.css')

  <!-- Livewire Styles -->
  @livewireStyles

  <style>
  [x-cloak] {
    display: none !important;
  }
  </style>

  <!-- Alpine.js for interactivity -->
  <script src="//unpkg.com/alpinejs" defer></script>



</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <x-navigation />

  <!-- Flash Message Component -->
  <x-flash-message />

  <!-- Main Content -->
  <main class="container mx-auto">
    {{ $slot }}
  </main>

  <!-- Footer -->
  <x-footer />

  <!-- Custom Valero Frontend JS -->
  @vite('resources/js/valero-frontend.js')

</body>

</html>