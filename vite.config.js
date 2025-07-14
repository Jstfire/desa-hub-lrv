import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';

export default defineConfig({
    build: {
        // Improve chunk size for better performance
        chunkSizeWarningLimit: 1600,
        rollupOptions: {
            output: {
                manualChunks: {
                    // Split large dependencies into separate chunks
                    'tinymce': ['tinymce'],
                    'alpine': ['alpinejs'],
                    'charts': ['chart.js'],
                }
            }
        }
    },
    plugins: [
        laravel({
            input: [
                // Main application assets
                'resources/css/app.css',
                'resources/js/app.js',

                // Alpine.js assets
                'resources/js/alpine.js',
                'resources/js/alpine-plugins.js',

                // Filament assets
                'resources/css/filament/superadmin/theme.css',
                'resources/js/filament-init.js',
                'resources/js/filament-sidebar-fix.js',

                // TinyMCE setup
                'resources/js/tinymce-setup.js',

                // Additional frontend scripts
                'resources/js/stores/index.js',
                'resources/js/gallery.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            'tinymce': resolve(__dirname, 'node_modules/tinymce'),
            '@': resolve(__dirname, 'resources'),
        },
    },
    // Ensure Filament assets are properly processed
    optimizeDeps: {
        include: [
            'alpinejs',
            'tinymce',
            '@alpinejs/persist',
            '@alpinejs/focus',
            '@alpinejs/collapse',
            '@alpinejs/intersect'
        ]
    }
});
