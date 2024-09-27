<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Valero' }} - {{ config('app.name', 'Valero') }}</title>
  <link rel="icon" href="{{ asset('images/favicon.ico') }}">
  <!-- Include CSS -->
  @vite('resources/css/app.css')

  <!-- SEO -->
  {!! seo(isset($article) ? $article : null) !!}
  <!-- End SEO -->

  <!-- Livewire Styles -->
  @livewireStyles

  <!-- Alpine.js for interactivity -->
  <script src="//unpkg.com/alpinejs" defer></script>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');

    // Function to apply the theme based on local storage
    function applyTheme() {
      if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
          '(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
        lightIcon.classList.remove('hidden');
        darkIcon.classList.add('hidden');
      } else {
        document.documentElement.classList.remove('dark');
        darkIcon.classList.remove('hidden');
        lightIcon.classList.add('hidden');
      }
    }

    // Apply theme on page load
    applyTheme();

    if (themeToggleBtn) {
      themeToggleBtn.addEventListener('click', function() {
        // Toggle icons inside button
        darkIcon.classList.toggle('hidden');
        lightIcon.classList.toggle('hidden');

        // Toggle dark mode class and update local storage
        if (document.documentElement.classList.contains('dark')) {
          document.documentElement.classList.remove('dark');
          localStorage.setItem('color-theme', 'light');
        } else {
          document.documentElement.classList.add('dark');
          localStorage.setItem('color-theme', 'dark');
        }
      });
    }
  });
  </script>
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <x-navigation />

  <!-- Main Content -->
  <main class="container mx-auto">
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen">
      <div class="container mx-auto px-4 lg:px-8 py-8 grid grid-cols-1 lg:grid-cols-4 gap-8">
        <main class="lg:col-span-3">
          <article class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <!-- Featured Image with Metadata -->
            <x-article.feature :article="$article" :readingTime="$readingTime" />

            <div class="px-6 pb-8">
              <!-- Article Header -->
              <x-article.header :article="$article" />

              <!-- Article Content -->
              <div class="prose prose-lg max-w-none dark:prose-invert mb-12">
                {!! $article->content !!}
              </div>

              <!-- Gallery -->
              <x-article.gallery :article="$article" />

              <!-- Author Bio and Category -->
              <x-article.metadata :article="$article" />

            </div>
          </article>
        </main>

        <!-- Sidebar -->
        <aside class="lg:col-span-1">
          <div class="sticky top-8">
            <x-sidebar.sidebar :popularArticles="$popularArticles" :categories="$categories" />
          </div>
        </aside>
      </div>
    </div>

    <!-- Full-size Gallery Modal -->
    <x-article.fullgallery />

    <script>
    document.addEventListener('DOMContentLoaded', function() {
      const galleryModal = document.getElementById('galleryModal');
      const galleryImage = document.getElementById('galleryImage');
      const prevButton = document.getElementById('prevButton');
      const nextButton = document.getElementById('nextButton');
      const closeButton = document.getElementById('closeButton');
      const galleryImages = document.querySelectorAll('.gallery-image');

      let currentIndex = 0;
      const imagePaths = Array.from(galleryImages).map(img => img.src);

      function openGallery(index) {
        currentIndex = index;
        galleryImage.src = imagePaths[currentIndex];
        galleryModal.classList.remove('hidden');
      }

      function closeGallery() {
        galleryModal.classList.add('hidden');
      }

      function nextImage() {
        currentIndex = (currentIndex + 1) % imagePaths.length;
        galleryImage.src = imagePaths[currentIndex];
      }

      function prevImage() {
        currentIndex = (currentIndex - 1 + imagePaths.length) % imagePaths.length;
        galleryImage.src = imagePaths[currentIndex];
      }

      galleryImages.forEach((img, index) => {
        img.addEventListener('click', () => openGallery(index));
      });

      prevButton.addEventListener('click', prevImage);
      nextButton.addEventListener('click', nextImage);
      closeButton.addEventListener('click', closeGallery);
      galleryModal.addEventListener('click', (e) => {
        if (e.target === galleryModal) closeGallery();
      });

      document.addEventListener('keydown', (e) => {
        if (!galleryModal.classList.contains('hidden')) {
          if (e.key === 'ArrowRight') nextImage();
          if (e.key === 'ArrowLeft') prevImage();
          if (e.key === 'Escape') closeGallery();
        }
      });
    });
    </script>
  </main>

  <!-- Footer -->
  <x-footer />
</body>

</html>