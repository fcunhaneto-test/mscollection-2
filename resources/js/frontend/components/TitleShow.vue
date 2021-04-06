<template>
    <div class="columns is-centered">
        <div class="column is-10">
            <div class="card is-bordered">
                <div class="media has-background-black">
                    <div class="media-left p-2">
                        <img v-if="title.poster" :src="'../storage/images/posters/' + title.poster" width="150" height="203"
                             alt="poster do filme">
                        <img v-else :src="'../images/poster/faker-poster.png'" width="150" height="203"
                             alt="poster do filme">
                    </div>
                    <div class="media-content">
                        <h2 class="title is-3 has-text-white pt-5">{{ title.title }}</h2>
                        <p>
                            <span class="tag is-light">Ano: {{ title.year }}</span>
                            <span class="tag is-light">Duração: {{ title.time | strTime }}</span>
                            <span class="tag is-light">
                                <i v-for="i in title.rating" class="fas fa-star has-text-orange"></i>
                                <i v-for="i in (5-title.rating)" class="far fa-star"></i>
                            </span>
                        </p>
                        <p class="mt-3">
                            <span v-if="title.category_2" class="tag is-link">Categorias: {{ title.category_1 }},
                                    {{ title.category_2 }}</span>
                            <span v-else class="tag is-link">Categorias: {{ title.category_1 }}</span>
                        </p>
                    </div>
                    <div class="media-right">
                        <div class="column">
                            <button class="button is-light is-small has-tooltip-bottom mr-2 ml-2" data-tooltip="Voltar"
                                    @click="viewTable">
                                <i class="fas fa-undo-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-content mb-6 py-0">
                    <div class="mt-5 ml-3">
                        <h5 class="title is-6 mb-2 pb-0">Resumo:</h5>
                        <p>{{ title.summary }}</p>
                    </div>
                    <table v-if="cast.length > 0" class="table table is-fullwidth mt-5 mb-0">
                        <thead class="has-background-white">
                        <tr>
                            <th class="title is-6">Ator/Personagem</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="ac in cast">
                            <td class="pl-5">{{ ac.actor }}</td>
                            <td>{{ ac.character }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <table v-if="producers.length > 0" class="table table is-fullwidth mt-5">
                        <thead class="has-background-white">
                        <tr>
                            <th class="title is-6">
                                <span v-if="table === 'movies'">Diretor(es)</span>
                                <span v-else>Criador(es)</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="producer in producers">
                            <td class="pl-5">{{ producer.name }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// TODO Melhorar o retorno para volte na mesma página
export default {
    name: "TitleShow",
    props: {
        title: Object
    },
    data() {
        return {
            cast: [],
            cast_total: 0,
            producers: [],
            prod_total: 0,
        }
    },
    computed: {
        table() {
            return this.$store.getters.getTable
        }
    },
    methods: {
        viewTable() {
            this.$emit('viewTable')
        }
    },
    beforeMount() {
        axios.get(`/api/${this.table}/cast/${this.title.id}`).then(response => {
            this.cast = response.data
            this.cast_total = this.cast.length
            console.log('Total Cast', this.cast_total)
            console.log('Cast', this.cast)
        }).catch(errors => console.log(errors))
        axios.get(`/api/${this.table}/producers/${this.title.id}`).then(response => {
            this.producers = response.data
            this.prod_total = this.producers.length
            console.log('Total Producers', this.prod_total)
            console.log('Producers', this.producers)
        }).catch(errors => console.log(errors))
    }
}
</script>

<style scoped>
.card-header {
    width: 100%;
}
</style>
