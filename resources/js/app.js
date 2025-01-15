import './bootstrap'
import { createApp } from 'vue'
import { i18nVue } from 'laravel-vue-i18n'

import BlogHeader from './components/BlogHeader.vue'

const app = createApp({})

app.use(i18nVue, {
    resolve: lang => {
        const langs = import.meta.glob('../../lang/*.json', { eager: true });

        return langs[`../../lang/${lang}.json`].default;
    },
})

app.component('blog-header', BlogHeader)

app.mount('#app')
