<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
  <div
    class="flex flex-col md:flex-row items-center justify-center md:space-x-8 w-full sm:max-w-4xl mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
    <div class="md:w-1/2 flex justify-center mb-4 md:mb-0">
      {{ $logo }}

    </div>
    <div class="md:w-1/2">
      {{ $slot }}
    </div>
  </div>
</div>