import './bootstrap'
import { createApp } from 'vue'
import { i18nVue } from 'laravel-vue-i18n'

import AdsFeed from './components/ads/Feed.vue'
import BlogHeader from './components/BlogHeader.vue'
import PortfolioProjects from './components/PortfolioProjects.vue'

const app = createApp({})

app.use(i18nVue, {
    resolve: async lang => {
        const langs = import.meta.glob('../../lang/*.json');

        return await langs[`../../lang/${lang}.json`]();
    }
})

app.component('ads-feed', AdsFeed)
app.component('blog-header', BlogHeader)
app.component('portfolio-projects', PortfolioProjects)

app.mount('#app')
