require('./bootstrap');
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'

window.Vue = require('vue');

import VueRouter from "vue-router";

Vue.use(VueRouter);

import VueAxios from "vue-axios";
import axios from 'axios';

Vue.use(VueAxios, axios);

Vue.component('Navbar', require('./components/client/layouts/Navbar.vue').default);
Vue.component('Hero', require('./components/client/layouts/Hero.vue').default);
Vue.component('Product', require('./components/client/layouts/Product.vue').default);

import App from './components/App';
import Admin from './components/admin/Admin.vue';
import Client from './components/client/Client.vue';
import About from './components/guest/About';
import Homepage from "./components/client/main/Homepage";

const routes = [
    {
        path: '/',
        name: 'client',
        component: Client,
        children: [
            {
                path: '',
                name: 'homepage',
                component: Homepage
            },
            {
                path: 'about',
                name: 'about',
                component: About
            }
        ]
    },
    {
        path: '/admin',
        name: 'admin',
        component: Admin
    }
];

const router = new VueRouter({
    mode: 'history',
    routes : routes
});

new Vue(Vue.util.extend(
    {router},
    App
)).$mount('#app');
