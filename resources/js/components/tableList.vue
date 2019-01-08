<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Table Number</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="restaurant_table in tables"  :key="restaurant_table.id">
            <td>{{ restaurant_table.table_number }}</td>
            <td>
                <!--<label>Table Nbr</label>
                <input type="number">-->
                <button class="btn btn-dark" v-on:click.prevent="startMeal(restaurant_table.table_number)"
                        :disabled="(restaurant_table.meals.length > 0)">Start Meal</button>
            </td>
        </tr>
        </tbody>
    </table>
<!--    <b-container class="bv-example-row">
        <b-row >
            <b-col class=".col-md-150" v-for="restaurant_table in tables"  :key="restaurant_table.id">{{ restaurant_table.table_number }}</b-col>
            <b-col>2 of 3</b-col>
            <b-col>3 of 3</b-col>
        </b-row>
    </b-container>-->
</template>

<script>
    export default {
        name: "tableList",
        props: ['tables'],
        data: function(){
            return {

            }
        },
        methods: {
            startMeal(tableNum) {
                axios.post('api/meals/startMeal/'+tableNum)
                    .then(response => {
                        this.$store.commit('setMeal', response.data);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
        },

    }
</script>

<style scoped>

</style>
