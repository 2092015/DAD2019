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
const addMeal2 = Vue.component('addMeal2', require('./components/addMeal2.vue'));

const routes = [
    {path: '/', component: item },
    {path: '/users', component: user ,
        beforeEnter:(to, from, next) => {
            if (store.state.user.type == 'manager') {
                next();
            }else {
                next(false);
            }
        }},
    {path: '/orders', component: order,
        beforeEnter:(to, from, next) => {
            if (store.state.user.type == 'cook') {
                next();
            }else{
                next();
            }
        }},
    {path: '/meals', component: meal},
    {path: '/tables', component: restaurantTable},
    {path: '/invoices', component: invoice},
    {path: '/profile', component: profile, name: 'profile'},
    {path: '/login', component: login, name: 'login'},
    {path: '/addMeal2', component: addMeal2, name: 'addMeal2'}

];

const router = new VueRouter({
    routes:routes
});

router.beforeEach((to, from, next) => {
    if(to.path !== '/') {
        if (!store.state.user) {
            store.commit('loadTokenAndUserFromSession');
        }
        if (!store.state.user) {

            next('/');
        }else{
            next();
        }
    }else{
        next();
    }

});

const app = new Vue({
    store,
    router,
    created() {
        this.$store.commit('loadTokenAndUserFromSession');

        console.log('Load '+this.$store.state.user);
    }
}).$mount('#app');
