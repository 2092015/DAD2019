<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>State</th>
            <th>Item</th>
            <th>Meal</th>
            <th>Responsible Cook</th>
            <th>Start</th>
            <th>End</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="order in orders"  :key="order.id" :class="{active: editingOrder === order}">
            <td>{{ order.state }}</td>
            <td>{{ order.item }}</td>
            <td>{{ order.meal_id }}</td>
            <td>{{ order.responsible_cook }}</td>
            <td>{{ order.start }}</td>
            <td>{{ order.end }}</td>
            <td>
                <a class="btn btn-sm btn-success" v-on:click.prevent="editOrder(order)">Prepared</a>
                <a class="btn btn-sm btn-warning" >In Preparation</a>
                <!--<a class="btn btn-sm btn-danger" >Delete</a>
                <a class="btn btn-sm btn-danger" >Delete</a>-->
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "orderList",
        props: ['orders'],
        data: function(){
            return{
                editingOrder: null,
            }
        },
        methods: {
            editOrder: function (order) {
                this.editingOrder = order;
                this.$emit('edit-click', order);
            },
            deleteOrder: function (order) {
                this.$emit('delete-click', order);
            }
        }
    }
</script>

<style scoped>

</style>