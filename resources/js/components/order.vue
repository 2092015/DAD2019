<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div>
        <order-list v-bind:orders = 'orders' @prepared-click="preparedOrder" @inpreparation-click="inPreparationOrder"></order-list>
    </div>
</template>

<script>
    import orderList from './orderList.vue';
    import orderEdit from './orderEdit.vue';

    export default {
        data: function(){
            return {
                title: 'List Orders',
                editingOrder: false,
                showSuccess: false,
                showFailure: false,
                successMessage: '',
                failMessage: '',
                currentOrder: null,
                orders: [],
                users: [],
                items: [],
            }
        },
        components: {
            'order-list': orderList
        },
        methods: {
            preparedOrder: function(order){
                this.currentOrder = order;
                this.showSuccess = false;
                axios.put('api/orders/'+this.currentOrder.id,this.currentOrder)
                    .then(response=>{
                        this.currentOrder.state='prepared';
                        // Copies response.data.data properties to this.currentUser
                        // without changing this.currentUser reference
                        Object.assign(this.currentOrder, response.data.data);
                        this.currentOrder = null;
                        /*this.editingOrder = false;*/
                        this.showSuccess = true;
                        this.successMessage = 'Order Saved';
                    });
            },

            inPreparationOrder: function(order){
                this.currentOrder = order;
                this.showSuccess = false;
                axios.put('api/orders/'+this.currentOrder.id,this.currentOrder)
                    .then(response=>{
                        this.currentOrder.state='in preparation';
                        // Copies response.data.data properties to this.currentUser
                        // without changing this.currentUser reference
                        Object.assign(this.currentOrder, response.data.data);
                        this.showSuccess = true;
                        this.successMessage = 'Order Saved';
                        this.currentOrder = null;
                        /*this.editingUser = false;*/
                    });
            },
            getOrders: function(){
                axios.get('api/orders')
                    .then(response=>{console.log(response);this.orders = response.data.data;});

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
