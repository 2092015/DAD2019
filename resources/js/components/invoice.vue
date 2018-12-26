<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div>



        <invoice-list v-bind:invoices = 'invoices'></invoice-list>
        
    </div>
</template>

<script>
    import invoiceList from './invoiceList.vue';
    export default {
        name: "invoice",
        data: function(){
            return {
                title: 'Invoice List',
                showSuccess: false,
                showFailure: false,
                successMessage: '',
                failMessage: '',
                currentInvoice: null,
                invoices: [],
            }
        },
        components: {
            'invoice-list': invoiceList,
        },
        methods: {
            getInvoices: function(){
                axios.get('api/invoices')
                    .then(response=>{this.invoices = response.data.data;});

            }
        },
        mounted() {
            this.getInvoices();

        }
    }
</script>

<style scoped>

</style>