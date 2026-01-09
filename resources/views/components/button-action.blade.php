@props(['href' => false])

@php
  $tag = $href ? 'a' : 'button';
  $baseClasses = 'inline-flex items-center rounded-md border border-transparent py-2 px-4 text-center text-sm transition-all text-text hover:bg-surface focus:bg-surface active:bg-surface disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none';
  $attrs = $attributes->merge(['class' => $baseClasses]);
@endphp

<{{ $tag }} {{ $attrs }} {{ $href ? 'href=' . $href : '' }}>
  {{ $slot }}
</{{ $tag }}>