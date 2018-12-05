<template>
    <div>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="#">{{title}}</a>
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
                        <input v-model="email" type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com">
                    </div>
                    <div class="form-group">
                        <label for="exampleDropdownFormPassword2">Password</label>
                        <input v-model="password" type="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Password">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="dropdownCheck2">
                        <label class="form-check-label" for="dropdownCheck2">
                            Remember me
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary"  v-on:click="login()">Login</button>
                </form>
            </div>

        </nav>

        <div>
            <p>{{this.acessToken}}</p>
            <p>{{this.refreshToken}}</p>
        </div>
    </div>
</template>

<script>
    import user from './user.vue';
    import order from './order.vue';
    import item from './item.vue';

    export default {
        name: "main_component",
        data: function(){
            return {
                title: 'DAD Restaurant',
                showSuccess: false,
                showFailure: false,
                successMessage: '',
                failMessage: '',
                password: '',
                email: '',
                acessToken: null,
                refreshToken:null,
            }
        },
        components: {
            'user': user,
            'order': order,
            'item': item
        },
        methods: {

            login: function(){
                axios.post('api/login/',{
                    params:{
                        email: this.email,
                        password: this.password,
                    }
                })
                    .then(response=>{
                        this.showSuccess = true;
                        this.successMessage = 'Login Successfull';
                        //Object.assign(this.currentUser, response.data.data);
                        this.accessToken = response.data.acessToken;
                        this.refreshToken = response.data.refreshToken;
                        this.currentUser = null;
                    }).catch(function (error) {
                        this.showFailure=true;
                        this.failMessage='Login Invalid';
                    });
            }
        },
        mounted() {


        }
    }
</script>

<style scoped>

</style>