<template>
    <nav ref="navRef" id="siteNav" :aria-label="primaryLabel" class="fixed inset-x-0 top-0 z-200 border-b border-rule-dark bg-vacuum text-light">
        <div class="site-container flex min-h-18 items-stretch justify-between px-0">
            <a class="flex min-w-0 items-center gap-2 px-3 text-light sm:gap-3 sm:px-0" :href="homeUrl">
                <img class="h-12 w-8 shrink-0 object-contain" :src="logoUrl" alt="" width="500" height="800">
                <span class="truncate font-display text-lg font-bold uppercase tracking-[0.04em] sm:text-2xl">{{ author }}</span>
            </a>

            <div class="hidden items-stretch lg:flex">
                <ul class="flex items-stretch [&>li]:mb-0">
                    <li v-for="item in items" :key="item.url">
                        <a
                            class="flex h-full items-center border-l border-rule-dark px-5 font-display text-lg uppercase tracking-[0.03em] text-light-muted transition-colors hover:bg-vacuum-raised hover:text-light focus-visible:bg-vacuum-raised"
                            :href="item.url"
                            :target="item.external ? '_blank' : undefined"
                            :rel="item.external ? 'noopener noreferrer' : undefined"
                        >{{ item.label }}</a>
                    </li>
                </ul>
                <ul class="flex items-center gap-3 border-l border-rule-dark px-5 font-data text-xs [&>li]:mb-0" :aria-label="localeLabel">
                    <li v-for="locale in locales" :key="locale.url">
                        <a
                            class="border-b-2 py-1 transition-colors hover:text-light"
                            :class="locale.active ? 'border-track-yellow text-track-yellow' : 'border-transparent text-light-muted'"
                            :href="locale.url"
                            :aria-current="locale.active ? 'page' : undefined"
                        >{{ locale.label }}</a>
                    </li>
                </ul>
            </div>

            <button
                ref="toggleRef"
                type="button"
                class="group flex min-w-26 items-center justify-between gap-3 border-l border-rule-dark px-3 font-data text-xs uppercase leading-none tracking-[0.16em] text-light transition-colors hover:bg-steel sm:min-w-36 sm:px-4 lg:hidden"
                :aria-expanded="isOpen.toString()"
                :aria-label="isOpen ? closeLabel : menuLabel"
                aria-controls="siteNavigationPanel"
                @click="toggleMenu"
            >
                <span>{{ isOpen ? closeLabel : menuLabel }}</span>
                <i v-show="!isOpen" data-lucide="menu" class="h-5 w-5 text-signal-cyan" aria-hidden="true"></i>
                <i v-show="isOpen" data-lucide="x" class="h-5 w-5 text-track-yellow" aria-hidden="true"></i>
            </button>
        </div>

        <div
            v-show="isOpen"
            id="siteNavigationPanel"
            v-cloak
            class="absolute inset-x-0 top-full border-b border-rule-dark bg-vacuum-raised"
        >
            <div class="site-container grid gap-8 py-7 md:grid-cols-[minmax(0,1fr)_auto] md:items-end">
                <ul class="grid border-l border-t border-rule-dark sm:grid-cols-2 [&>li]:mb-0">
                    <li v-for="(item, index) in items" :key="item.url" class="border-b border-r border-rule-dark">
                        <a
                            class="flex min-h-16 items-center gap-4 px-4 text-lg text-light transition-colors hover:bg-steel focus-visible:bg-steel"
                            :href="item.url"
                            :target="item.external ? '_blank' : undefined"
                            :rel="item.external ? 'noopener noreferrer' : undefined"
                            @click="closeMenu"
                        >
                            <span class="font-data text-xs text-signal-cyan">{{ String(index + 1).padStart(2, '0') }}</span>
                            <span>{{ item.label }}</span>
                        </a>
                    </li>
                </ul>

                <ul class="flex gap-2 [&>li]:mb-0" :aria-label="localeLabel">
                    <li v-for="locale in locales" :key="locale.url">
                        <a class="catalog-action catalog-action--quiet-dark" :class="locale.active ? 'border-track-yellow text-track-yellow' : ''" :href="locale.url" :aria-current="locale.active ? 'page' : undefined">{{ locale.label }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { nextTick, onBeforeUnmount, onMounted, ref } from 'vue'

defineProps({
    author: { type: String, required: true },
    logoUrl: { type: String, required: true },
    homeUrl: { type: String, required: true },
    menuLabel: { type: String, required: true },
    closeLabel: { type: String, required: true },
    primaryLabel: { type: String, required: true },
    localeLabel: { type: String, required: true },
    items: { type: Array, required: true },
    locales: { type: Array, required: true },
})

const isOpen = ref(false)
const navRef = ref(null)
const toggleRef = ref(null)

const closeMenu = (returnFocus = false) => {
    isOpen.value = false

    if (returnFocus) {
        nextTick(() => toggleRef.value?.focus())
    }
}

const toggleMenu = () => {
    isOpen.value = !isOpen.value
}

const handleOutsideClick = (event) => {
    if (isOpen.value && navRef.value && !navRef.value.contains(event.target)) {
        closeMenu()
    }
}

const handleEscape = (event) => {
    if (event.key === 'Escape' && isOpen.value) {
        closeMenu(true)
    }
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
