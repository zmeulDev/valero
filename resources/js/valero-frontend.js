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

// Enhanced Gallery
document.addEventListener('DOMContentLoaded', function () {
  const galleryModal = document.getElementById('galleryModal');
  const galleryImage = document.getElementById('galleryImage');
  const imageContainer = document.getElementById('imageContainer');
  const imageLoader = document.getElementById('imageLoader');
  const prevButton = document.getElementById('prevButton');
  const nextButton = document.getElementById('nextButton');
  const closeButton = document.getElementById('closeButton');
  const zoomButton = document.getElementById('zoomButton');
  const fullscreenButton = document.getElementById('fullscreenButton');
  const downloadButton = document.getElementById('downloadButton');
  const galleryCounter = document.getElementById('galleryCounter');
  const thumbnailStrip = document.getElementById('thumbnailStrip');
  const galleryImages = document.querySelectorAll('.gallery-image');

  // Check if gallery elements exist
  if (!galleryModal || !galleryImage || galleryImages.length === 0) {
    return;
  }

  let currentIndex = 0;
  let isZoomed = false;
  let imageData = [];
  
  // Build image data array with metadata
  galleryImages.forEach((container, index) => {
    const imgElement = container.querySelector('img');
    if (imgElement) {
      imageData.push({
        src: imgElement.src,
        alt: imgElement.alt || `Image ${index + 1}`,
        element: container
      });
    }
  });

  // Create thumbnails
  function createThumbnails() {
    thumbnailStrip.innerHTML = '';
    imageData.forEach((img, index) => {
      const thumb = document.createElement('div');
      thumb.className = 'flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden cursor-pointer transition-all duration-200 hover:scale-110 hover:ring-2 hover:ring-white/50';
      thumb.innerHTML = `<img src="${img.src}" alt="${img.alt}" class="w-full h-full object-cover">`;
      thumb.addEventListener('click', () => showImage(index));
      thumbnailStrip.appendChild(thumb);
    });
  }

  // Update thumbnail active state
  function updateThumbnails() {
    const thumbs = thumbnailStrip.querySelectorAll('div');
    thumbs.forEach((thumb, index) => {
      if (index === currentIndex) {
        thumb.classList.add('ring-2', 'ring-white', 'scale-110');
        thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
      } else {
        thumb.classList.remove('ring-2', 'ring-white', 'scale-110');
      }
    });
  }

  // Show loading state
  function showLoading() {
    imageLoader.classList.remove('hidden');
    galleryImage.classList.add('opacity-0');
  }

  // Hide loading state
  function hideLoading() {
    imageLoader.classList.add('hidden');
    galleryImage.classList.remove('opacity-0');
  }

  // Update counter
  function updateCounter() {
    galleryCounter.textContent = `${currentIndex + 1} / ${imageData.length}`;
  }

  // Update navigation buttons
  function updateNavButtons() {
    prevButton.disabled = imageData.length <= 1;
    nextButton.disabled = imageData.length <= 1;
  }

  // Reset zoom
  function resetZoom() {
    isZoomed = false;
    galleryImage.style.transform = 'scale(1)';
    galleryImage.classList.remove('cursor-zoom-out');
    galleryImage.classList.add('cursor-zoom-in');
    zoomButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><line x1="11" x2="11" y1="8" y2="14"/><line x1="8" x2="14" y1="11" y2="11"/></svg>';
  }

  // Toggle zoom
  function toggleZoom() {
    isZoomed = !isZoomed;
    if (isZoomed) {
      galleryImage.style.transform = 'scale(2)';
      galleryImage.classList.remove('cursor-zoom-in');
      galleryImage.classList.add('cursor-zoom-out');
      zoomButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><line x1="8" x2="14" y1="11" y2="11"/></svg>';
    } else {
      resetZoom();
    }
  }

  // Show specific image
  function showImage(index) {
    currentIndex = index;
    showLoading();
    resetZoom();
    
    const img = new Image();
    img.onload = () => {
      galleryImage.src = imageData[currentIndex].src;
      galleryImage.alt = imageData[currentIndex].alt;
      hideLoading();
      updateCounter();
      updateThumbnails();
      updateNavButtons();
      
      // Preload adjacent images
      preloadAdjacentImages();
    };
    img.onerror = () => {
      hideLoading();
    };
    img.src = imageData[currentIndex].src;
  }

  // Preload adjacent images for smoother navigation
  function preloadAdjacentImages() {
    const nextIndex = (currentIndex + 1) % imageData.length;
    const prevIndex = (currentIndex - 1 + imageData.length) % imageData.length;
    
    [nextIndex, prevIndex].forEach(index => {
      const img = new Image();
      img.src = imageData[index].src;
    });
  }

  // Open gallery
  function openGallery(index) {
    currentIndex = index;
    galleryModal.classList.remove('hidden');
    galleryModal.classList.add('modal-enter');
    document.body.style.overflow = 'hidden';
    createThumbnails();
    showImage(currentIndex);
  }

  // Close gallery
  function closeGallery() {
    galleryModal.classList.add('modal-exit');
    setTimeout(() => {
      galleryModal.classList.add('hidden');
      galleryModal.classList.remove('modal-enter', 'modal-exit');
      document.body.style.overflow = '';
      resetZoom();
    }, 300);
  }

  // Navigate to next image
  function nextImage() {
    if (imageData.length <= 1) return;
    currentIndex = (currentIndex + 1) % imageData.length;
    showImage(currentIndex);
  }

  // Navigate to previous image
  function prevImage() {
    if (imageData.length <= 1) return;
    currentIndex = (currentIndex - 1 + imageData.length) % imageData.length;
    showImage(currentIndex);
  }

  // Download current image
  function downloadImage() {
    const link = document.createElement('a');
    link.href = imageData[currentIndex].src;
    link.download = `image-${currentIndex + 1}.jpg`;
    link.click();
  }

  // Toggle fullscreen
  function toggleFullscreen() {
    if (!document.fullscreenElement) {
      galleryModal.requestFullscreen().catch(() => {});
      fullscreenButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3v3a2 2 0 0 1-2 2H3"/><path d="M21 8h-3a2 2 0 0 1-2-2V3"/><path d="M3 16h3a2 2 0 0 1 2 2v3"/><path d="M16 21v-3a2 2 0 0 1 2-2h3"/></svg>';
    } else {
      document.exitFullscreen();
      fullscreenButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3H5a2 2 0 0 0-2 2v3"/><path d="M21 8V5a2 2 0 0 0-2-2h-3"/><path d="M3 16v3a2 2 0 0 0 2 2h3"/><path d="M16 21h3a2 2 0 0 0 2-2v-3"/></svg>';
    }
  }

  // Touch/Swipe support for mobile
  let touchStartX = 0;
  let touchEndX = 0;
  
  imageContainer.addEventListener('touchstart', (e) => {
    touchStartX = e.changedTouches[0].screenX;
  }, { passive: true });
  
  imageContainer.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
  }, { passive: true });
  
  function handleSwipe() {
    const swipeThreshold = 50;
    if (touchStartX - touchEndX > swipeThreshold) {
      nextImage(); // Swiped left
    } else if (touchEndX - touchStartX > swipeThreshold) {
      prevImage(); // Swiped right
    }
  }

  // Event listeners
  galleryImages.forEach((img, index) => {
    img.addEventListener('click', () => openGallery(index));
  });

  prevButton.addEventListener('click', prevImage);
  nextButton.addEventListener('click', nextImage);
  closeButton.addEventListener('click', closeGallery);
  zoomButton.addEventListener('click', toggleZoom);
  fullscreenButton.addEventListener('click', toggleFullscreen);
  downloadButton.addEventListener('click', downloadImage);
  
  // Click image to zoom
  galleryImage.addEventListener('click', toggleZoom);
  
  // Click backdrop to close
  galleryModal.addEventListener('click', (e) => {
    if (e.target === galleryModal) closeGallery();
  });

  // Keyboard navigation
  document.addEventListener('keydown', (e) => {
    if (!galleryModal.classList.contains('hidden')) {
      if (e.key === 'ArrowRight') nextImage();
      if (e.key === 'ArrowLeft') prevImage();
      if (e.key === 'Escape') closeGallery();
      if (e.key === ' ') {
        e.preventDefault();
        toggleZoom();
      }
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

// Alpine.js Component: Auth Form (for password visibility toggles)
window.authForm = function() {
  return {
    showPassword: false,
    showPasswordConfirmation: false
  };
};