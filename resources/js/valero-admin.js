import tinymceConfig from './tinymce-config';

document.addEventListener('DOMContentLoaded', function () {
  const themeToggleBtn = document.getElementById('theme-toggle-admin');
  const darkIcon = document.getElementById('theme-toggle-dark-icon-admin');
  const lightIcon = document.getElementById('theme-toggle-light-icon-admin');

  if (themeToggleBtn && darkIcon && lightIcon) {
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

    applyTheme();

    themeToggleBtn.addEventListener('click', function () {
      darkIcon.classList.toggle('hidden');
      lightIcon.classList.toggle('hidden');

      if (document.documentElement.classList.contains('dark')) {
        document.documentElement.classList.remove('dark');
        localStorage.setItem('color-theme', 'light');
      } else {
        document.documentElement.classList.add('dark');
        localStorage.setItem('color-theme', 'dark');
      }
    });
  }

  if (document.querySelector('#content')) {
    tinymce.init(tinymceConfig);
  }

  ['title', 'excerpt'].forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      element.addEventListener('input', () => updateCharCount(id, id === 'title' ? 60 : 160));
      updateCharCount(id, id === 'title' ? 60 : 160);
    }
  });

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
  if (elementId === 'content' && typeof tinymce !== 'undefined') {
    content = tinymce.get('content').getContent({
      format: 'text'
    });
  } else {
    const element = document.getElementById(elementId);
    if (!element) return;
    content = element.value;
  }
  const charCount = document.getElementById(elementId + '-char-count');
  if (!charCount) return;

  charCount.textContent = content.length;

  if (limit && content.length > limit) {
    charCount.classList.add('text-red-500');
  } else {
    charCount.classList.remove('text-red-500');
  }
}
