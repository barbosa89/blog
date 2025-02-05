<template>
    <div class="row">
        <div class="card mb-3 border-0">
            <div class="row g-0 shadow rounded">
                <div class="col-12 col-lg-8 position-relative overflow-hidden rounded-top featured-img">
                    <img :src="featured.image" class="img-fluid position-absolute top-0 start-0 w-100 h-100 img-zoom" :alt="featured.title">
                </div>
                <div class="col-12 col-lg-4 border ps-2 rounded-bottom featured-content">
                    <div class="card-body">
                        <h5 class="card-title fs-2">{{ featured.title }}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary mb-3">{{ $t('page.portfolio_projects.phenix.subtitle') }}</h6>
                        <p class="card-text">{{ $t('page.portfolio_projects.phenix.description') }}</p>
                        <p class="card-text">{{ $t('page.portfolio_projects.phenix.use_cases') }}</p>
                        <a :href="featured.link" target="_blank" rel="noopener noreferrer"
                            class="card-link btn btn-secondary mt-auto">{{
                                $t('page.portfolio_projects.phenix.button_action') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div v-for="project in nonFeatured" class="col-12 col-md-4 vertical-card mt-3">
            <div
                class="card bg-white text-white border-0 shadow h-100 position-relative overflow-hidden rounded cursor-pointer">
                <img class="card-img position-absolute top-0 start-0 w-100 h-100 img-zoom" :src="project.image" :alt="project.title">
                <div
                    class="card-img-overlay d-flex flex-column justify-content-end overlay-gradient pointer-events-none">
                </div>
                <div class="text-dark position-absolute bottom-0 start-0 p-3 preview-project-title">
                    <h5 class="card-title text-white">{{ project.title }}</h5>
                    <p class="card-text text-white">{{ project.description }}</p>
                    <a :href="project.link" target="_blank" rel="noopener noreferrer"
                        class="card-link btn btn-primary mt-auto">{{ project.action }}</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { wTrans } from 'laravel-vue-i18n';
import { ref } from 'vue'

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
        description: wTrans('page.portfolio_projects.hellen_suite.description'),
        image: '/images/portfolio/hellen-suite.jpg',
        link: 'https://hellensuite.com',
        action: wTrans('page.portfolio_projects.hellen_suite.button_action'),
    },
    {
        id: 'invoice',
        title: 'Invoice templates',
        description: wTrans('page.portfolio_projects.invoice_template.description'),
        image: '/images/portfolio/invoice-template.png',
        link: 'https://github.com/barbosa89/invoice-template',
        action: wTrans('page.portfolio_projects.invoice_template.button_action'),
    },
    {
        id: 'posada-sueno-real',
        title: 'Posada Sueño Real',
        description: wTrans('page.portfolio_projects.posada.description'),
        image: '/images/portfolio/posada.webp',
        link: 'https://posadasuenoreal.com',
        action: wTrans('page.portfolio_projects.posada.button_action'),
    },
    {
        id: 'apces',
        title: 'APCES E.S.P.',
        subtitle: 'Corporative website',
        description: wTrans('page.portfolio_projects.apces.description'),
        image: '/images/portfolio/apces.jpg',
        link: 'https://apces.com.co',
        action: wTrans('page.portfolio_projects.apces.button_action'),
    },
    {
        id: 'teo',
        title: 'Tribunal Odontológico de Santander',
        description: wTrans('page.portfolio_projects.teo.description'),
        image: '/images/portfolio/teo.jpg',
        link: 'https://teosantander.com/',
        action: wTrans('page.portfolio_projects.apces.button_action'),
    },
    {
        id: 'tlsi',
        title: 'Transportes logísticos y servicios de ingeniería',
        description: wTrans('page.portfolio_projects.tlsi.description'),
        image: '/images/portfolio/tlsi.jpg',
        link: 'https://tlsi.com.co/',
        action: wTrans('page.portfolio_projects.tlsi.button_action'),
    },
])
</script>

<style lang="scss" scoped>
.featured-img {
    min-height: 500px;
}

.vertical-card {
    min-height: 400px;
}

.preview-project-title {
    bottom: 0;
}

.card-text {
    font-size: 1.2rem;
}

.img-zoom {
    object-fit: cover; transition: transform 0.3s ease;
}

.img-zoom:hover {
    transform: scale(1.1);
}

.pointer-events-none {
    pointer-events: none;
}

.overlay-gradient {
    background: #2C3E50;
    background: linear-gradient(transparent, #000000);
    background: -moz-linear-gradient(transparent, #000000);
    background: -webkit-linear-gradient(transparent, #000000);
}

@media (min-width: 991.98px) {
    .featured-img {
        min-height: 500px;
        border-bottom-right-radius: 0 !important;
        border-top-right-radius: 0 !important;
        border-bottom-left-radius: var(--bs-border-radius) !important;
        border-top-left-radius: var(--bs-border-radius) !important;
    }

    .featured-content {
        border-bottom-right-radius: var(--bs-border-radius) !important;
        border-top-right-radius: var(--bs-border-radius) !important;
        border-bottom-left-radius: 0 !important;
        border-top-left-radius: 0 !important;
    }
}
</style>