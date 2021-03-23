<template>
    <div class="container is-max-widescreen mt-5">
        <div v-if="is_table">
            <h1 class="title is-3">{{ header }} {{ subheader }}</h1>
            <titles-paginate :pages="pages"></titles-paginate>
            <titles-table @showTitle="showPage($event)"></titles-table>
        </div>
        <title-show v-if="!is_table" :title="title" @viewTable="is_table = !is_table"></title-show>
    </div>
</template>

<script>
import TitlesTable from "./components/TitlesTable";
import TitlesPaginate from "./components/TitlesPaginate";
import TitleShow from "./components/TitleShow";

export default {
    name: "Titles",
    components: {TitleShow, TitlesPaginate, TitlesTable},
    comments: {
        TitlesTable,
        TitlesPaginate,
        TitleShow
    },
    data() {
        return {
            pages: null,
            is_table: true,
            title: null
        }
    },
    computed: {
        table() {
            return this.$store.getters.getTable
        },
        header() {
            return this.$store.getters.getHeader
        },
        subheader() {
            return this.$store.getters.getSubHeader
        },
        channel() {
            return this.$store.getters.getChannel
        },
        pp() {
            return this.$store.getters.getPp
        }
    },
    methods: {
        startTitles() {
            axios.get(`/api/${this.table}/titles-start/${this.channel}/${this.pp}`).then(response => {
                this.pages = response.data[0]
                this.$store.commit('SET_TITLES', response.data[1])
            })
        },
        showPage(event) {
            this.is_table = false
            this.title = event
        },
    },
    beforeMount() {
        this.startTitles()
    },
    updated() {
        this.startTitles()
    },
}
</script>

<style scoped>

</style>
