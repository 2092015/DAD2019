<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div>



        <invoice-list v-bind:invoices = 'invoices' @paid-click="paid" @notpaid-click="notPaid"></invoice-list>
        
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

            },
            paid: function(invoice){
                this.currentInvoice = invoice;
                this.showSuccess = false;
                this.currentInvoice.state='paid';
                axios.put('api/invoices/'+this.currentInvoice.id, {'state':this.currentInvoice.state})
                    .then(response=>{
                        Object.assign(this.currentInvoice, response.data.data);
                        this.currentInvoice = null;
                        this.showSuccess = true;
                        this.successMessage = 'Invoice Paid';
                    });
                this.class="table-success"
                this.getInvoices();
            },
            notPaid: function(invoice){
                this.currentInvoice = invoice;
                this.showSuccess = false;
                this.currentInvoice.state='not paid';
                axios.put('api/invoices/'+this.currentInvoice.id, {'state':this.currentInvoice.state})
                    .then(response=>{
                        Object.assign(this.currentInvoice, response.data.data);
                        this.currentInvoice = null;
                        this.showFailure = true;
                        this.failMessage = 'Invoice Not Paid';
                    });
                this.class="table-success"
                this.getInvoices();
            },
        },
        mounted() {
            this.getInvoices();

        }
    }
</script>

<style scoped>

</style>