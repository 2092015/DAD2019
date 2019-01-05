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
            <td >{{ order.state }}</td>
            <td >{{ order.item }}</td>
            <td >{{ order.meal_id }}</td>
            <td >{{ order.responsible_cook }}</td>
            <td >{{ order.start }}</td>
            <td >{{ order.end }}</td>
            <td >
                <a class="btn btn-sm btn-success" v-if="order.state=='in preparation'" v-on:click.prevent="preparedOrder(order)">Prepared</a>
                <a class="btn btn-sm btn-warning" v-if="order.state=='confirmed'" v-on:click.prevent="inPreparationOrder(order)">In Preparation</a>
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
            preparedOrder: function (order) {
                this.editingOrder = order;
                this.$emit('prepared-click', order);
            },
            inPreparationOrder: function (order) {
                this.editingOrder = order;
                this.$emit('inpreparation-click', order);
            }
        }
    }
</script>

<style scoped>

</style>