import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/valero-frontend.js',
                'resources/js/valero-admin.js'
            ],
            refresh: true,
        }),
    ],
});
