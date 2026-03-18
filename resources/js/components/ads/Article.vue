<template>
    <div class="row blog-divider"></div>
    <div class="row my-3">
        <ins
            ref="ad"
            class="adsbygoogle"
            style="display:block; text-align:center;"
            data-ad-layout="in-article"
            data-ad-format="fluid"
            data-ad-client="ca-pub-2847498886705900"
            data-ad-slot="8446001777">
        </ins>
    </div>
    <div class="row blog-divider"></div>
</template>

<script>
import { initAdsbygoogle } from '@/lib/initAdsbygoogle'

export default {
    mounted() {
        initAdsbygoogle(this.$refs.ad)
    },
}
</script>
