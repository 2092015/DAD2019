<template>
    <form v-if="user==null" class="dropdown-menu p-4 dropdown-menu-right" name="verifingUser">
        <h2>Login</h2>
        <div class="alert" :class="typeofmsg" v-if="showMessage">
            <button type="button" class="close-btn" v-on:click="showMessage=false">&times;</button>
            <strong>{{ message }}</strong>
        </div>
        <div class="form-group">
            <label for="exampleDropdownFormEmail2">Email address</label>
            <input v-model.trim="user.email" type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com">
        </div>
        <div class="form-group">
            <label for="exampleDropdownFormPassword2">Password</label>
            <input v-model="user.password" type="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Password">
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="dropdownCheck2">
            <label class="form-check-label" for="dropdownCheck2">
                Remember me
            </label>
        </div>
        <button type="submit" class="btn btn-primary"  v-on:click.prevent="login">Login</button>
    </form>
</template>

<script type="text/javascript">    
    export default {
        data: function(){
            return { 
                user: {
                    email:"",
                    password:""
                },
                typeofmsg: "alert-success",
                showMessage: false,
                message: "",
            }
        },
        methods: {
            login() {
                this.showMessage = false;
                axios.post('api/login', this.user)
                    .then(response => {
                        this.$store.commit('setToken',response.data.access_token);
                        return axios.get('api/users/me');
                    })
                    .then(response => {
                        this.$store.commit('setUser',response.data.data);
                        this.typeofmsg = "alert-success";
                        this.message = "User authenticated correctly";
                        this.showMessage = true;
                    })
                    .catch(error => {
                        this.$store.commit('clearUserAndToken');
                        this.typeofmsg = "alert-danger";
                        this.message = "Invalid credentials";
                        this.showMessage = true;
                        console.log(error);
                    })
            }
        },
    }
</script>
