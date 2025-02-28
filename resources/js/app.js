import './bootstrap'
import { createApp } from 'vue'
import { i18nVue } from 'laravel-vue-i18n'
import '@justinribeiro/lite-youtube'

import FeedAd from './components/ads/Feed.vue'
import ArticleAd from './components/ads/Article.vue'
import BlogHeader from './components/BlogHeader.vue'
import PortfolioProjects from './components/PortfolioProjects.vue'
import ProgrammersIcon from './components/icons/Programmers.vue'

const app = createApp({})

app.use(i18nVue, {
    resolve: async lang => {
        const langs = import.meta.glob('../../lang/*.json');

        return await langs[`../../lang/${lang}.json`]();
    }
})

app.component('feed-ad', FeedAd)
app.component('article-ad', ArticleAd)
app.component('blog-header', BlogHeader)
app.component('portfolio-projects', PortfolioProjects)
app.component('programmers-icon', ProgrammersIcon)

app.mount('#app')
