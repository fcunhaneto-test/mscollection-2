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

Vue.filter('strSingular', function (value) {
    if(value) {
        return value.slice(0, -1).toUpperCase();
    }
})

Vue.component('index', require('./Index').default);
Vue.component('auth', require('./Auth').default);
Vue.component('admin', require('./Admin').default);

const app = new Vue({
    el: '#app',
    store,
    router
});
