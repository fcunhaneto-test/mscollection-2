import VueRouter from "vue-router";

import Titles from "./frontend/Titles";
import TitlesAdmin from "./backend/TitlesAdmin";

import NewMovie from "./backend/NewMovie";

import Login from "./auth/Login";
import Logout from "./auth/Logout";

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
    {
        path: '/logout',
        component: Logout,
        name: 'logout'
    },
    {
        path: '/admin/filmes/:channel',
        component: TitlesAdmin,
        name: 'admin-movies',
        props: {table: 'movies', header: 'Filmes'}
    },
    {
        path: '/admin/series/:channel',
        component: TitlesAdmin,
        name: 'admin-series',
        props: {table: 'series', header: 'Séries'}
    },
    {
        path: '/admin/novo/filme',
        component: NewMovie,
        name: 'new-movie',
        props: {table: 'movies'}
    },
];

const router = new VueRouter({
    mode: "history",
    routes
})

export default router;
