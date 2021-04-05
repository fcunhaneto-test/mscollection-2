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
                            <label class="label">Ranking</label>
                            <a v-for="ys in yellow" href="#" :key="'yellow_' + ys" @click="delStar(ys)">
                                <span class="icon has-text-orange"><i class="fas fa-star"></i></span>
                            </a>
                            <a v-for="ws in white" href="#" :key="'white_'+ ws" @click="addStar(ws)">
                                <span class="icon has-text-orange"><i class="far fa-star"></i></span>
                            </a>
                        </div>
                    </div>
                    <div class="column is-4">
                        <b-field label="Categoria 1" class="form-edit">
                            <b-input list="categories_1" name="category" v-model="formData.category_1"
                                     style="width: 100%;"/>
                            <datalist id="categories_1">
                                <option v-for="category in categories" :value="category.name" style="color: red"/>
                            </datalist>
                        </b-field>
                    </div>
                    <div class="column is-4">
                        <b-field label="Categoria 2" class="form-edit">
                            <b-input list="categories_2" name="category" v-model="formData.category_2"
                                     style="width: 100%;"/>
                            <datalist id="categories_2">
                                <option v-for="category in categories" :value="category.name" style="color: red"/>
                            </datalist>
                        </b-field>
                    </div>
                    <div class="column is-4">
                        <b-field label="Keyword" class="form-edit">
                            <b-input list="keywords" name="category_2" v-model="formData.keyword" style="width: 100%;"/>
                            <datalist id="keywords">
                                <option v-for="keyword in keywords" :value="keyword.name" style="color: red"/>
                            </datalist>
                        </b-field>
                    </div>
                    <div class="column is-4">
                        <label for="media" class="label">Mídia</label>
                        <div class="select is-fullwidth">
                            <select id="media" v-model="media_id" @change="formData.media = media_id">
                                <option v-for="m in media" :value="m.id">{{ m.name }}</option>
                            </select>
                            <p>Selected: {{ formData.media }}</p>
                        </div>
                    </div>
                    <div class="column is-8">
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
                </div>
                <div class="columns is-centered">
                    <div class="column is-one-third">
                        <button class="button is-primary is-fullwidth" @click="store">ENVIAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "NewMovie",
    data() {
        return {
            isLoading: false,
            yellow: 0,
            white: 5,
            formData: {
                title: '',
                original_title: '',
                year: 1900,
                time: '00:00',
                rating: 0,
                category_1: null,
                category_2: null,
                keyword: null,
                poster: '',
                summary: '',
                media: 0,
                img_url: '',
                img_width: 0,
                img_height: 0,
            },
            imdb: '',
            ac: '',
            media_id: 0,
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
            this.formData.rating = this.yellow
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
                this.formData.original_title = response.data.base.title
                this.formData.year = response.data.base.year
                this.formData.time = this.strTime(response.data.base.runningTimeInMinutes)
                this.formData.img_url = response.data.base.image.url
                this.formData.img_width = response.data.base.image.width
                this.formData.img_height = response.data.base.image.height
                console.log('MEDIA ID', this.formData.media)

                let cast = []
                for (let i = 0; i < 10; i++) {
                    let actor = response.data.cast[i].name
                    let characters = response.data.cast[i].characters
                    console.log('Characters', i, response.data.cast[i].characters)
                    let character = ''
                    if (response.data.cast[i].characters.length === 1) {
                        character = response.data.cast[i].characters[0]
                    } else if (response.data.cast[i].characters.length > 1) {
                        character = response.data.cast[i].characters[0] + ' / ' + response.data.cast[i].characters[1]
                    }
                    cast.push({actor: response.data.cast[i].name, character: character})
                }
                console.log('CAST', cast)
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
        },

        strTime(t) {
            const minute = t % 60
            const hour = Math.floor((t / 60))
            return '0' + hour + ':' + minute
        },

        /**
         * Send data to store movie.
         */
        store() {
            axios.post('/api/movies/store', this.formData).then(response => {
                if (response.status === 200) {
                    console.log('STORE', response.data)
                } else if ((response.status === 202)) {
                    alert('O filma já existe')
                }
                console.log('STORE', response.data)
            }).catch(error => console.error(error))
        }
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
