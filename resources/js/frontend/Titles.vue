<template>
    <div class="container is-max-widescreen mt-5">
        <div v-if="is_table">
            <div class="columns">
                <div class="column is-half pb-0">
                    <h1 class="title is-3">{{ header }} {{ subheader }}</h1>
                </div>
                <div class="column is-half pb-0">
                    <div class="field is-horizontal">
                        <div class="field-body">
                            <label for="per_page" class="label mr-2 mt-2">Títulos por página</label>
                            <div class="select" >
                                <select id="per_page" v-model="selected" @change="newPP">
                                    <option value="10">10</option>
                                    <option value="15">20</option>
                                    <option value="20">30</option>
                                    <option value="20">40</option>
                                    <option value="30">50</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column is-full">
                <titles-paginate :pages="pages"></titles-paginate>
                <titles-table @showTitle="showPage($event)"></titles-table>
            </div>
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
            title: null,
            selected: null,
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
        newPP() {
            this.$store.commit('SET_PP', this.selected)
        }
    },
    beforeMount() {
        this.selected = this.pp
        this.startTitles()
    },
    updated() {
        this.startTitles()
    },
}
</script>

<style scoped>
select, option {
    font-size: 0.9rem;
}
</style>
