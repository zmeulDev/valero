import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue', // If you're using Vue or other frameworks
        './resources/js/**/*.jsx', // If you're using React
        './resources/js/**/*.tsx', // If you're using TypeScript with React
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                serif: ['Merriweather', ...defaultTheme.fontFamily.serif], // Adding serif in case it's needed
            },
            colors: {
                'valero-success': {
                    100: '#e6f0f5',
                    500: '#243c5a',
                    700: '#1a2c42',
                },
                'valero-error': {
                    100: '#fee2e2',
                    500: '#dc2626',
                    700: '#b91c1c',
                },
                'valero-info': {
                    100: '#e0f2fe',
                    500: '#0ea5e9',
                    700: '#0369a1',
                },
                'valero-warning': {
                    100: '#fef3c7',
                    500: '#f59e0b',
                    700: '#b45309',
                },
            },
        },
        screens: {
            'sm': '640px',
            'md': '768px',
            'lg': '1024px',
            'xl': '1280px',
            '2xl': '1536px',
        },
    },

    plugins: [
        forms,
        typography,
    ],

    safelist: [
        'bg-valero-success-100', 'bg-valero-error-100', 'bg-valero-info-100', 'bg-valero-warning-100',
        'border-valero-success-500', 'border-valero-error-500', 'border-valero-info-500', 'border-valero-warning-500',
        'text-valero-success-700', 'text-valero-error-700', 'text-valero-info-700', 'text-valero-warning-700',
    ],
};