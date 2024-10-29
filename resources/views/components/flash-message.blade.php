@if (session('success') || session('error') || session('info') || session('warning'))
@php
$type = session('success') ? 'success' : (session('error') ? 'error' : (session('info') ? 'info' : 'warning'));
$message = session($type);
$colors = [
'success' => 'valero-success',
'error' => 'valero-error',
'info' => 'valero-info',
'warning' => 'valero-warning'
];
$color = $colors[$type];
@endphp

<div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
  x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2"
  x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300"
  x-transition:leave-start="opacity-100 transform translate-y-0"
  x-transition:leave-end="opacity-0 transform translate-y-2"
  class="fixed bottom-5 right-5 px-4 py-2 mt-4 mx-auto w-full sm:w-96 z-50" style="z-index: 9999;" role="alert">
  <div class="bg-{{ $color }}-100 border-l-4 border-{{ $color }}-500 text-{{ $color }}-700 p-4 rounded-md shadow-md">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <div class="flex-shrink-0 mr-3">
          @if ($type === 'success')
          <x-lucide-check-circle class="w-5 h-5 text-{{ $color }}-500" />
          @elseif ($type === 'error')
          <x-lucide-x-circle class="w-5 h-5 text-{{ $color }}-500" />
          @elseif ($type === 'info')
          <x-lucide-info class="w-5 h-5 text-{{ $color }}-500" />
          @else
          <x-lucide-alert-triangle class="w-5 h-5 text-{{ $color }}-500" />
          @endif
        </div>
        <div class="flex-grow">
          <p class="font-bold text-sm">{{ ucfirst($type) }}</p>
          <p class="text-sm">{{ $message }}</p>
        </div>
      </div>
      <button @click="show = false" class="ml-4 text-{{ $color }}-500 hover:text-{{ $color }}-700">
        <x-lucide-x-circle class="w-4 h-4" />
      </button>
    </div>
  </div>
</div>
@endif