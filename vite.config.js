import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/valero-admin.js',
                'resources/js/valero-frontend.js',
            ],
            refresh: true,
        }),
    ],
});
