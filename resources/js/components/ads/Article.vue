<template>
    <div class="blog-divider"></div>
    <div class="my-3">
        <ins
            ref="ad"
            class="adsbygoogle ad-slot ad-slot--article"
            data-ad-layout="in-article"
            data-ad-format="fluid"
            data-ad-client="ca-pub-2847498886705900"
            data-ad-slot="8446001777">
        </ins>
    </div>
    <div class="blog-divider"></div>
</template>

<script>
import { initAdsbygoogle } from '@/lib/initAdsbygoogle'

export default {
    mounted() {
        initAdsbygoogle(this.$refs.ad)
    },
}
</script>
