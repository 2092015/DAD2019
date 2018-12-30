<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>State</th>
            <th>Table Number</th>
            <th>Responsible Cook</th>
            <th>Total Price Preview</th>
            <th>Start</th>
            <th>End</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="meal in meals"  :key="meal.id" :class="{active: editingMeal === meal}">
            <td>{{ meal.state }}</td>
            <td>{{ meal.table_number }}</td>
            <td>{{ meal.responsible_waiter }}</td>
            <td>{{ meal.total_price_preview }} €</td>
            <td>{{ meal.start }}</td>
            <td>{{ meal.end }}</td>


        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "mealList",
        props: ['meals'],
        data: function(){
            return{
                editingMeal: null,
            }
        }
    }
</script>

<style scoped>

</style>