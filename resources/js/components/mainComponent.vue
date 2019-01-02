<template>
    <div>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="#">{{title}}</a>

            <div class="dropdown">
                <button class="btn btn-dark" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <login></login>
            </div>

        </nav>

        <div>
            <item v-bind:items = 'items'></item>
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
                items: [],
            }
        },
        components: {
            'user': user,
            'order': order,
            'item': item
        },methods: {

        },
        mounted() {


        },
        computed:{
           
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
