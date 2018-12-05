<template>

    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div>

        <order-list v-bind:orders = 'orders' @edit-click="editOrder" @delete-click="deleteOrder"></order-list>
        <order-edit v-bind:current-order = 'currentMeal' :items='items' v-if="currentMeal" @order-saved="saveorder" @order-canceled="cancelEdit"></order-edit>
    </div>
</template>

<script>
    import mealList from './mealList.vue';
    import mealEdit from './mealEdit.vue';

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
                orders: [],
                users: [],
                items: [],
            }
        },
        components: {
            'meal-list': mealList,
            'order-edit': mealEdit,
        },
        methods: {
            editMeal: function(order){
                this.currentMeal = order;
                this.editingMeal = true;
                this.showSuccess = false;
            },

            deleteMeal: function(order){
                axios.delete('api/meals/'+order.id)
                    .then(response => {
                        this.showSuccess = true;
                        this.successMessage = 'Order Deleted';
                        this.getMeals();
                    });
            },
            saveMeals: function(){
                this.editingorder = false;
                axios.put('api/meals/'+this.currentMeal.id,this.currentMeal)
                    .then(response=>{
                        this.showSuccess = true;
                        this.successMessage = 'Meal Saved';
                        // Copies response.data.data properties to this.currentMeal
                        // without changing this.currentMeal reference
                        Object.assign(this.currentMeal, response.data.data);
                        this.currentMeal = null;
                        this.editingMeal = false;
                    });
            },
            cancelEdit: function(){
                this.showSuccess = false;
                this.editingMeal = false;
                axios.get('api/meal/'+this.currentMeal.id)
                    .then(response=>{
                        console.dir (this.currentMeal);
                        // Copies response.data.data properties to this.currentMeal
                        // without changing this.currentMeal reference
                        Object.assign(this.currentMeal, response.data.data);
                        console.dir (this.currentMeal);
                        this.currentMeal = null;
                    });
            },
            getOrders: function(){
                axios.get('api/meals')
                    .then(response=>{this.meals = response.data.data;});

            }
        },
        mounted() {
            this.getOrders();

        }
    }
</script>

<style scoped>
    .dropdown-menu.p-4.dropdown-menu-right{
        min-width: 15rem;
    }
</style>