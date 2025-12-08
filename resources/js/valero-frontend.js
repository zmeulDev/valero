// Theme
document.addEventListener('DOMContentLoaded', function () {
  const themeToggleBtn = document.getElementById('theme-toggle');
  const darkIcon = document.getElementById('theme-toggle-dark-icon');
  const lightIcon = document.getElementById('theme-toggle-light-icon');

  // Function to apply the theme based on local storage
  function applyTheme() {
    const canToggleIcons = darkIcon && lightIcon;

    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
      '(prefers-color-scheme: dark)').matches)) {
      document.documentElement.classList.add('dark');
      if (canToggleIcons) {
        lightIcon.classList.remove('hidden');
        darkIcon.classList.add('hidden');
      }
    } else {
      document.documentElement.classList.remove('dark');
      if (canToggleIcons) {
        darkIcon.classList.remove('hidden');
        lightIcon.classList.add('hidden');
      }
    }
  }

  // Apply theme on page load
  applyTheme();

  if (themeToggleBtn && darkIcon && lightIcon) {
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

// Article Like Functionality
document.addEventListener('DOMContentLoaded', function() {
  const likeButtons = document.querySelectorAll('.like-button');
  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
  
  if (!csrfToken) {
    console.error('CSRF token not found');
    return;
  }
  
  likeButtons.forEach(button => {
    let isProcessing = false;

    button.addEventListener('click', function() {
      if (isProcessing) return;
      isProcessing = true;

      const articleId = this.dataset.articleId;
      const likeCount = document.getElementById(`likeCount-${articleId}`);
      const likeIcon = document.getElementById(`likeIcon-${articleId}`);
      const isLiked = likeIcon.classList.contains('text-rose-500');
      
      fetch(`/articles/${articleId}/like`, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ liked: !isLiked })
      })
      .then(async response => {
        const data = await response.json();
        if (!response.ok) {
          throw new Error(data.message || 'Failed to update like status');
        }
        return data;
      })
      .then(data => {
        if (data.success) {
          // Update like count with animation
          likeCount.style.transition = 'transform 0.2s ease';
          likeCount.style.transform = 'scale(1.2)';
          likeCount.textContent = new Intl.NumberFormat().format(data.likes_count);
          
          // Toggle like icon state
          if (isLiked) {
            likeIcon.classList.remove('text-rose-500');
            likeIcon.classList.add('text-gray-400');
          } else {
            likeIcon.classList.remove('text-gray-400');
            likeIcon.classList.add('text-rose-500');
          }
          
          // Reset scale after animation
          setTimeout(() => {
            likeCount.style.transform = 'scale(1)';
          }, 200);
        }
      })
      .catch(error => {
        console.error('Like error:', error);
        // Show error notification
        const notification = document.createElement('div');
        notification.className = 'fixed bottom-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        notification.textContent = error.message || 'An error occurred while updating like status';
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
      })
      .finally(() => {
        isProcessing = false;
      });
    });
  });
});