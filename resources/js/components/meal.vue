<template>

    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div>
        <div>
            <router-link to="/addMeal2" class="btn btn-sm btn-primary" @items-click="getItems"v-on:click.prevent="createMeal()">Create Meal</router-link>
        </div>
        <meal-list v-bind:meals = 'meals'></meal-list>
        
    </div>
</template>

<script>
    import mealList from './mealList.vue';
    import addMeal2 from './addMeal2.vue';

    export default {
        data: function(){
            return {
                title: 'List Meals',
                editingMeal: false,
                showSuccess: false,
                showFailure: false,
                successMessage: '',
                failMessage: '',
                currentMeal: null,
                meals:[],
                items:[]
            }
        },
        components: {
            'meal-list': mealList,
            'addMeal2':addMeal2
        },
        methods: {

            getMeals: function(){
                axios.get('api/meals')
                    .then(response=>{this.meals = response.data.data;});

            },
            getItems: function(){
                axios.get('api/items')
                    .then(response=>{this.items = response.data.data;});

            },

        },
        mounted() {
            this.getMeals();
            this.getItems();

        }
    }
</script>

<style scoped>
    .dropdown-menu.p-4.dropdown-menu-right{
        min-width: 15rem;
    }
</style>