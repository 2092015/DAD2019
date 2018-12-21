/*jshint esversion: 6 */



require('./bootstrap');

window.Vue = require('vue');

import store from './stores/global-store';

import VueRouter from 'vue-router';
Vue.use(VueRouter);

const user = Vue.component('user', require('./components/user.vue'));
const item = Vue.component('item', require('./components/item.vue'));
const order = Vue.component('order', require('./components/order.vue'));
const meal = Vue.component('meal', require('./components/meal.vue'));
const restaurantTable = Vue.component('restaurant_table', require('./components/restTable.vue'));
const invoice = Vue.component('invoice', require('./components/invoice.vue'));
const mainComponent = Vue.component('main_component', require('./components/mainComponent.vue'));
const profile = Vue.component('profile', require('./components/profile.vue'));
const login = Vue.component('login', require('./components/login.vue'));
const logout = Vue.component('logout', require('./components/logout.vue'));

const routes = [
    {path: '/', redirect: '/mainComponent'},
    {path: '/mainComponent', component: mainComponent},
    {path: '/users', component: user},
    {path: '/items', component: item},
    {path: '/orders', component: order},
    {path: '/meals', component: meal},
    {path: '/tables', component: restaurantTable},
    {path: '/invoices', component: invoice},
    { path: '/profile', component: profile, name: 'profile'},
    { path: '/login', component: login, name: 'login'},
    { path: '/logout', component: logout, name: 'logout'}

];


const router = new VueRouter({
    routes:routes
});

router.beforeEach((to, from, next) => {
    if ((to.name == 'mainComponent') || (to.name == 'logout')) {
        if (!store.state.user) {
            next("/login");
            return;
        }
    }
    next();
});


const app = new Vue({
    router,
    store,
    created() {
        console.log(this.$store.state.user);
        /*this.$store.commit('loadDepartments');*/
        this.$store.commit('loadTokenAndUserFromSession');
        console.log(this.$store.state.user);
    }
}).$mount('#app');
