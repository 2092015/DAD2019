<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div>

        <button type="button" class="btn btn-sm btn-primary" v-on:click.prevent="registerUser">Create</button>
        <register v-bind:current-user = 'currentUser' v-if="registeringUser" @user-added="addUser" @user-canceled="cancelRegister"></register>
        <user-list v-bind:users = 'users' @edit-click="editUser" @delete-click="deleteUser"></user-list>
        <user-edit v-bind:current-user = 'currentUser' v-if="editingUser" @user-saved="saveUser" @user-canceled="cancelEdit"></user-edit>
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
                registeringUser: false,
                showSuccess: false,
                showFailure: false,
                successMessage: '',
                failMessage: '',
                currentUser: {name:'', email:'', username:'', type:''},
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

            registerUser: function(){
                this.registeringUser = true;
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
            saveUser: function(file, password) {
                this.editingUser = false;
                var formData = new FormData();

                formData.append('name', this.currentUser.name);
                formData.append('email', this.currentUser.email);
                formData.append('type', this.currentUser.type);
                formData.append('username', this.currentUser.username);
                formData.append('password', password);
                if(file!=null){
                    formData.append('file', file, file.name);
                }

                axios.post('api/users/edit/' + this.currentUser.id, formData)
                    .then(response => {
                        this.showSuccess = true;
                        this.successMessage = 'User Saved';
                        Object.assign(this.currentUser, response.data.data);
                        this.currentUser= {name:'', email:'', username:'', type:''};
                        this.editingUser = false;
                    });
            },

            addUser: function(file) {
                this.registeringUser = false;
                var formData = new FormData();
                formData.append('name', this.currentUser.name);
                formData.append('email', this.currentUser.email);
                formData.append('type', this.currentUser.type);
                formData.append('username', this.currentUser.username);
                if(file!=null){
                    formData.append('file', file, file.name);
                }
                axios.post('api/users/',formData)
                    .then(response=>{
                        this.showSuccess = true;
                        this.successMessage = 'User Added';
                        //this.users.push(response.data.data);
                        this.currentUser= {name:'', email:'', username:'', type:''};
                        this.registeringUser = false;
                        this.getUsers();
                    })
                    .catch(error=>{
                        console.log(error);
                        this.showFailure= true;
                        this.failMessage= 'Email Already in use!';
                    })
            },

            cancelEdit: function(){
                this.showSuccess = false;
                this.editingUser = false;
                axios.get('api/users/'+this.currentUser.id)
                    .then(response=>{
                        // Copies response.data.data properties to this.currentUser
                        // without changing this.currentUser reference
                        Object.assign(this.currentUser, response.data.data);
                        this.currentUser= {name:'', email:'', username:'', type:''};
                    });
            },
            cancelRegister: function(){
                this.showSuccess = false;
                this.registeringUser = false;
                this.currentUser= {name:'', email:'', username:'', type:''};
            },
            getUsers: function(){
                axios.get('api/users')
                    .then(response=>{this.users = response.data.data;})
                    .catch(error => {
                        console.log("ERROR");
                    })
            },
        },
        mounted() {
            this.getUsers();

        }
    }
</script>

<style scoped>

</style>
