import Category from "./components/admin/main/Category";

require('./bootstrap');
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'

window.Vue = require('vue');

import moment from "moment";

import {Form, HasError, AlertError} from 'vform'

import swal from 'sweetalert2'

window.swal = swal;

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.component('pagination', require('laravel-vue-pagination'));

import VueRouter from "vue-router";

Vue.use(VueRouter);

import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
});

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
import Overview from "./components/admin/main/Overview";
import Products from "./components/admin/main/Products";
import Categories from "./components/admin/main/Category";

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
        component: Admin,
        children: [
            {
                path: 'overview',
                name: 'overview',
                component: Overview
            },
            {
                path: 'categories',
                name: 'categories',
                component: Categories
            },
            {
                path: 'products',
                name: 'products',
                component: Products
            }
        ]
    }
];

const router = new VueRouter({
    mode: 'history',
    routes : routes
});

Vue.filter('upText', function (text) {
    return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('formatDate', function (created) {
    return moment(created).format('MMMM Do YYYY');
});

window.Fire = new Vue();

new Vue(Vue.util.extend(
    {router},
    App
)).$mount('#app');
