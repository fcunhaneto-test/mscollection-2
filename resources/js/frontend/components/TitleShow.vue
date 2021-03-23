<template>
    <div class="columns is-centered">
        <div class="column is-10">
            <div class="card">
                <div class="media has-background-black">
                    <div class="media-left p-2">
                        <img v-if="title.poster" :src="'../images/poster/' + title.poster" width="150" height="203"
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
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
.badge {
    font-size: .9rem;
    font-weight: normal;
}

.summary {
    font-size: 1rem;
}
</style>
