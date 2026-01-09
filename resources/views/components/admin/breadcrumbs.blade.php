@props(['items' => []])

<nav class="flex" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-4">
        <li>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="text-muted hover:text-text transition-colors">
                    <x-lucide-home class="flex-shrink-0 h-5 w-5" />
                    <span class="sr-only">{{ __('admin.common.home') }}</span>
                </a>
            </div>
        </li>
        @foreach($items as $item)
            <li>
                <div class="flex items-center">
                    <x-lucide-chevron-right class="flex-shrink-0 h-5 w-5 text-muted" />
                    @if(isset($item['url']))
                        <a href="{{ $item['url'] }}"
                            class="ml-4 text-sm font-medium text-muted hover:text-text transition-colors">
                            {{ $item['label'] }}
                        </a>
                    @else
                        <span class="ml-4 text-sm font-medium text-indigo-600 dark:text-indigo-400">
                            {{ $item['label'] }}
                        </span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>