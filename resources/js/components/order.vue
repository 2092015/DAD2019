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
            <button type="button" class="btn btn-info">Create Order</button>
        </div>
        <order-list v-bind:orders = 'orders' @edit-click="editOrder" @delete-click="deleteOrder"></order-list>
        <order-edit v-bind:current-order = 'currentOrder' :items='items' v-if="currentOrder" @order-saved="saveorder" @order-canceled="cancelEdit"></order-edit>
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
            'order-list': orderList,
            'order-edit': orderEdit
        },
        methods: {
            editOrder: function(order){
                this.currentOrder = order;
                this.editingOrder = true;
                this.showSuccess = false;
            },
            createOrder: function(order){

                this.editingOrder = true;
                this.showSuccess = false;
            },

            deleteOrder: function(order){
                axios.delete('api/orders/'+order.id)
                    .then(response => {
                        this.showSuccess = true;
                        this.successMessage = 'Order Deleted';
                        this.getOrders();
                    });
            },
            saveOrder: function(){
                this.editingorder = false;
                axios.put('api/orders/'+this.currentOrder.id,this.currentOrder)
                    .then(response=>{
                        this.showSuccess = true;
                        this.successMessage = 'order Saved';
                        // Copies response.data.data properties to this.currentOrder
                        // without changing this.currentOrder reference
                        Object.assign(this.currentOrder, response.data.data);
                        this.currentOrder = null;
                        this.editingorder = false;
                    });
            },
            cancelEdit: function(){
                this.showSuccess = false;
                this.editingorder = false;
                axios.get('api/orders/'+this.currentOrder.id)
                    .then(response=>{
                        console.dir (this.currentOrder);
                        // Copies response.data.data properties to this.currentOrder
                        // without changing this.currentOrder reference
                        Object.assign(this.currentOrder, response.data.data);
                        console.dir (this.currentOrder);
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
