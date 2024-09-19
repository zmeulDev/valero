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
   <!-- Add TinyMCE from CDN -->
   <script src="https://cdn.tiny.cloud/1/bv93eolog256rjjmx5j999y08i8co7rb78h3ow8lxcmgbt5n/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>


   <script>
        tinymce.init({
            selector: '#content',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            height: 500,
            setup: function(editor) {
                editor.on('input', function() {
                    updateCharCount('content');
                });
            }
        });

        function updateCharCount(elementId, limit = null) {
            let content;
            if (elementId === 'content') {
                content = tinymce.get('content').getContent({ format: 'text' });
            } else {
                const element = document.getElementById(elementId);
                content = element.value;
            }
            const charCount = document.getElementById(elementId + '-char-count');
            charCount.textContent = content.length;

            if (limit && content.length > limit) {
                charCount.classList.add('text-red-500');
            } else {
                charCount.classList.remove('text-red-500');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            ['title', 'excerpt'].forEach(id => {
                const element = document.getElementById(id);
                element.addEventListener('input', () => updateCharCount(id, id === 'title' ? 60 : 160));
                updateCharCount(id, id === 'title' ? 60 : 160);
            });
            // Content character count will be updated by TinyMCE setup
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