<template>
    <div>
        <nav class="navbar navbar-dark bg-dark">
            <a class="navbar-brand" href="#">{{ title }}</a>
            <div class="dropdown">
                <button class="btn btn-dark" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <form class="dropdown-menu p-4 dropdown-menu-right">
                    <div class="form-group">
                        <label for="exampleDropdownFormEmail2">Email address</label>
                        <input type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com">
                    </div>
                    <div class="form-group">
                        <label for="exampleDropdownFormPassword2">Password</label>
                        <input type="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Password">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="dropdownCheck2">
                        <label class="form-check-label" for="dropdownCheck2">
                            Remember me
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>

        </nav>

        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div>

        <order-list v-bind:orders = 'orders' @edit-click="editOrder" @delete-click="deleteOrder"></order-list>
        <order-edit v-bind:current-order = 'currentOrder' v-if="currentOrder" @order-saved="saveorder" @order-canceled="cancelEdit"></order-edit>
    </div>
</template>

<script>
    import orderList from './orderList.vue';
    import orderEdit from './orderEdit.vue';

    export default {
        data: function(){
            return {
                title: 'List Orders',
                editingorder: false,
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

            deleteOrder: function(order){
                axios.delete('api/orders/'+order.id)
                    .then(response => {
                        this.showSuccess = true;
                        this.successMessage = 'Order Deleted';
                        this.getOrders();
                    });
            },
            saveorder: function(){
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
                    .then(response=>{console.log(response);this.orders = response.data;});

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
