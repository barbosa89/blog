import { createApp } from 'vue';
import '@justinribeiro/lite-youtube';
import { createAppI18n } from '@/lang/i18n.js';
import { createIcons, Menu, X, Search, CircleX, ChevronUp, ChevronDown, Code2, BriefcaseBusiness, Share2, Calendar, Send, ArrowUpRight, Mail } from 'lucide';

createIcons({
    icons: {
        Menu,
        X,
        Search,
        CircleX,
        ChevronUp,
        ChevronDown,
        Code2,
        BriefcaseBusiness,
        Share2,
        Calendar,
        Send,
        ArrowUpRight,
        Mail,
    },
});

import FeedAd from '@/components/ads/Feed.vue';
import ArticleAd from '@/components/ads/Article.vue';
import LocaleSwitcher from '@/components/LocaleSwitcher.vue';
import SiteNavbar from '@/components/SiteNavbar.vue';
import ProgrammersIcon from '@/components/icons/Programmers.vue';

const app = createApp({});

app.use(createAppI18n());

app.component('feed-ad', FeedAd);
app.component('article-ad', ArticleAd);
app.component('locale-switcher', LocaleSwitcher);
app.component('programmers-icon', ProgrammersIcon);
app.component('site-navbar', SiteNavbar);

app.mount('#app');
