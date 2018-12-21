<template>
    <div>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="#">{{title}}</a>

            <div class="dropdown">
                <button class="btn btn-dark" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <login></login>
                <!--<v-form v-else>
                    <h1>User Logged &lt;!&ndash;{{user.name}}&ndash;&gt;</h1>
                </v-form>-->
            </div>

        </nav>

        <div>
            <item v-bind:items = 'items'></item>
            <p>{{this.accessToken}}</p>
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
                accessToken: null,
                refreshToken:null,
                items: [],
            }
        },
        components: {
            'user': user,
            'order': order,
            'item': item
        },methods: {
            login: function () {
                axios.post('api/login/', {
                    email: this.email,
                    password: this.password,
                })
                    .then(response => {
                        this.showSuccess = true;
                        this.successMessage = 'Login Successfull';
                        this.accessToken = response.data.access_token;
                        this.refreshToken = response.data.refresh_token;
                        this.currentUser = null;
                        console.log(this.accessToken);
                        console.log(this.refreshToken);
                    }).catch(function (error) {
                    this.showFailure = true;
                    this.failMessage = 'Login Invalid';
                });
            },
        },
        mounted() {


        }

}
</script>

<style scoped>
    .dropdown-menu.p-4.dropdown-menu-right{
        min-width: 15rem;
    }
    h1 {
        color: white;
    }
</style>
