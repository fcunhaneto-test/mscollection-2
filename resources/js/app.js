require('./bootstrap');

window.Vue = require('vue').default;


import Buefy from 'buefy'
Vue.use(Buefy, {
    defaultIconPack: 'fas',
})

import store from './store/main'

import VueRouter from "vue-router"
import router from "./routes"
Vue.use(VueRouter)

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: '#app',
});
