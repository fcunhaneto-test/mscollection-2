require('./bootstrap');

window.Vue = require('vue').default;


import Buefy from 'buefy'
Vue.use(Buefy)

import store from './store/main'

import VueRouter from "vue-router"
import router from "./routes"
Vue.use(VueRouter)

Vue.filter('strTime', function (value) {
    if(value) {
        let time = value.split(':')
        return time[0] + ':' + time[1]
    }
})

Vue.component('index', require('./Index').default);

const app = new Vue({
    el: '#app',
    store,
    router
});
