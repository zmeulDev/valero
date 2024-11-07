<div id="galleryModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 hidden">
  <div class="relative w-full h-full max-w-4xl max-h-full p-4">
    <img id="galleryImage" src="" alt="Gallery Image" class="w-full h-full object-contain">
    <button id="prevButton"
      class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition">
      <x-lucide-arrow-left class="w-6 h-6" />
    </button>
    <button id="nextButton"
      class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition">
      <x-lucide-arrow-right class="w-6 h-6" />
    </button>
    <button id="closeButton"
      class="absolute top-4 right-4 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75 transition">
      <x-lucide-x class="w-6 h-6" />
    </button>
  </div>
</div>