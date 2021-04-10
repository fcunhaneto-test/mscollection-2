<template>
    <div class="container is-max-widescreen mt-5">
        <div class="columns is-centered">
            <div class="column is-four-fifths">
                <b-loading :is-full-page="true" v-model="isLoading" :can-cancel="true"></b-loading>
                <h2 class="title is-4">Scrapping From</h2>
                <div class="field-body">
                    <div class="field">
                        <label for="imdb" class="label">IMDB</label>
                        <input id="imdb" name="imdb" v-model="imdb" class="input" type="text"
                               @keyup.enter="imdbScraping">
                    </div>
                </div>
                <hr>
                <h2 class="title is-4">Filme Formulário</h2>
                <div class="columns is-multiline">
                    <div class="column is-half">
                        <div class="field">
                            <label for="title" class="label">Título</label>
                            <input id="title" name="title" v-model="formData.title" class="input" type="text">
                        </div>
                    </div>
                    <div class="column is-half">
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
                    <div class="column is-6">
                        <div class="field">
                            <label class="label">Rating</label>
                            <a v-for="ys in yellow" href="#" :key="'yellow_' + ys" @click="delStar(ys)">
                                <span class="icon has-text-orange"><i class="fas fa-star"></i></span>
                            </a>
                            <a v-for="ws in white" href="#" :key="'white_'+ ws" @click="addStar(ws)">
                                <span class="icon has-text-orange"><i class="far fa-star"></i></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="column is-half">
                    <b-field label="Categoria 1" class="form-edit">
                        <b-input list="categories_1" name="category" v-model="formData.category_1"
                                 style="width: 100%;"/>
                        <datalist id="categories_1">
                            <option v-for="category in categories" :value="category.name" style="color: red"/>
                        </datalist>
                    </b-field>
                </div>
                <div class="column is-half">
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
                    <br>
                </div>
                <div class="column is-8 mt-0 pt-0">
                    <div class="field-body">
                        <div class="field">
                            <label for="poster" class="label">Poster URL</label>
                            <input id="poster" name="imdb" v-model="formData.img_url" class="input" type="text">
                        </div>
                    </div>
                </div>
                <div class="column is-full">
                    <div class="field">
                        <label for="summary" class="label">Resumo</label>
                        <div class="control">
                            <textarea id="summary" class="textarea" v-model="formData.summary"></textarea>
                        </div>
                    </div>
                </div>
                <div class="columns is-centered">
                    <div class="column is-one-third mt-3">
                        <button class="button is-primary is-fullwidth" @click="saveMovie">ENVIAR</button>
                    </div>
                    <div class="column is-narrow"></div>
                </div>
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
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(ac, i) in cast" :key="i">
                            <td><td><input type="text" class="input" v-model="ac.actor"></td>
                            <td><input type="text" class="input" v-model="ac.character"></td>
                            <td><input type="checkbox" v-model="ac.star"></td>
                            <td><input type="number" name="order" class="input is-small" v-model="ac.order"></input>
                            </td>
                            <td>
                                <button class="button is-link is-small" :disabled="ac.saved" @click="saveCast(cast[i])">
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
                        <table v-if="directors" class="table is-fullwidth">
                            <thead>
                            <tr>
                                <th scope="col">Diretor</th>
                                <th scope="col">Ordem</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(d, i) in directors" :key="i">
                                <td>{{ d.director }}</td>
                                <td><input type="number" name="order" class="input is-small" v-model="d.order"></input>
                                </td>
                                <td>
                                    <button class="button is-link is-small" :disabled="d.saved" @click="saveDiretor(directors[i])">
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
        <b-modal v-model="movieExist" :width="400" :height="400">
            <div class="card">
                <div class="card-content">
                    <div class="content has-text-centered">
                        <p>Filme já existe</p>
                        <button class="button is-primary" autofocus @click="movieExist = false">FECHAR</button>
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
            isLoading: false,
            movieSaved: false,
            movieExist: false,
            yellow: 0,
            white: 5,
            w_imdb: 5,
            formData: {
                title: '',
                original_title: '',
                year: 1900,
                time: '00:00',
                our_rating: 0,
                imdb_rating: false,
                category_1: null,
                category_2: null,
                poster: '',
                summary: '',
                media: [],
                img_url: '',
                img_width: 0,
                img_height: 0,
            },
            imdb: '',
            movie_id: 0,
            cast: [],
            directors: [],
        }
    },
    computed: {
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
            this.formData.rating = this.yellow
        },
        addStar(ws) {
            console.log('ADD', ws)
            this.yellow += ws
            this.white = 5 - this.yellow
            this.formData.our_rating = this.yellow
        },

        /**
         * Scraping datas from IMDB
         */
        imdbScraping() {
            this.isLoading = true
            const options1 = {
                method: 'GET',
                url: 'https://imdb8.p.rapidapi.com/title/get-full-credits',
                params: {tconst: this.imdb},
                headers: {
                    'x-rapidapi-key': 'ea7aaa3ddcmshf151fb23c9b1c2ap189984jsn6f8224e2ef4e',
                    'x-rapidapi-host': 'imdb8.p.rapidapi.com'
                }
            };

            axios.request(options1).then(response => {
                console.log('IMDB', response.data)
                this.formData.original_title = response.data.base.title
                this.formData.year = response.data.base.year
                this.formData.time = this.strTime(response.data.base.runningTimeInMinutes)
                this.formData.img_url = response.data.base.image.url
                this.formData.img_width = response.data.base.image.width
                this.formData.img_height = response.data.base.image.height

                for (let i = 0; i < 10; i++) {
                    if (!response.data.cast[i].name) {
                        break
                    }
                    let order = i + 1
                    let character = ''
                    if (response.data.cast[i].characters.length === 1) {
                        character = response.data.cast[i].characters[0]
                    } else if (response.data.cast[i].characters.length > 1) {
                        character = response.data.cast[i].characters[0] + ' / ' + response.data.cast[i].characters[1]
                    }
                    this.cast.push({
                        actor: response.data.cast[i].name,
                        character: character,
                        star: false,
                        order: order,
                        saved: false
                    })
                }

                let d = response.data.crew.director
                for (let i = 0; i < d.length; i++) {
                    let order = i + 1
                    this.directors.push({ director: d[i].name, order: order, saved: false });
                }
                this.isLoading = false
            }).catch(error => console.error(error))

            const options2 = {
                method: 'GET',
                url: 'https://imdb8.p.rapidapi.com/title/get-genres',
                params: {tconst: this.imdb},
                headers: {
                    'x-rapidapi-key': 'ea7aaa3ddcmshf151fb23c9b1c2ap189984jsn6f8224e2ef4e',
                    'x-rapidapi-host': 'imdb8.p.rapidapi.com'
                }
            };

            axios.request(options2).then(response => {
                for (let i = 0; i < this.categories.length; i++) {
                    if (this.categories[i].e_name === response.data[0]) {
                        this.formData.category_1 = this.categories[i].name
                    }
                    if (this.categories[i].e_name === response.data[1]) {
                        this.formData.category_2 = this.categories[i].name
                    }
                }
            }).catch(error => console.error(error))

            const options3 = {
                method: 'GET',
                url: 'https://imdb8.p.rapidapi.com/title/get-ratings',
                params: {tconst: this.imdb},
                headers: {
                    'x-rapidapi-key': 'ea7aaa3ddcmshf151fb23c9b1c2ap189984jsn6f8224e2ef4e',
                    'x-rapidapi-host': 'imdb8.p.rapidapi.com'
                }
            };

            axios.request(options3).then(response => {
                this.formData.imdb_rating = Math.round((response.data.rating / 2))
            }).catch(function (error) {
                console.error(error);
            });
        },

        /**
         * Send data to store movie.
         */
        saveMovie() {
            axios.post('/api/movies/store', this.formData).then(response => {
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
            if(this.movie_id) {
                axios.post('/api/cast/movie/store', {
                    actor: c.actor,
                    character: c.character,
                    order: c.order,
                    star: c.star,
                    movie_id: this.movie_id
                }).then(response => {
                    if(response.status === 200) {
                        c.saved = true
                    }
                }).catch(error => {
                    console.error(error)
                })
            }
        },

        saveDiretor(d) {
            if(this.movie_id) {
                axios.post('/api/directors/store', {
                    director: d.director,
                    order: d.order,
                    movie_id: this.movie_id
                }).then(response => {
                    if(response.status === 200) {
                        d.saved = true
                    }
                }).catch(error => {
                    console.error(error)
                })
            }
        },

        /**
         * Covert time im minutes to hour:minutes
         * @param t
         * @returns {string}
         */
        strTime(t) {
            const minute = t % 60
            const hour = Math.floor((t / 60))
            if (minute < 10) {
                return '0' + hour + ':0' + minute
            }
            return '0' + hour + ':' + minute
        },
    },
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
