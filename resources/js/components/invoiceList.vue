<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>State</th>
            <th>Data</th>
            <th>Meal ID</th>
            <th>NIF</th>
            <th>Nome</th>
            <th>Total Price</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="invoice in invoices"  :key="invoice.id" >
            <td>{{ invoice.state }}</td>
            <td>{{ invoice.date }}</td>
            <td>{{ invoice.meal_id }}</td>
            <td>{{ invoice.nif }}</td>
            <td>{{ invoice.name }}</td>
            <td>{{ invoice.total_price }} €</td>

        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "invoiceList",
        props: ['invoices'],
        data: function(){
            return{
                editingInvoice: null,

            }
        }
    }
</script>

<style scoped>

</style>