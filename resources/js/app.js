import './bootstrap'
import { createApp } from 'vue'
import { i18nVue } from 'laravel-vue-i18n'

import BlogHeader from './components/BlogHeader.vue'

const app = createApp({})

app.use(i18nVue, {
    resolve: async lang => {
        const langs = import.meta.glob('../../lang/*.json');

        return await langs[`../../lang/${lang}.json`]();
    }
})

app.component('blog-header', BlogHeader)

app.mount('#app')
