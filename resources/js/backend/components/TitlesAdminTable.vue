<template>
    <table v-if="titles" class="table is-fullwidth">
        <thead>
        <tr>
            <th scope="col">Títulos</th>
            <th scope="col">Ano</th>
            <th v-if="table === 'movies'" scope="col">Tempo</th>
            <th scope="col">IMDB<sup class="has-text-warning">[1]</sup></th>
            <th scope="col">Nossa<sup class="has-text-warning">[2]</sup></th>
            <th scope="col">Categoria 1</th>
            <th scope="col">Categoria 2</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="title in titles" :key="title.id">
            <td><a class="table-link" href="#" @click="toEdit(title)">{{ title.title }}</a></td>
            <td>{{ title.year }}</td>
            <td v-if="table ==='movies'">{{ title.time | strTime }}</td>
            <td>
                <i v-for="r in title.imdb_rating" class="fas fa-star has-text-orange"></i>
                <i v-for="r in (5 - title.imdb_rating)" class="far fa-star has-text-orange"></i>
            </td>
            <td>
                <i v-for="r in title.our_rating" class="fas fa-star has-text-orange"></i>
                <i v-for="r in (5 - title.our_rating)" class="far fa-star has-text-orange"></i>
            </td>
            <td>{{ title.category_1 }}</td>
            <td>{{ title.category_2 }}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "TitlesTable",
    computed: {
        table() {
            return this.$store.getters.getTable
        },
        titles() {
            return this.$store.getters.getTitles
        }
    },
    methods: {
        toEdit(title) {
            console.log('SET TITLE', title)
            this.$store.commit('SET_TITLE', title)
            this.$router.push({ name: 'edit-movie' })
        },
    }
}
</script>

<style scoped>

</style>
