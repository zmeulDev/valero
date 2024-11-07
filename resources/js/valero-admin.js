document.addEventListener('DOMContentLoaded', function () {
  const themeToggleBtn = document.getElementById('theme-toggle');
  const darkIcon = document.getElementById('theme-toggle-dark-icon');
  const lightIcon = document.getElementById('theme-toggle-light-icon');
  
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

  if (typeof tinymce !== 'undefined') {
    tinymce.init({
      directionality: 'ltr',
      body_class: 'ltr',
      selector: '#content',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount code paste',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat code',
      height: 500,
      menubar: true,
      convert_urls: false,
      paste_as_text: true,
      content_style: `
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif; line-height: 1.6; direction: ltr !important; text-align: left !important; }
        code { background: #f4f4f4; padding: 2px 4px; border-radius: 4px; }
        blockquote { border-left: 4px solid #ddd; margin-left: 0; padding-left: 1em; }
      `,
      setup: function (editor) {
        editor.on('input', function () {
          updateCharCount('content');
        });

        function convertMarkdownToHtml(content) {
          // First handle fenced code blocks (```) to prevent interference with inline code
          content = content.replace(/```([a-z]*)\n([\s\S]*?)```/gm, function(match, language, code) {
              // If a language is specified, add it as a class
              const languageClass = language ? ` class="language-${language}"` : '';
              return `<pre><code${languageClass}>${code.trim()}</code></pre>`;
          });

          return content
              // Headers
              .replace(/^### (.*$)/gim, '<h3>$1</h3>')
              .replace(/^## (.*$)/gim, '<h2>$1</h2>')
              .replace(/^# (.*$)/gim, '<h1>$1</h1>')
              
              // Bold and Italic
              .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
              .replace(/\*(.*?)\*/g, '<em>$1</em>')
              
              // Lists
              .replace(/^\- (.*)/gm, '<ul><li>$1</li></ul>')
              .replace(/^\* (.*)/gm, '<ul><li>$1</li></ul>')
              .replace(/^\d\. (.*)/gm, '<ol><li>$1</li></ol>')
              
              // Links
              .replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2">$1</a>')
              
              // Inline code (single backticks)
              .replace(/`([^`]+)`/g, '<code>$1</code>')
              
              // Blockquotes
              .replace(/^> (.*$)/gim, '<blockquote>$1</blockquote>');
        }

        editor.on('PastePreProcess', function(e) {
          e.content = convertMarkdownToHtml(e.content);
        });

        editor.on('keydown', function (e) {
          if (e.key === 'Enter') {
            let content = editor.getContent();
            let selection = editor.selection;
            let bookmarkId = 'marker_' + (new Date()).getTime();
            
            // Add a bookmark to preserve cursor position
            selection.setContent('<span id="' + bookmarkId + '"></span>');
            
            content = convertMarkdownToHtml(content);
            editor.setContent(content);
            
            // Restore cursor position
            let bookmark = editor.getBody().querySelector('#' + bookmarkId);
            if (bookmark) {
                selection.select(bookmark);
                selection.collapse(false);
                bookmark.remove();
            }
          }
        });

        editor.on('paste', function(e) {
          e.preventDefault();
          const text = e.clipboardData.getData('text/plain');
          const convertedContent = convertMarkdownToHtml(text);
          editor.insertContent(convertedContent);
        });
      },
      paste_preprocess: function(plugin, args) {
        args.content = convertMarkdownToHtml(args.content);
      },
      paste_postprocess: function(plugin, args) {
        args.node.innerHTML = convertMarkdownToHtml(args.node.innerHTML);
      }
    });
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
