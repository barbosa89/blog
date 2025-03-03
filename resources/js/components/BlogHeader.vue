<template>
    <img src="/images/me.webp" loading="lazy" :alt="author" class="rounded-circle border-2 border-light mb-2 profile-image img-fluid img-shadow">
    <h1 class="text-uppercase mb-0 mt-2" :data-text="author">{{ author }}</h1>
    <span ref="typing" class="font-weight-light mb-0"></span>
</template>

<script setup>
import Typed from 'typed.js'
import { ref, computed, onMounted } from 'vue'
import { wTrans } from 'laravel-vue-i18n'

const props = defineProps({
    author: {
        type: String,
        required: true,
    },
})

const typing = ref(null)
const degree = computed(() => wTrans('page.degree').value)
const dev = computed(() => wTrans('page.dev').value)

onMounted(() => {
    setTimeout(() => {
        new Typed(typing.value, {
            strings: [degree.value, dev.value, 'Blogger'],
            typeSpeed: 100,
            backSpeed: 60,
            loop: true,
            showCursor: false,
        })
    }, 1000)
})
</script>

<style scoped>
span {
    font-size: 1.5rem;
    min-height: 38px;
}

.profile-image {
    max-width: 232px;
    max-height: 232px;
}
</style>