<template>
    <div class="container is-max-widescreen mt-5">
        <div v-if="is_table">
            <div class="columns">
                <div class="column is-narrow pb-0">
                    <h1 class="title is-3">{{ header }} {{ subheader }}</h1>
                </div>
                <div class="column is-3 pb-0">
                    <div class="field is-horizontal">
                        <div class="field-body">
                            <label for="per_page" class="label mr-2 mt-2">Títulos por página</label>
                            <div class="select" >
                                <select id="per_page" v-model="selected" @change="newPP">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column is-3 has-text-right pb-0">
                    <button class="button is-link ml-6" @click="newTitle">NOVO {{ header|strSingular }}</button>
                </div>
            </div>
            <div class="column is-full">
                <titles-paginate :pages="pages"></titles-paginate>
                <titles-table @showTitle="showPage($event)"></titles-table>
            </div>
        </div>
    </div>
</template>

<script>
import TitlesTable from "./components/TitlesAdminTable";
import TitlesPaginate from "./components/TitlesAdminPaginate";
// import TitleShow from "./components/TitleShow";

export default {
    name: "TitlesAdmin",
    components: {TitlesPaginate, TitlesTable},
    props: {
        table: String,
        header: String
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
            axios.get(`/api/admin/${this.table}/titles-start/${this.channel}/${this.pp}`).then(response => {
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
        },
        newTitle() {
            if(this.table === 'movies') {
                this.$router.push('/admin/novo/filme')
            }
        }
    },
    beforeMount() {
        this.selected = this.pp
        this.$store.commit('SET_TABLE', this.table)
        this.startTitles()
    },
    updated() {
        this.startTitles()
    },
    created() {
        axios.get('/api/media').then(response => {
            this.$store.commit('SET_MEDIA', response.data)
        }).catch(error => console.error(error))
        axios.get('/api/categories').then(response => {
            this.$store.commit('SET_CATEGORIES', response.data)
        }).catch(error => console.error(error))
        axios.get('/api/keywords').then(response => {
            this.$store.commit('SET_KEYWORDS', response.data)
        }).catch(error => console.error(error))
    }
}
</script>

<style scoped>
select, option {
    font-size: 0.9rem;
}
</style>
