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
</template>

<script>
    export default {
        name: "tableList",
        props: ['tables']
    }
</script>

<style scoped>

</style>