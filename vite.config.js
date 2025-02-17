import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import i18n from 'laravel-vue-i18n/vite'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/freelancer.css',
                'resources/js/app.js',
                'resources/js/freelancer.js',
                'resources/js/highlight.js',
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
        i18n(),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@': '/resources/js',
        },
    },
})
