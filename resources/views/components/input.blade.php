@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'dark:bg-gray-600 dark:text-white
focus:ring-grey-600 focus:border-grey-600 rounded-lg shadow-sm']) !!}>