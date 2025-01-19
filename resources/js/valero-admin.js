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

  ['tags'].forEach(id => {
    const element = document.getElementById(id);
    if (element) {
        element.addEventListener('input', () => updateTagCount(id, 10, 100));
        updateTagCount(id, 10, 100);
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

function updateTagCount(id, maxTags, maxChars) {
    const element = document.getElementById(id);
    const counter = document.getElementById(`${id}-counter`);
    
    if (element && counter) {
        const value = element.value;
        const totalChars = value.length;
        const tags = value
            .split(',')
            .map(tag => tag.trim())
            .filter(tag => tag.length > 0);
            
        const count = tags.length;
        
        // Update counter text with both limits
        counter.textContent = `${count}/${maxTags} tags (${totalChars}/${maxChars} chars)`;
        
        // Visual feedback for exceeding either limit
        if (count > maxTags || totalChars > maxChars) {
            counter.classList.add('text-red-500');
            counter.classList.remove('text-gray-500');
        } else {
            counter.classList.remove('text-red-500');
            counter.classList.add('text-gray-500');
        }
        
        // Optional: Truncate if exceeding character limit
        if (totalChars > maxChars) {
            element.value = value.substring(0, maxChars);
        }
    }
}
