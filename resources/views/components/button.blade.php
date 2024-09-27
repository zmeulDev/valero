<button
  {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center bg-gray-800 dark:bg-gray-600 dark:text-white px-4 py-2 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150']) }}>
  {{ $slot }}
</button>