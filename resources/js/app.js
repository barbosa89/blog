import { createApp } from 'vue';
import { createAppI18n } from '@/lang/i18n.js';
import { createIcons, Menu, X, Search, ChevronUp, ChevronDown, BriefcaseBusiness, Share2, Send, ArrowRight, ArrowUpRight, Mail } from 'lucide';

window.liteYouTubeNonce = document.documentElement.dataset.cspNonce;

import('@justinribeiro/lite-youtube');

createIcons({
    icons: {
        Menu,
        X,
        Search,
        ChevronUp,
        ChevronDown,
        BriefcaseBusiness,
        Share2,
        Send,
        ArrowRight,
        ArrowUpRight,
        Mail,
    },
});

import FeedAd from '@/components/ads/Feed.vue';
import ArticleAd from '@/components/ads/Article.vue';
import LocaleSwitcher from '@/components/LocaleSwitcher.vue';
import SiteNavbar from '@/components/SiteNavbar.vue';

const app = createApp({});

app.config.compilerOptions.isCustomElement = (tag) => tag === 'lite-youtube';

app.use(createAppI18n());

app.component('feed-ad', FeedAd);
app.component('article-ad', ArticleAd);
app.component('locale-switcher', LocaleSwitcher);
app.component('site-navbar', SiteNavbar);

app.mount('#app');
