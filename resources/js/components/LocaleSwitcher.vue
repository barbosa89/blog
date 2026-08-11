<template>
    <div ref="dropdownRef" class="relative">
        <button
            type="button"
            class="catalog-button min-h-10 border-rule-light bg-paper px-3 text-sm text-ink"
            :aria-expanded="isOpen.toString()"
            aria-haspopup="menu"
            aria-controls="localeMenu"
            @click="toggle"
        >
            <span>{{ label }}</span>
            <i data-lucide="chevron-down" class="h-4 w-4 transition-transform" :class="{ 'rotate-180': isOpen }" aria-hidden="true"></i>
        </button>

        <ul id="localeMenu" v-show="isOpen" v-cloak class="absolute right-0 z-[100] mt-2 w-44 border border-rule-light bg-paper p-1 text-sm [&>li]:mb-0">
            <li v-for="item in items" :key="item.url">
                <a class="block px-3 py-2 text-ink transition-colors hover:bg-paper-raised focus-visible:bg-paper-raised" :href="item.url" @click="close">{{ item.label }}</a>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue'

defineProps({
    label: { type: String, required: true },
    items: { type: Array, required: true },
})

const dropdownRef = ref(null)
const isOpen = ref(false)
const close = () => { isOpen.value = false }
const toggle = () => { isOpen.value = !isOpen.value }
const handleOutsideClick = event => {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target)) close()
}
const handleEscape = event => {
    if (event.key === 'Escape') close()
}

onMounted(() => {
    document.addEventListener('click', handleOutsideClick)
    document.addEventListener('keydown', handleEscape)
})
onBeforeUnmount(() => {
    document.removeEventListener('click', handleOutsideClick)
    document.removeEventListener('keydown', handleEscape)
})
</script>
