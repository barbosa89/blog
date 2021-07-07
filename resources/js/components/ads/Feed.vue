<template>
    <div :id="reference" class="row mb-2">
        <ins class="adsbygoogle"
            style="display:block"
            data-ad-format="fluid"
            data-ad-layout-key="-fo-2p+5v-nz+n3"
            data-ad-client="ca-pub-2847498886705900"
            data-ad-slot="9348019903"></ins>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.reference = `feed-ad-${this._uid}`

            document.addEventListener('DOMContentLoaded', () => {
                this.createScriptLink()
                this.createScriptTag()
            })
        },
        data() {
            return {
                reference: 'id-'
            }
        },
        methods: {
            createScriptLink() {
                let link = document.createElement('script')

                link.src = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js'

                let container = document.getElementById(this.reference)

                container.prepend(link)
            },
            createScriptTag() {
                let link = document.createElement('script')

                link.text = '(adsbygoogle = window.adsbygoogle || []).push({})'

                let container = document.getElementById(this.reference)

                container.appendChild(link)
            }
        }
    }
</script>
