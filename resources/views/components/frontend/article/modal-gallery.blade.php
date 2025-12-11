<!-- Enhanced Gallery Modal -->
<div id="galleryModal" 
     class="fixed inset-0 z-50 hidden bg-black/95 backdrop-blur-sm transition-opacity duration-300"
     role="dialog" 
     aria-modal="true" 
     aria-labelledby="gallery-title">
  
  <!-- Top Bar -->
  <div class="absolute top-0 left-0 right-0 z-10 bg-gradient-to-b from-black/80 to-transparent">
    <div class="flex items-center justify-between p-4">
      <!-- Image Counter -->
      <div class="flex items-center gap-3">
        <h2 id="gallery-title" class="text-white text-lg font-medium">
          Gallery
        </h2>
        <span id="galleryCounter" class="text-white/70 text-sm font-mono">
          1 / 1
        </span>
      </div>
      
      <!-- Actions -->
      <div class="flex items-center gap-2">
        <!-- Download Button -->
        <button id="downloadButton"
                class="p-2.5 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-all duration-200 hover:scale-110"
                title="Download image"
                aria-label="Download image">
          <x-lucide-download class="w-5 h-5" />
        </button>
        
        <!-- Zoom Toggle -->
        <button id="zoomButton"
                class="p-2.5 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-all duration-200 hover:scale-110"
                title="Toggle zoom"
                aria-label="Toggle zoom">
          <x-lucide-zoom-in class="w-5 h-5" />
        </button>
        
        <!-- Fullscreen Toggle -->
        <button id="fullscreenButton"
                class="p-2.5 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-all duration-200 hover:scale-110"
                title="Toggle fullscreen"
                aria-label="Toggle fullscreen">
          <x-lucide-maximize class="w-5 h-5" />
        </button>
        
        <!-- Close Button -->
        <button id="closeButton"
                class="p-2.5 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-all duration-200 hover:scale-110"
                title="Close gallery (ESC)"
                aria-label="Close gallery">
          <x-lucide-x class="w-5 h-5" />
        </button>
      </div>
    </div>
  </div>

  <!-- Main Image Container -->
  <div class="absolute inset-0 flex items-center justify-center p-4 pt-20 pb-32">
    <!-- Loading Spinner -->
    <div id="imageLoader" class="absolute inset-0 flex items-center justify-center hidden">
      <div class="animate-spin rounded-full h-16 w-16 border-4 border-white/20 border-t-white"></div>
    </div>
    
    <!-- Image -->
    <div id="imageContainer" class="relative w-full h-full flex items-center justify-center">
      <img id="galleryImage" 
           src="" 
           alt="Gallery Image" 
           class="max-w-full max-h-full object-contain cursor-zoom-in transition-transform duration-300"
           draggable="false">
    </div>
  </div>

  <!-- Navigation Buttons -->
  <button id="prevButton"
          class="absolute left-4 top-1/2 -translate-y-1/2 p-4 rounded-full bg-white/10 hover:bg-white/20 text-white transition-all duration-200 hover:scale-110 backdrop-blur-sm disabled:opacity-30 disabled:cursor-not-allowed"
          title="Previous image (←)"
          aria-label="Previous image">
    <x-lucide-chevron-left class="w-6 h-6" />
  </button>
  
  <button id="nextButton"
          class="absolute right-4 top-1/2 -translate-y-1/2 p-4 rounded-full bg-white/10 hover:bg-white/20 text-white transition-all duration-200 hover:scale-110 backdrop-blur-sm disabled:opacity-30 disabled:cursor-not-allowed"
          title="Next image (→)"
          aria-label="Next image">
    <x-lucide-chevron-right class="w-6 h-6" />
  </button>

  <!-- Thumbnail Strip -->
  <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent">
    <div id="thumbnailStrip" class="flex gap-2 p-4 overflow-x-auto scrollbar-hide">
      <!-- Thumbnails will be dynamically added here -->
    </div>
  </div>

  <!-- Touch Area for Mobile Swipe Detection -->
  <div id="touchArea" class="absolute inset-0 pointer-events-none"></div>
</div>

<style>
  /* Hide scrollbar for thumbnail strip */
  .scrollbar-hide::-webkit-scrollbar {
    display: none;
  }
  .scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
  
  /* Zoom cursor */
  .cursor-zoom-in {
    cursor: zoom-in;
  }
  .cursor-zoom-out {
    cursor: zoom-out;
  }
  
  /* Smooth transitions */
  #galleryModal.modal-enter {
    animation: fadeIn 0.3s ease-out;
  }
  #galleryModal.modal-exit {
    animation: fadeOut 0.3s ease-out;
  }
  
  @keyframes fadeIn {
    from {
      opacity: 0;
    }
    to {
      opacity: 1;
    }
  }
  
  @keyframes fadeOut {
    from {
      opacity: 1;
    }
    to {
      opacity: 0;
    }
  }
</style>