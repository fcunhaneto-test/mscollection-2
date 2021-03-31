<template>
    <div class="container is-max-widescreen mt-5">
        <div class="columns is-centered">
            <div class="column is-four-fifths">
                <h2 class="title is-4">Scrapping From</h2>
                <div class="field-body">
                    <div class="field">
                        <label for="imdb" class="label">IMDB</label>
                        <input id="imdb" name="imdb" v-model="imdb" class="input" type="text" @keyup.enter="imdbScraping">
                        <div class="field">
                            <label for="adoro_cinema" class="label">Adoro Cinema</label>
                            <input id="adoro_cinema" name="adoro_cinema" class="input" type="text">
                        </div>
                    </div>
                </div>
                <hr>
                <h2 class="title is-4">Filme Formulário</h2>
                <div class="field is-horizontal">
                    <div class="field-body">
                        <div class="field">
                            <label for="title" class="label">Título</label>
                            <input id="title" name="title" v-model="formData.title" class="input" type="text">
                        </div>
                        <div class="field">
                            <label for="original_title" class="label">Título Original</label>
                            <input id="original_title" name="original_title" v-model="formData.original_title"
                                   class="input" type="text">
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column is-3">
                        <div class="field">
                            <label for="year" class="label">Ano</label>
                            <input id="year" name="title" v-model="formData.year" class="input" type="number">
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
                </div>
                <div class="columns">
                    <div class="column is-4">
                        <b-field label="Categoria 1" class="form-edit">
                            <b-input list="categories_1" name="category" v-model="formData.category_1" style="width: 100%;"/>
                            <datalist id="categories_1">
                                <option v-for="category in categories" :value="category.name"/>
                            </datalist>
                        </b-field>
                    </div>
                    <div class="column is-4">
                        <b-field label="Categoria 2" class="form-edit">
                            <b-input list="categories_2" name="category" v-model="formData.category_2" style="width: 100%;"/>
                            <datalist id="categories_2">
                                <option v-for="category in categories" :value="category.name"/>
                            </datalist>
                        </b-field>
                    </div>
                    <div class="column is-4">
                        <b-field label="Keyword" class="form-edit">
                            <b-input list="keywords" name="category_2" v-model="formData.keyword" style="width: 100%;"/>
                            <datalist id="keywords">
                                <option v-for="keyword in keywords" :value="keyword.name"/>
                            </datalist>
                        </b-field>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import cheerio from "cheerio";
const translate = {}
export default {
    name: "NewMovie",
    data() {
        return {
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
            },
            imdb: '',
            adoro_cinema: '',
        }
    },
    computed: {
        categories() {
            return this.$store.getters.getCategories
        },
        keywords() {
            return this.$store.getters.getKeywords
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
        imdbScraping() {
            axios.post('/api/movies/scrapping/', {
                html: this.imdb
            }).then(response => {
                const $ = cheerio.load(response.data)
                const context = $('.subtext').text()
                let arr = context.split('|')
                let str = arr.map((value, index) => {
                    let nv = value.replace(/(\r\n|\n|\r)/gm, "")
                    return nv.trim();
                })
                console.log(str)
                this.setTime(arr[1])
                this.setCategories(arr[2])

                const title = $('.title_wrapper').find('h1').text()

                this.setTitleYear(title)

                const original_title = $('.originalTitle').text().split(' (')
                this.formData.original_title = original_title[0]
            }).catch(error => console.error(error))
        },
        setTime(t) {
            let v = t.replace(/(h|min)/gm, "")
            const t_arr = v.trim().split(' ')
            this.formData.time = '0' + t_arr[0] + ':' + t_arr[1]
        },
        setCategories(c) {
            let nc = c.replace(/(\r\n|\n|\r)/gm, "")
            let categories = nc.split(', ')
            console.log('Categoria 1', categories[0])
            console.log('Categoria 2', categories[1])
        },
        setTitleYear(ty) {
            let ty_arr = ty.split('(')
            this.formData.title = ty_arr[0].trim()
            this.formData.year = parseInt(ty_arr[1].split(')'))
        }
    },
}
</script>

<style scoped>
hr {
    height: 2px;
    border-width: 0;
    color: #000000;
    background-color:#000000;
}
</style>
