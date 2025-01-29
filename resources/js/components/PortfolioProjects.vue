<template>
    <div class="row px-2">
        <div class="col-12 col-md-8 position-relative overflow-hidden rounded-0 rounded-md featured-col shadow">
            <img class="img-fluid position-absolute top-0 start-0 w-100 h-100 img-zoom rounded" :src="featured.image" :alt="featured.title" style="object-fit: cover; transition: transform 0.3s ease;">
        </div>
        <div class="col-12 col-md-4 featured-col mt-3 mt-md-0 px-0 px-md-2">
            <div class="card border-0 shadow h-100 p-3">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title fs-2">{{ featured.title }}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">{{ featured.subtitle }}</h6>
                        <p class="card-text">{{ featured.description }}</p>
                    </div>
                    <div>
                        <a :href="featured.link" target="_blank" rel="noopener noreferrer" class="card-link btn btn-secondary mt-auto">{{ featured.action }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div v-for="project in nonFeatured" class="col-12 col-md-4 vertical-card mt-3">
            <div class="card bg-white text-white border-0 shadow h-100 position-relative overflow-hidden rounded cursor-pointer">
                <img class="card-img position-absolute top-0 start-0 w-100 h-100 img-zoom" :src="project.image" alt="Project 1" style="object-fit: cover; transition: transform 0.3s ease;">
                <div class="card-img-overlay d-flex flex-column justify-content-end overlay-gradient pointer-events-none"></div>
                <div class="text-dark position-absolute bottom-0 start-0 p-3 preview-project-title">
                    <h5 class="card-title text-white">{{ project.title }}</h5>
                    <h6 class="card-subtitle mb-2 text-white">{{ project.subtitle }}</h6>
                    <a :href="project.link" target="_blank" rel="noopener noreferrer" class="card-link btn btn-light mt-auto">Card link</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const featured = ref(    {
    id: 'phenix',
    title: 'PhenixPHP',
    subtitle: 'A simple PHP framework',
    description: 'Phenix is a web framework built on pure PHP, based on the Amphp ecosystem, which provides non-blocking operations, asynchronism, and parallel code execution natively. It runs in the PHP SAPI CLI and on its own server; it is simply powerful.',
    image: '/images/portfolio/phenix.webp',
    link: 'https://phenix.omarbarbosa.com',
    action: 'Code with Phenix',
})
const nonFeatured = ref([
    {
        id: 'helen',
        title: 'Hellen Suite',
        subtitle: 'A hotel management system',
        description: 'Hellen Suite is a hotel management system that provides a complete solution for managing hotel operations. It is a web-based system that allows hoteliers to manage their hotel from anywhere in the world.',
        image: '/images/portfolio/hellen-suite.jpg',
        link: 'https://hellensuite.com',
        featured: false,
    },
    {
        id: 'invoice',
        title: 'Invoice templates',
        subtitle: 'Print beautiful invoices',
        description: 'This an invoice template with support for Bootstrap 3, 4 y 5 and Tailwind CSS.',
        image: '/images/portfolio/invoice-template.png',
        link: 'https://github.com/barbosa89/invoice-template',
        featured: false,
    },
    {
        id: 'posada-sueno-real',
        title: 'Posada Sueño Real',
        subtitle: 'A hotel management system',
        description: 'Reservation system and landing page for the Posada Sueño Real hotel, written in PHP on the backend, Jquery for frontend interaction.',
        image: '/images/portfolio/posada.webp',
        link: 'https://posadasuenoreal.com',
        featured: false,
    },
    {
        id: 'apces',
        title: 'APCES E.S.P.',
        subtitle: 'Corporative website',
        description: 'Vue Table is a Vue component that allows you to create tables with pagination, sorting, and filtering. It is a simple and easy-to-use component that can be used in any Vue project.',
        image: '/images/portfolio/apces.jpg',
        link: 'https://apces.com.co',
        featured: false,
    },
    {
        id: 'teo',
        title: 'Tribunal Odontológico de Santander',
        subtitle: 'Corporative website',
        description: 'Vue Table is a Vue component that allows you to create tables with pagination, sorting, and filtering. It is a simple and easy-to-use component that can be used in any Vue project.',
        image: '/images/portfolio/teo.jpg',
        link: 'https://teosantander.com/',
        featured: false,
    },
    {
        id: 'tlsi',
        title: 'Transportes logísticos y servicios de ingeniería',
        subtitle: 'Corporative website',
        description: 'Vue Table is a Vue component that allows you to create tables with pagination, sorting, and filtering. It is a simple and easy-to-use component that can be used in any Vue project.',
        image: '/images/portfolio/tlsi.jpg',
        link: 'https://tlsi.com.co/',
        featured: false,
    },
])
</script>

<style scoped>
    .featured-col {
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
    .img-zoom:hover {
        transform: scale(1.1);
    }

    .pointer-events-none {
        pointer-events: none;
    }

    .overlay-gradient {
        background: #2C3E50;
        background: linear-gradient(90deg, #2C3E50 0%, transparent 60%);
        background: -moz-linear-gradient(90deg, #2C3E50 0%, transparent 60%);
        background: -webkit-linear-gradient(90deg, #2C3E50 0%, transparent 60%);
    }
</style>