<template>
    <div class="blog-divider"></div>
    <div class="mb-3">
        <ins
            ref="ad"
            class="adsbygoogle ad-slot"
            data-ad-format="fluid"
            data-ad-layout-key="-fo-2p+5v-nz+n3"
            data-ad-client="ca-pub-2847498886705900"
            data-ad-slot="9348019903">
        </ins>
    </div>
</template>

<script>
import { initAdsbygoogle } from '@/lib/initAdsbygoogle'

export default {
    mounted() {
        initAdsbygoogle(this.$refs.ad)
    },
}
</script>
