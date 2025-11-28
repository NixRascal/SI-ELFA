import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/admin/laporan-print.css', 'resources/css/admin/laporan-hasil.css', 'resources/js/admin/laporan-hasil.js', 'resources/css/admin/manajemen-index.css', 'resources/js/admin/manajemen-index.js', 'resources/js/admin/kuesioner-form.js', 'resources/css/admin/kuesioner-index.css', 'resources/js/admin/kuesioner-index.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
