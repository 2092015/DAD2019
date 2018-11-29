<template>
    <div>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="#">{{ title }}</a>
            <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <div class="form-group">
                            <label for="exampleDropdownFormEmail2">Email address</label>
                            <input type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com">
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="form-group">
                            <label for="exampleDropdownFormPassword2">Password</label>
                            <input type="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Password">
                        </div>
                    </li>
                    <li class="nav-item">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="dropdownCheck2">
                            <label class="form-check-label" for="dropdownCheck2">
                                Remember me
                            </label>
                        </div>
                    </li>
                    <li class="nav-item">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </li>
                </ul>
            </div>-->
            <div class="dropdown">
            <button class="btn btn-dark" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <form class="dropdown-menu p-4 dropdown-menu-right">
                <div class="form-group">
                    <label for="exampleDropdownFormEmail2">Email address</label>
                    <input type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com">
                </div>
                <div class="form-group">
                    <label for="exampleDropdownFormPassword2">Password</label>
                    <input type="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Password">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="dropdownCheck2">
                    <label class="form-check-label" for="dropdownCheck2">
                        Remember me
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>

        </nav>

        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div>

        <user-list v-bind:users = 'users' @edit-click="editUser" @delete-click="deleteUser"></user-list>
        <user-edit v-bind:current-user = 'currentUser' v-if="currentUser" @user-saved="saveUser" @user-canceled="cancelEdit"></user-edit>
    </div>
</template>

<script>
    import userList from './userList.vue';
    import userEdit from './userEdit.vue';

    export default {
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
            }
        },
        components: {
            'user-list': userList,
            'user-edit': userEdit
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
                    .then(response=>{console.log(response);this.users = response.data.data;});

            }
        },
        mounted() {
            this.getUsers();

        }
    }
</script>

<style scoped>
    .dropdown-menu.p-4.dropdown-menu-right{
        min-width: 15rem;
    }
</style>
