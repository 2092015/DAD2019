<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div>

        <user-list v-bind:users = 'users' @edit-click="editUser" @delete-click="deleteUser"></user-list>
        <user-edit v-bind:current-user = 'currentUser' v-if="currentUser" @user-saved="saveUser" @user-canceled="cancelEdit"></user-edit>
        <register @register-click="register"></register>
    </div>
</template>

<script>
    import userList from './userList.vue';
    import userEdit from './userEdit.vue';
    import register from './register.vue';

    export default {
        name: "user",
        data: function(){
            return {
                title: 'List Users',
                editingUser: false,
                showSuccess: false,
                showFailure: false,
                successMessage: '',
                failMessage: '',
                currentUser: null,
                users: [],
                usersTypes: [{ userType: "Cook"},{ userType: "Manager"},{ userType: "Waiter"},{ userType: "Cashier"}]
            }
        },
        components: {
            'user-list': userList,
            'user-edit': userEdit,
            'register':register
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
            cancelRegister: function(){
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

        }
    }
</script>

<style scoped>

</style>
