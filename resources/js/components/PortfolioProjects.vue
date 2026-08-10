<template>
    <div class="space-y-8">
        <article class="group overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl lg:grid lg:grid-cols-12">
            <div class="relative min-h-[320px] lg:col-span-8">
                <img
                    :src="featured.image"
                    :alt="featured.title"
                    class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/35 to-transparent"></div>
            </div>

            <div class="flex flex-col gap-4 p-6 lg:col-span-4 lg:p-8">
                <h3 class="text-3xl font-black text-slate-900">{{ featured.title }}</h3>
                <p class="text-sm font-semibold uppercase tracking-[0.08em] text-emerald-600">{{ $t('page.portfolio_projects.phenix.subtitle') }}</p>
                <p class="text-base leading-relaxed text-slate-700">{{ $t('page.portfolio_projects.phenix.description') }}</p>
                <p class="text-base leading-relaxed text-slate-700">{{ $t('page.portfolio_projects.phenix.use_cases') }}</p>

                <a
                    :href="featured.link"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-auto inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-600"
                >
                    {{ $t('page.portfolio_projects.phenix.button_action') }}
                </a>
            </div>
        </article>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            <article
                v-for="project in nonFeatured"
                :key="project.id"
                class="group relative min-h-[360px] overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-md"
            >
                <img
                    class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105"
                    :src="project.image"
                    :alt="project.title"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/50 to-transparent"></div>

                <div class="absolute inset-x-0 bottom-0 p-5">
                    <h4 class="text-xl font-bold text-white">{{ project.title }}</h4>
                    <p class="mt-2 text-sm leading-relaxed text-slate-200">{{ project.description }}</p>

                    <a
                        :href="project.link"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-4 inline-flex items-center rounded-full border border-white/60 bg-white/10 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white hover:text-slate-900"
                    >
                        {{ project.action }}
                    </a>
                </div>
            </article>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const featured = ref({
    id: 'phenix',
    title: 'PhenixPHP',
    subtitle: 'A simple PHP framework',
    image: '/images/portfolio/phenix.webp',
    link: 'https://phenix.omarbarbosa.com',
    action: 'Code with Phenix',
})

const nonFeatured = ref([
    {
        id: 'helen',
        title: 'Hellen Suite',
        description: t('page.portfolio_projects.hellen_suite.description'),
        image: '/images/portfolio/hellen-suite.webp',
        link: 'https://hellensuite.com',
        action: t('page.portfolio_projects.hellen_suite.button_action'),
    },
    {
        id: 'invoice',
        title: 'Invoice templates',
        description: t('page.portfolio_projects.invoice_template.description'),
        image: '/images/portfolio/invoice-template.webp',
        link: 'https://github.com/barbosa89/invoice-template',
        action: t('page.portfolio_projects.invoice_template.button_action'),
    },
    {
        id: 'posada-sueno-real',
        title: 'Posada Sueño Real',
        description: t('page.portfolio_projects.posada.description'),
        image: '/images/portfolio/posada.webp',
        link: 'https://posadasuenoreal.com',
        action: t('page.portfolio_projects.posada.button_action'),
    },
    {
        id: 'apces',
        title: 'APCES E.S.P.',
        subtitle: 'Corporative website',
        description: t('page.portfolio_projects.apces.description'),
        image: '/images/portfolio/apces.webp',
        link: 'https://apces.com.co',
        action: t('page.portfolio_projects.apces.button_action'),
    },
    {
        id: 'teo',
        title: 'Tribunal Odontológico de Santander',
        description: t('page.portfolio_projects.teo.description'),
        image: '/images/portfolio/teo.webp',
        link: 'https://teosantander.com/',
        action: t('page.portfolio_projects.teo.button_action'),
    },
    {
        id: 'tlsi',
        title: 'TLSI',
        description: t('page.portfolio_projects.tlsi.description'),
        image: '/images/portfolio/tlsi.webp',
        link: 'https://tlsi.com.co/',
        action: t('page.portfolio_projects.tlsi.button_action'),
    },
])
</script>