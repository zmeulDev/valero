// Theme
document.addEventListener('DOMContentLoaded', function () {
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
    themeToggleBtn.addEventListener('click', function () {
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

  // Logo refresh handler for settings page
  if (window.location.pathname.includes('/admin/settings')) {
    const form = document.getElementById('settings-form');
    if (form) {
      form.addEventListener('submit', function(e) {
        const fileInput = document.querySelector('input[name="logo"]');
        if (fileInput && fileInput.files.length > 0) {
          e.preventDefault();
          
          const formData = new FormData(form);
          
          fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Force refresh all logo images on the page
              const logoImages = document.querySelectorAll('img[src*="brand/logo.png"]');
              logoImages.forEach(img => {
                const currentSrc = img.src.split('?')[0];
                img.src = `${currentSrc}?v=${Date.now()}`;
              });
            }
          })
          .catch(error => {
            console.error('Error:', error);
            // If there's an error, submit the form normally
            form.submit();
          });
        }
      });
    }
  }
});

// Gallery
document.addEventListener('DOMContentLoaded', function () {
  const galleryModal = document.getElementById('galleryModal');
  const galleryImage = document.getElementById('galleryImage');
  const prevButton = document.getElementById('prevButton');
  const nextButton = document.getElementById('nextButton');
  const closeButton = document.getElementById('closeButton');
  const galleryImages = document.querySelectorAll('.gallery-image');

  // show gallery only on article page
  if (!window.location.pathname.includes('/article')) {
    return;
  }

  // Check if gallery elements exist
  if (!galleryModal || !galleryImage || !prevButton || !nextButton || !closeButton || galleryImages.length === 0) {
    console.log('Gallery elements not found. Skipping gallery initialization.');
    return;
  }

  // gallery only on article page
  if (!window.location.pathname.includes('/article')) {
    return;
  }

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