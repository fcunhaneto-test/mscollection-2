<template>
    <div class="container is-max-widescreen mt-5">
        <div class="columns is-centered">
            <div class="column is-four-fifths">
                <h1 class="title is-3">Editar Filme</h1>
                <hr>
                <div class="columns is-multiline">
                    <div class="column is-6">
                        <div class="field">
                            <label for="title" class="label">Título</label>
                            <input id="title" name="title" v-model="formData.title" class="input" type="text">
                        </div>
                    </div>
                    <div class="column is-6">
                        <div class="field">
                            <label for="original_title" class="label">Título Original</label>
                            <input id="original_title" name="original_title" v-model="formData.original_title"
                                   class="input" type="text">
                        </div>
                    </div>
                    <div class="column is-3">
                        <div class="field">
                            <label for="year" class="label">Ano</label>
                            <input id="year" name="title" v-model="formData.year" class="input" type="text">
                        </div>
                    </div>
                    <div class="column is-3">
                        <div class="field">
                            <label for="time" class="label">Tempo</label>
                            <input id="time" name="time" v-model="formData.time" class="input" type="time">
                        </div>
                    </div>
                    <div class="column is-3">
                        <div class="field">
                            <label class="label">Our Rating</label>
                            <a v-for="ys in yellow" href="#" :key="'yellow_' + ys" @click="delStar(ys)">
                                <span class="icon has-text-orange"><i class="fas fa-star"></i></span>
                            </a>
                            <a v-for="ws in white" href="#" :key="'white_'+ ws" @click="addStar(ws)">
                                <span class="icon has-text-orange"><i class="far fa-star"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="column is-3">
                        <div class="field">
                            <label class="label">IMDB Rating</label>
                            <a v-for="ys in y_imdb" href="#" :key="'y-imdb-' + ys" @click="delIStar(ys)">
                                <span class="icon has-text-orange"><i class="fas fa-star"></i></span>
                            </a>
                            <a v-for="ws in w_imdb" href="#" :key="'w-imdb-'+ ws" @click="addIStar(ws)">
                                <span class="icon has-text-orange"><i class="far fa-star"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="column is-6">
                        <b-field label="Categoria 1" class="form-edit">
                            <b-input list="categories_1" name="category" v-model="formData.category_1"
                                     style="width: 100%;"/>
                            <datalist id="categories_1">
                                <option v-for="category in categories" :value="category.name" style="color: red"/>
                            </datalist>
                        </b-field>
                    </div>
                    <div class="column is-6">
                        <b-field label="Categoria 2" class="form-edit">
                            <b-input list="categories_2" name="category" v-model="formData.category_2"
                                     style="width: 100%;"/>
                            <datalist id="categories_2">
                                <option v-for="category in categories" :value="category.name" style="color: red"/>
                            </datalist>
                        </b-field>
                    </div>
                    <div class="column is-12 mb-0 pb-0">
                        <label class="label">Mídia</label>
                        <div class="columns is-multiline">
                            <div v-for="m in media" class="column is-3">
                                <input :id="m.slug" type="checkbox" :value="m.id" v-model="formData.media">
                                <label :for="m.slug">{{ m.name }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="column is-12">
                        <div class="field">
                            <label for="poster" class="label">Poster</label>
                            <input id="poster" name="poster" v-model="formData.poster"
                                   class="input" type="text" readonly>
                        </div>
                    </div>
                    <div class="column is-12">
                        <div class="field">
                            <label for="summary" class="label">Resumo</label>
                            <div class="control">
                                <textarea id="summary" class="textarea" v-model="formData.summary"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="column is-4 mt-3"></div>
                    <div class="column is-4 mt-3">
                        <button class="button is-primary is-fullwidth" @click="editMovie">ENVIAR</button>
                    </div>
                    <div class="column is-4 mt-3"></div>
                    <hr>
                    <div class="column is-12">
                        <h2 class="title is-4">Elenco</h2>
                        <table v-if="cast" class="table is-fullwidth">
                            <thead>
                            <tr>
                                <th scope="col">Ator</th>
                                <th scope="col">Personagem</th>
                                <th scope="col">Estrela</th>
                                <th scope="col">Ordem</th>
                                <th scope="col">
                                    <b-tooltip label="Novos Ator/Personagem">
                                        <b-button class="button is-info is-small" @click="addCast">
                                            <i class="fas fa-plus"></i></b-button>
                                    </b-tooltip>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ac, i) in cast" :key="i">
                                <td>
                                    <b-input list="actors" name="actor" v-model="cast[i].actor"
                                             style="width: 100%;"/>
                                    <datalist id="actors">
                                        <option v-for="actor in actors" :value="actor.name" style="color: red"/>
                                    </datalist>
                                </td>
                                <td><input type="text" class="input" v-model="cast[i].character"></td>
                                <td><input type="checkbox" v-model="cast[i].star"></td>
                                <td><input type="number" name="order" class="input is-small"
                                           v-model="cast[i].order"></input>
                                </td>
                                <td>
                                    <button class="button is-link is-small" :disabled="cast[i].saved"
                                            @click="saveCast(cast[i])">
                                        salvar
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="column is-12">
                        <h2 class="title is-4">Diretores</h2>
                        <div class="column is-12">
                            <table class="table is-fullwidth">
                                <thead>
                                <tr>
                                    <th scope="col">Diretor</th>
                                    <th scope="col">Ordem</th>
                                    <th scope="col">
                                        <b-tooltip label="Novo Diretor">
                                            <b-button class="button is-info is-small" @click="addProducer">
                                                <i class="fas fa-plus"></i></b-button>
                                        </b-tooltip>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="directors" v-for="(d, i) in directors" :key="i">
                                    <td><input type="text" name="director" class="input"
                                               v-model="directors[i].director"></td>
                                    <td><input type="number" name="order" class="input"
                                               v-model="directors[i].order"></input>
                                    </td>
                                    <td>
                                        <button class="button is-link is-small" :disabled="directors[i].saved"
                                                @click="saveDirector(directors[i])">
                                            salvar
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
    name: "NewMovie",
    data() {
        return {
            movieSaved: false,
            yellow: 0,
            white: 5,
            y_imdb: 0,
            w_imdb: 5,
            formData: {},
            imdb: '',
            cast: null,
            directors: [],
            actors: null,
            characters: null,
        }
    },
    computed: {
        categories() {
            return this.$store.getters.getCategories
        },
        media() {
            return this.$store.getters.getMedia
        },
        title() {
            return this.$store.getters.getTitle
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
            this.formData.our_rating = this.yellow
        },
        addStar(ws) {
            this.yellow += ws
            this.white = 5 - this.yellow
            this.formData.our_rating = this.yellow
        },
        delIStar(ys) {
            if (ys === 1) {
                this.y_imdb = 0
                this.w_imdb = 5
            } else {
                this.y_imdb = ys
                this.w_imdb = 5 - ys
            }
            this.formData.rating = this.y_imdb
        },
        addIStar(ws) {
            this.y_imdb += ws
            this.w_imdb = 5 - this.y_imdb
            this.formData.our_rating = this.y_imdb
        },

        editMovie() {
            axios.put('/api/movies/update', this.formData).then(response => {
                if (response.status === 200) {
                    this.movie_id = parseInt(response.data);
                    this.movieSaved = true
                } else if ((response.status === 202)) {
                    this.movieExist = true
                }
            }).catch(error => {
                this.isLoading = false
                console.error(error)
            })
        },

        saveCast(c) {
            if (this.movie_id) {
                axios.post('/api/cast/movie/store', {
                    actor: c.actor,
                    character: c.character,
                    order: c.order,
                    star: c.star,
                    movie_id: this.movie_id
                }).then(response => {
                    if (response.status === 200) {
                        c.saved = true
                    }
                }).catch(error => {
                    console.error(error)
                })
            }
        },
        saveDirector(d) {
            if (this.movie_id) {
                axios.post('/api/directors/store', {
                    director: d.director,
                    order: d.order,
                    movie_id: this.movie_id
                }).then(response => {
                    if (response.status === 200) {
                        d.saved = true
                    }
                }).catch(error => {
                    console.error(error)
                })
            }
        },
        /**
         * Adicionar as tabelas novo diretor ou novo elenco em branco
         */
        addProducer() {
            this.creators.push({
                creator: '',
                order: this.creator_index,
                saved: false
            })
        },
        addCast() {
            this.cast.push({
                actor: '',
                character: '',
                order: 1,
                star: false,
                saved: false
            })
        },
    },
    beforeMount() {
        this.formData = {
            id: this.title.id,
            title: this.title.title,
            original_title: this.title.original_title,
            year: this.title.year,
            time: this.title.time,
            our_rating: this.title.our_rating,
            imdb_rating: this.title.imdb_rating,
            category_1: this.title.category_1,
            category_2: this.title.category_2,
            poster: this.title.poster,
            summary: this.title.summary,
            media: [],
        }

        this.yellow = this.formData.our_rating
        this.white = 5 - this.formData.our_rating
        this.y_imdb = this.formData.imdb_rating
        this.w_imdb = 5 - this.formData.imdb_rating

        axios.get(`/api/movies/media/${this.title.id}`).then(response => {
            for (let i = 0; i < response.data.length; i++) {
                this.formData.media.push(response.data[i].id)
            }
            console.log('MEDIA', this.formData.media)
        }).catch(error => console.error(error))

        axios.get(`/api/movies/cast/${this.title.id}`).then(response => {
            this.cast = response.data
            console.log('CAST', this.cast)
        }).catch(error => console.error(error))

        axios.get(`/api/actor`).then(response => {
            this.actors = response.data
        }).catch(error => console.error(error))

        axios.get(`/api/character`).then(response => {
            this.characters = response.data
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

