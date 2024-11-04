@props(['role'])

@php
$colors = [
    'admin' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-200',
    'editor' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-200',
    'user' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200'
];

$dotColors = [
    'admin' => 'bg-purple-600',
    'editor' => 'bg-blue-600',
    'user' => 'bg-green-600'
];
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$role] }}">
    <span class="w-1.5 h-1.5 rounded-full {{ $dotColors[$role] }} mr-1.5"></span>
    {{ ucfirst($role) }}
</span> 