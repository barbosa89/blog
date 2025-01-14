import path from 'path'
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue2'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/freelancer.css',
                'resources/js/app.js',
                'resources/js/freelancer.js'
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
            'vue': path.resolve(__dirname, 'node_modules/vue/dist/vue.esm.js'),
        }
    }
});