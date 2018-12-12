<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Table Number</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="table in tables"  :key="table.id">
            <td>{{ table.table_number }}</td>
        </tr>
        </tbody>
    </table>
<!--    <b-container class="bv-example-row">
        <b-row >
            <b-col class=".col-md-150" v-for="table in tables"  :key="table.id">{{ table.table_number }}</b-col>
            <b-col>2 of 3</b-col>
            <b-col>3 of 3</b-col>
        </b-row>
    </b-container>-->
</template>

<script>
    export default {
        name: "tableList",
        props: ['tables']
    }
</script>

<style scoped>

</style>