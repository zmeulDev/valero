<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
  <h3 class="text-xl font-bold text-gray-900 dark:text-white px-6 py-4 border-b border-gray-200 dark:border-gray-700">
    Share this article
  </h3>

  <!-- Share Buttons Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-6">
    <!-- Facebook Share Button -->
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}" target="_blank"
      rel="noopener noreferrer" aria-label="Share on Facebook"
      class="p-2 rounded-lg flex items-center justify-center border border-gray-300 transition-all duration-500 hover:border-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">
      <!-- Facebook SVG -->
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-facebook">
        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
      </svg>

    </a>

    <!-- Twitter Share Button -->
    <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($shareTitle) }}"
      target="_blank" rel="noopener noreferrer" aria-label="Share on Twitter"
      class="p-2 rounded-lg flex items-center justify-center border border-gray-300 transition-all duration-500 hover:border-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">
      <!-- Twitter SVG -->
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-twitter">
        <path
          d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" />
      </svg>
    </a>

    <!-- Instagram Share Button (Linked to Instagram Profile) -->
    <a href="https://www.instagram.com/your-profile" target="_blank" rel="noopener noreferrer"
      aria-label="Visit our Instagram"
      class="p-2 rounded-lg flex items-center justify-center border border-gray-300 transition-all duration-500 hover:border-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">
      <!-- Instagram SVG -->
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-instagram">
        <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
        <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
      </svg>
    </a>

    <!-- LinkedIn Share Button -->
    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($shareUrl) }}&title={{ urlencode($shareTitle) }}"
      target="_blank" rel="noopener noreferrer" aria-label="Share on LinkedIn"
      class="p-2 rounded-lg flex items-center justify-center border border-gray-300 transition-all duration-500 hover:border-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">
      <!-- LinkedIn SVG -->
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-linkedin">
        <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
        <rect width="4" height="12" x="2" y="9" />
        <circle cx="4" cy="4" r="2" />
      </svg>
    </a>

    <!-- WhatsApp Share Button -->
    <a href="https://api.whatsapp.com/send?text={{ urlencode($shareTitle) }}%20{{ urlencode($shareUrl) }}"
      target="_blank" rel="noopener noreferrer" aria-label="Share on WhatsApp"
      class="p-2 rounded-lg flex items-center justify-center border border-gray-300 transition-all duration-500 hover:border-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">
      <!-- WhatsApp SVG -->
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle">
        <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
      </svg>
    </a>
    <!-- Link Share Button (Copy to Clipboard) -->
    <button type="button" onclick="copyToClipboard('{{ $shareUrl }}')" aria-label="Copy link to clipboard"
      class="p-2 rounded-lg flex items-center justify-center border border-gray-300 transition-all duration-500 hover:border-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700">
      <!-- Link SVG -->
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-link">
        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
      </svg>
    </button>
  </div>
</div>

<!-- JavaScript for Copy to Clipboard Functionality -->
<script>
function copyToClipboard(text) {
  if (!navigator.clipboard) {
    // Fallback for browsers that do not support navigator.clipboard
    const textArea = document.createElement('textarea');
    textArea.value = text;
    textArea.style.position = 'fixed'; // Avoid scrolling to bottom
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();

    try {
      const successful = document.execCommand('copy');
      if (successful) {
        alert('Link copied to clipboard!');
      } else {
        alert('Failed to copy the link.');
      }
    } catch (err) {
      console.error('Fallback: Oops, unable to copy', err);
      alert('Failed to copy the link.');
    }

    document.body.removeChild(textArea);
    return;
  }

  navigator.clipboard.writeText(text).then(function() {
    alert('Link copied to clipboard!');
  }, function(err) {
    console.error('Could not copy text: ', err);
    alert('Failed to copy the link.');
  });
}
</script>