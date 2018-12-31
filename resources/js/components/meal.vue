<template>

    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div>

        <meal-list v-bind:meals = 'meals'></meal-list>
        
    </div>
</template>

<script>
    import mealList from './mealList.vue';

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
            }
        },
        components: {
            'meal-list': mealList,
        },
        methods: {

            getMeals: function(){
                axios.get('api/meals')
                    .then(response=>{this.meals = response.data.data;});

            }
        },
        mounted() {
            this.getMeals();

        }
    }
</script>

<style scoped>
    .dropdown-menu.p-4.dropdown-menu-right{
        min-width: 15rem;
    }
</style>