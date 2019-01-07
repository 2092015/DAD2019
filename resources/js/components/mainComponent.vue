<template>
    <div>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="#">{{title}}</a>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/users" >Users</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/orders">Orders</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/meals">Meals</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/tables">Tables</router-link>
                    </li>
                </ul>
            <div class="dropdown">
                <button class="btn btn-dark" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <login></login>
            </div>
        </nav>
        <div>
            <router-view></router-view>
            <!--<item v-bind:items = 'items'></item>-->
        </div>
    </div>
</template>

<script>
    import user from './user.vue';
    import order from './order.vue';
    import item from './item.vue';
    import meal from './meal.vue';
    import invoice from './invoice.vue';

    export default {
        name: "main_component",
        data: function(){
            return {
                title: 'DAD Restaurant',
                showSuccess: false,
                showFailure: false,
                successMessage: '',
                failMessage: '',
                items: []
            }
        },
        components: {
            'user': user,
            'order': order,
            'item': item,
            'meal': meal,
            'invoice': invoice,
        },methods: {

        },
        mounted() {
        },
        computed:{
            isLogged: function () {
                // `this` points to the vm instance
                return this.$store.state.user;
            },
            /*typeUser:function () {
                if(!this.$store.state.user) {
                    // If not authenticated, add a path where to redirect after login.
                    console.log("sem user");
                    console.log(this.$store.state.user);
                    this.$router.push({ name: 'login', query: { redirect: '/items' } });
                }else if(this.$store.state.user.type=='cook'){
                    console.log("logado cook");
                    this.$router.push({ name: 'order', query: { redirect: '/orders' } });

                }else if(this.$store.state.user.type=='cashier'){
                    console.log("logado cashier");
                    this.$router.push({ name: 'invoice', query: { redirect: '/invoice' } });

                }else if(this.$store.state.user.type=='waiter'){
                    console.log("logado waiter");
                    console.log(this.$store.state.user);
                    this.$router.push({ name: 'meal', query: { redirect: '/meals' } });

                }else if(this.$store.state.user.type=='manager'){
                    console.log("logado manager");
                    console.log(this.$store.state.user);
                    this.$router.push({ name: 'user', query: { redirect: '/users' } });

                }
            }*/
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
    .navbar-nav{
        flex-direction: row;

    }
    .navbar-nav .nav-link{
        padding-right: 5px;
        padding-left: 5px;
    }
</style>
