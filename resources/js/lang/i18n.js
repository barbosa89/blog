import { createI18n } from 'vue-i18n';
import locales from '@/lang/locales.js';

const i18n = createI18n({
    locale: globalThis?.App?.locale ?? 'en',
    fallbackLocale: 'en',
    legacy: false,
    warnHtmlMessage: false,
    messages: {
        en: locales.en,
        es: locales.es,
        pt: locales.pt,
    },
});

const createAppI18n = () => i18n;

export { createAppI18n, i18n };
