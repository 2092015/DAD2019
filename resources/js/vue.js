/*jshint esversion: 6 */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/*import userList from './components/userList.vue';
import userEdit from './components/userEdit.vue';

Vue.component('user-list', userList)
Vue.component('user-edit', userEdit)*/

/*import UserComponent from './components/user.vue';
Vue.component('user', UserComponent)*/

import VueRouter from 'vue-router';
Vue.use(VueRouter);

const user = Vue.component('user', require('./components/user.vue'));

const routes = [
    {path: '/', redirect: '/users'},
    {path: '/users', component: user},
];

const router = new VueRouter({
    routes:routes
});

const app = new Vue({
    router,
    /*el: '#app',*/
    data: {

    }
    /*data: {
        title: 'List Users',
        editingUser: false,
        showSuccess: false,
        showFailure: false,
        successMessage: '',
        failMessage: '',
        currentUser: null,
        users: [],
        departments: []
    },
    methods: {
        editUser: function(user){
            this.currentUser = user;
            this.editingUser = true;
            this.showSuccess = false;
        },
          
        deleteUser: function(user){
            axios.delete('api/users/'+user.id)
                .then(response => {
                    this.showSuccess = true;
                    this.successMessage = 'User Deleted';
                    this.getUsers();
                });
        },
        saveUser: function(){
            this.editingUser = false;            
            axios.put('api/users/'+this.currentUser.id,this.currentUser)
                .then(response=>{
                    this.showSuccess = true;
                    this.successMessage = 'User Saved';
                    // Copies response.data.data properties to this.currentUser
                    // without changing this.currentUser reference
                    Object.assign(this.currentUser, response.data.data);
                    this.currentUser = null;
                    this.editingUser = false;
                });
        },
        cancelEdit: function(){
            this.showSuccess = false;
            this.editingUser = false;
            axios.get('api/users/'+this.currentUser.id)
                .then(response=>{
                    console.dir (this.currentUser);
                    // Copies response.data.data properties to this.currentUser
                    // without changing this.currentUser reference
                    Object.assign(this.currentUser, response.data.data); 
                    console.dir (this.currentUser);
                    this.currentUser = null;
                });
        },
        getUsers: function(){
            axios.get('api/users')
                .then(response=>{this.users = response.data.data;});
        }
    },
    mounted() {
        this.getUsers();
        axios.get('api/departments')
            .then(response=>{this.departments = response.data.data; });
    }*/
}).$mount('#app');
