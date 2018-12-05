/*jshint esversion: 6 */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
Vue.use(VueRouter);

const user = Vue.component('user', require('./components/user.vue'));
const item = Vue.component('item', require('./components/item.vue'));
const order = Vue.component('order', require('./components/order.vue'));
const meal = Vue.component('meal', require('./components/meal.vue'));
const mainComponent = Vue.component('main_component', require('./components/mainComponent.vue'));

const routes = [
    {path: '/', redirect: '/mainComponent'},
    {path: '/mainComponent', component: mainComponent},
    {path: '/users', component: user},
    {path: '/items', component: item},
    {path: '/orders', component: order},
    {path: '/meals', component: meals},
];

const router = new VueRouter({
    routes:routes
});

const app = new Vue({
    router,
}).$mount('#app');
