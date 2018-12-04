<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>State</th>
            <th>Item</th>
            <th>Meal</th>
            <th>Responsable Cook</th>
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
            <td>{{ order.responsible_cook_id }}</td>

            <td>{{ order.start }}</td>
            <td>{{ order.end }}</td>
            <td>
                <a class="btn btn-sm btn-primary" v-on:click.prevent="editOrder(order)">Edit</a>
                <a class="btn btn-sm btn-danger" v-on:click.prevent="deleteOrder(order)">Delete</a>
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