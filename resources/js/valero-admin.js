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

document.addEventListener('DOMContentLoaded', function () {
  ['title', 'excerpt'].forEach(id => {
    const element = document.getElementById(id);
    if (element) {
      element.addEventListener('input', () => updateCharCount(id, id === 'title' ? 60 : 160));
      updateCharCount(id, id === 'title' ? 60 : 160);
    }
  });
  // Content character count will be updated by TinyMCE setup
});
