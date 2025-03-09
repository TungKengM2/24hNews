import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/ckeditor.js',
            ],
            refresh: true,
        }),
    ],
    build: {
       
        rollupOptions: {
            external: ['bootstrap'],
        },
        input: {
            app: 'resources/js/app.js',
            ckeditor: 'resources/js/ckeditor.js',
        },
    },
});
