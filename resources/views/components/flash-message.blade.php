  @if (session('success') || session('error') || session('info') || session('warning'))
  @php
  $type = session('success') ? 'success' : (session('error') ? 'error' : (session('info') ? 'info' : 'warning'));
  $message = session($type);
  $colors = [
  'success' => 'blue',
  'error' => 'red',
  'info' => 'teal',
  'warning' => 'orange'
  ];
  $color = $colors[$type];
  @endphp


  <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-2" class="fixed top-0 right-0 mt-4 mr-4 w-1/5 max-w-sm z-50"
    style="z-index: 9999;" role="alert">
    <div class="bg-{{ $color }}-100 border-l-4 border-{{ $color }}-500 text-{{ $color }}-700 p-4 rounded-md shadow-md">
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <div class="py-1 mr-3">
            @if ($type === 'success')
            <x-lucide-check-circle class="w-6 h-6 text-{{ $color }}-500" />
            @elseif ($type === 'error')
            <x-lucide-x-circle class="w-6 h-6 text-{{ $color }}-500" />
            @elseif ($type === 'info')
            <x-lucide-info class="w-6 h-6 text-{{ $color }}-500" />
            @else
            <x-lucide-alert-triangle class="w-6 h-6 text-{{ $color }}-500" />
            @endif
          </div>
          <div>
            <p class="font-bold">{{ ucfirst($type) }}</p>
            <p>{{ $message }}</p>
          </div>
        </div>
        <button @click="show = false" class="text-{{ $color }}-500 hover:text-{{ $color }}-700">
          <x-lucide-x-circle class="w-4 h-4" />
        </button>
      </div>
    </div>
  </div>
  @endif