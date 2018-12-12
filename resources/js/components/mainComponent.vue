<template>
    <div>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="#">{{title}}</a>
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
                    <button type="submit" class="btn btn-primary"  v-on:click.prevent="login()">Login</button>
                </form>
            </div>

        </nav>

        <div>
            <item v-bind:items = 'items'></item>
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
                items: [],
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
                    email: this.email,
                    password: this.password,
                })
                    .then(response=>{
                        this.showSuccess = true;
                        this.successMessage = 'Login Successfull';
                        this.accessToken = response.data.acessToken;
                        this.refreshToken = response.data.refreshToken;
                        this.currentUser = null;
                        console.log(this.accessToken);
                        console.log(this.refreshToken);

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
    .dropdown-menu.p-4.dropdown-menu-right{
        min-width: 15rem;
    }
</style>
