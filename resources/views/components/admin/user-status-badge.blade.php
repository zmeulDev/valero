@props(['active'])

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
    {{ $active ? 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200' }}">
    <span class="w-1.5 h-1.5 rounded-full {{ $active ? 'bg-green-600' : 'bg-red-600' }} mr-1.5"></span>
    {{ $active ? 'Active' : 'Inactive' }}
</span> 