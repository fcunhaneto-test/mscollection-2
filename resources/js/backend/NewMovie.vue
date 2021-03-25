<template>
    <div class="container is-max-widescreen mt-5">
        <div class="columns is-centered">
            <div class="column is-four-fifths">
                <div class="field is-horizontal">
                    <div class="field-body">
                        <div class="field">
                            <label for="title" class="label">Título</label>
                            <input id="title" name="title" class="input" type="text">
                        </div>
                        <div class="field">
                            <label for="original_title" class="label">Título Original</label>
                            <input id="original_title" name="original_title" class="input" type="text">
                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column is-3">
                        <div class="field">
                            <label for="year" class="label">Ano</label>
                            <input id="year" name="title" class="input" type="number">
                        </div>
                    </div>
                    <div class="column is-3">
                        <div class="field">
                            <label for="time" class="label">Tempo</label>
                            <input id="time" name="time" class="input" type="time">
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
                        <div class="field">
                            <b-field label="Categoria 1">
                                <b-autocomplete
                                    rounded
                                    v-model="name"
                                    :data="filteredDataArray"
                                    icon="magnify"
                                    clearable
                                    @select="option => selected = option">
                                    <template #empty>No results found</template>
                                </b-autocomplete>
                            </b-field>
                        </div>
                    </div>
                    <div class="column is-4">
                        <div class="field">
                            <label for="category-2" class="label">Categoria 2</label>
                            <input id="category-2" name="category_2" class="input" type="text">
                        </div>
                    </div>
                    <div class="column is-4">
                        <div class="field">
                            <label for="keyword" class="label">Keyword</label>
                            <input id="keyword" name="keyword" class="input" type="text">
                        </div>
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
            yellow: 0,
            white: 5,
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

        },
        addStar(ws) {
            console.log('ADD', ws)
            this.yellow += ws
            this.white = 5 - this.yellow
        },
    },
}
</script>

<style scoped>

</style>
