@props(['href' => false])

@php
$tag = $href ? 'a' : 'button';
$baseClasses = 'inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs
text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500
focus:ring-offset-2 disabled:opacity-25 transition ease-in-out delay-150 hover:-translate-y-1';
$attrs = $attributes->merge(['class' => $baseClasses]);
@endphp

<{{ $tag }} {{ $attrs }} {{ $href ? 'href='.$href : '' }}>
  {{ $slot }}
</{{ $tag }}>