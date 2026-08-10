<template>
    <div class="mx-auto flex max-w-3xl flex-col items-center text-center">
        <img
            src="/images/me.webp"
            loading="lazy"
            :alt="author"
            class="h-36 w-36 rounded-full border-4 border-emerald-300/70 object-cover shadow-2xl sm:h-48 sm:w-48 lg:h-56 lg:w-56"
        >
        <h1 class="mt-5 text-4xl font-black uppercase tracking-[0.08em] text-white sm:text-6xl lg:text-7xl" :data-text="author">{{ author }}</h1>
        <span ref="typing" class="mt-3 min-h-[42px] text-lg font-light text-emerald-200 sm:text-2xl lg:text-3xl"></span>
    </div>
</template>

<script setup>
import Typed from 'typed.js'
import { ref, computed, onMounted, onBeforeUnmount } from 'vue'
import { useI18n } from 'vue-i18n';

const props = defineProps({
    author: {
        type: String,
        required: true,
    },
})

const { t } = useI18n();

const typing = ref(null)
let typingInstance = null

const degree = computed(() => t('page.degree'));
const dev = computed(() => t('page.dev'));

onMounted(() => {
    setTimeout(() => {
        typingInstance = new Typed(typing.value, {
            strings: [degree.value, dev.value, 'Blogger'],
            typeSpeed: 100,
            backSpeed: 60,
            loop: true,
            showCursor: false,
        })
    }, 1000)
})

onBeforeUnmount(() => {
    if (typingInstance) {
        typingInstance.destroy()
        typingInstance = null
    }
})
</script>