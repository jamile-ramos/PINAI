import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true, // hot-reload no local
            // não use buildDirectory
        }),
    ],
    build: {
        outDir: 'public/build', // saída final
        manifest: true,         // gera manifest.json
        emptyOutDir: true,      // limpa a pasta antes
        rollupOptions: {
            input: ['resources/css/app.css', 'resources/js/app.js'],
        },
    },
});
