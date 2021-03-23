import VueRouter from "vue-router";

import Titles from "./frontend/Titles";
import Login from "./auth/Login";
const routes = [
    {
        path: '/filmes/:channel',
        component: Titles,
        name: 'frontend-movies'
    },
    {
        path: '/series/:channel',
        component: Titles,
        name: 'frontend-series'
    },
    {
        path: '/login',
        component: Login,
        name: 'login'
    },
];

const router = new VueRouter({
    mode: "history",
    routes
})

export default router;
