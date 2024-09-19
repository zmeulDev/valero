<!-- resources/views/components/admin-layout.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Admin Panel' }} - {{ config('app.name', 'Laravel') }}</title>

  <!-- Include CSS -->
  @vite('resources/css/app.css')

  <!-- Livewire Styles -->
  @livewireStyles

  <!-- Alpine.js for interactivity -->
  <script src="//unpkg.com/alpinejs" defer></script>
  
  <!-- Script to Handle Character Counts for Multiple Fields with Color Change -->
  <script>
  function updateCharCount(fieldId, limit = null) {
    var inputElement = document.getElementById(fieldId);
    var charCount = inputElement.value.length;
    var countDisplay = document.getElementById(`${fieldId}-char-count`);

    // Update the character count display
    countDisplay.textContent = `(${charCount})`;

    // If there's a limit and it's exceeded, change color to red, otherwise reset to gray
    if (limit && charCount > limit) {
      countDisplay.classList.add('text-red-500');
      countDisplay.classList.remove('text-green-600');
    } else {
      countDisplay.classList.remove('text-red-500');
      countDisplay.classList.add('text-green-600');
    }
  }

  // Initialize with old values' character counts if present
  document.addEventListener('DOMContentLoaded', function() {
    updateCharCount('title', 60);
    updateCharCount('excerpt', 160);
    updateCharCount('content');
  });
  </script>
</head>

<body class="bg-gray-100">

  <!-- Navigation Component -->
  <header>
    <x-navigation-admin />
  </header>

  <!-- Main Content -->
  <div class="container mx-auto mt-6">
    {{ $slot }}
  </div>

  <!-- Footer -->
  <footer class="bg-gray-800 text-white text-center p-4 mt-6">
    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All Rights Reserved.
  </footer>

  <!-- Livewire Scripts -->
  @livewireScripts
</body>

</html>