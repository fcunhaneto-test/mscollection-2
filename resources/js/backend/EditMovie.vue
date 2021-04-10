<template>
    <div class="container is-max-widescreen mt-5">
        <div class="columns is-centered">
            <div class="column is-four-fifths">
                <h2 class="title is-4">Filme Formulário</h2>
                <div class="columns is-multiline">
                    <div class="column is-half">
                        <div class="field">
                            <label for="title" class="label">Título</label>
                            <input id="title" name="title" v-model="title.title" class="input" type="text">
                        </div>
                    </div>
                    <div class="column is-half">
                        <div class="field">
                            <label for="original_title" class="label">Título Original</label>
                            <input id="original_title" name="original_title" v-model="title.original_title"
                                   class="input" type="text">
                        </div>
                    </div>
                    <div class="column is-3">
                        <div class="field">
                            <label for="year" class="label">Ano</label>
                            <input id="year" name="title" v-model="title.year" class="input" type="text">
                        </div>
                    </div>
                    <div class="column is-3">
                        <div class="field">
                            <label for="time" class="label">Tempo</label>
                            <input id="time" name="time" v-model="title.time" class="input" type="time">
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Rating</label>
                            <a v-for="ys in yellow" href="#" :key="'yellow_' + ys" class="mx-0 px-0" @click="delStar(ys)">
                                <span class="icon has-text-orange mx-0 px-0"><i class="fas fa-star"></i></span>
                            </a>
                            <a v-for="ws in white" href="#" :key="'white_'+ ws" class="mx-0 px-0" @click="addStar(ws)">
                                <span class="icon has-text-orange mx-0 px-0"><i class="far fa-star"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="column is-half">
                    <b-field label="Categoria 1" class="form-edit">
                        <b-input list="categories_1" name="category" v-model="title.category_1"
                                 style="width: 100%;"/>
                        <datalist id="categories_1">
                            <option v-for="category in categories" :value="category.name" style="color: red"/>
                        </datalist>
                    </b-field>
                </div>
                <div class="column is-half">
                    <b-field label="Categoria 2" class="form-edit">
                        <b-input list="categories_2" name="category" v-model="title.category_2"
                                 style="width: 100%;"/>
                        <datalist id="categories_2">
                            <option v-for="category in categories" :value="category.name" style="color: red"/>
                        </datalist>
                    </b-field>
                </div>
                <div class="column is-12">
                    <label class="label">Mídia</label>
                    <br>
                </div>
                <div class="column is-8">
                    <div class="field-body">
                        <div class="field">
                            <label for="poster" class="label">Poster URL</label>
                            <input id="poster" name="imdb" v-model="title.poster" class="input" type="text">
                        </div>
                    </div>
                </div>
                <div class="column is-full">
                    <div class="field">
                        <label for="summary" class="label">Resumo</label>
                        <div class="control">
                            <textarea id="summary" class="textarea" v-model="title.summary"></textarea>
                        </div>
                    </div>
                </div>
                <div class="columns is-centered">
                    <div class="column is-one-third">
                        <button class="button is-primary is-fullwidth" @click="editMovie">ENVIAR</button>
                    </div>
                    <div class="column is-narrow"></div>
                </div>
                <div class="column is-12">
                    <hr>
                    <h2 class="title is-4">Elenco</h2>
                </div>
                <div class="column is-12">
                    <hr>
                    <h2 class="title is-4">Diretores</h2>
                </div>
            </div>
        </div>
        <b-modal v-model="movieSaved" :width="400" :height="400">
            <div class="card">
                <div class="card-content">
                    <div class="content has-text-centered">
                        <p>Filme salvo com sucesso</p>
                        <button class="button is-primary" autofocus @click="movieSaved = false">FECHAR</button>
                    </div>
                </div>
            </div>
        </b-modal>
    </div>
</template>

<script>

export default {
    name: "EditMovie",
    data() {
        return {
            yellow: 0,
            white: 5,
            movieSaved: false,
            movie_media: null,
            cast: null
        }
    },
    computed: {
        table() {
            return this.$store.getters.getTable
        },
        title() {
            return this.$store.getters.getTitle
        },
        categories() {
            return this.$store.getters.getCategories
        },
        media() {
            return this.$store.getters.getMedia
        }
    },
    methods: {
        delStar(ys) {
            if (ys === 1) {
                this.yellow = 0
                this.white = 5
            } else {
                this.yellow = ys
                this.white = 5 - ys
            }
            this.title.our_rating = this.yellow
        },
        addStar(ws) {
            console.log('ADD', ws)
            this.yellow += ws
            this.white = 5 - this.yellow
            this.title.our_rating = this.yellow
        },
        editMovie() {

        }
    },
    beforeMount() {
        this.yellow = this.title.our_rating
        this.white = 5 - this.title.our_rating
        axios.get(`/api/${this.table}/cast/${this.title.id}`).then(response => {
            console.log('Cast', response.data)
            this.cast = response.data
        }).catch(error => console.error(error))
    }
}
</script>

<style scoped>
hr {
    height: 2px;
    border-width: 0;
    color: #000000;
    background-color: #000000;
}
</style>
