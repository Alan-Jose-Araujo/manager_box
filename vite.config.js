import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // Seus pontos de entrada CSS e JS
            input: ['resources/css/app.css', 'resources/js/app.js'],
            // Mantendo o refresh ativado para Live Reload
            refresh: true,
        }),
    ],
});
