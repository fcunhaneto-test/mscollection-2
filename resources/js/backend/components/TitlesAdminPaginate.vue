<template>
    <nav v-if="page" class="pagination is-small mb-0" role="navigation" aria-label="pagination">
        <ul class="pagination-list">
            <li class="pagination-link">
                <a class="page-link" href="#" @click="previous(page-1)"><i class="fas fa-angle-double-left"></i></a>
            </li>
            <li v-if="page" class="pagination-link" :class= "{'is-current': (page_num === page)}"
                v-for="(page_num, key) in pages" :key="key">
                <a
                    :class="{'has-text-white':  (page_num === page)}"
                    href="#"
                    @click="getPage(page_num)"
                >
                    {{ page_num }}
                </a>
            </li>
            <li class="pagination-link">
                <a class="page-link" href="#" @click="next(page+1)"><i class="fas fa-angle-double-right"></i></a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: "TitlesPaginate",
    props: {
        pages: Number,
    },
    computed: {
        table() {
            return this.$store.getters.getTable
        },
        channel() {
            return this.$store.getters.getChannel
        },
        pp() {
            return this.$store.getters.getPp
        },
        page() {
            return this.$store.getters.getPage
        },
    },
    methods: {
        getPage(num) {
            this.$store.commit('SET_PAGE', num)
            axios.get(`/api/admin/${this.table}/titles-page/${this.channel}/${num}/${this.pp}`).then(response => {
                console.log('SET TITLES', response.data)
                this.$store.commit('SET_TITLES', response.data)
            }).catch(error => console.log(error))
        },
        previous(num) {
            if(num !== 0) {
                this.getPage(num)
            }
        },
        next(num) {
            if(num !== (this.pages+1)) {
                this.getPage(num)
            }
        }
    },
}
</script>

<style scoped>

</style>
