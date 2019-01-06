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

    export default {
        name: "order",
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
                this.currentOrder.state='prepared';
                axios.put('api/orders/'+this.currentOrder.id, {'state':this.currentOrder.state})
                    .then(response=>{
                        Object.assign(this.currentOrder, response.data.data);
                        this.currentOrder = null;
                        this.showSuccess = true;
                        this.successMessage = 'Order Updated';
                    });
            },

            inPreparationOrder: function(order){
                this.currentOrder = order;
                this.showSuccess = false;
                this.currentOrder.state='in preparation';
                axios.put('api/orders/'+this.currentOrder.id,{'state':this.currentOrder.state})
                    .then(response=>{
                        Object.assign(this.currentOrder, response.data.data);
                        this.showSuccess = true;
                        this.successMessage = 'Order Saved';
                        this.currentOrder = null;
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
