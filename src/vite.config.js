import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
     server: {
        host: "0.0.0.0",   // allow access from outside container
        port: 5173,
        strictPort: true,
    },
});
