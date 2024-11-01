document.addEventListener('DOMContentLoaded', function () {
  const themeToggleBtn = document.getElementById('theme-toggle');
  const darkIcon = document.getElementById('theme-toggle-dark-icon');
  const lightIcon = document.getElementById('theme-toggle-light-icon');
  
  if (typeof tinymce !== 'undefined') {
    tinymce.init({
      selector: '#content',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
      height: 500,
      setup: function (editor) {
        editor.on('input', function () {
          updateCharCount('content');
        });
      }
    });
  }

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

  // Add logo refresh handler
  if (window.location.pathname.includes('/admin/settings')) {
    const form = document.getElementById('settings-form');
    if (form) {
      form.addEventListener('submit', function (e) {
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

  ['title', 'excerpt'].forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      element.addEventListener('input', () => updateCharCount(id, id === 'title' ? 60 : 160));
      updateCharCount(id, id === 'title' ? 60 : 160);
    }
  });
  // Content character count will be updated by TinyMCE setup

  const settingsForm = document.getElementById('settings-form');
  if (settingsForm) {
    settingsForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(settingsForm);
      
      fetch(settingsForm.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.refresh) {
          window.location.reload(true);
        }
      });
    });
  }
});

function updateCharCount(elementId, limit = null) {
  let content;
  if (elementId === 'content') {
    content = tinymce.get('content').getContent({
      format: 'text'
    });
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
