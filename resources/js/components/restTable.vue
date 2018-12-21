<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>
        <table-list v-bind:tables = 'tables' ></table-list>

    </div>
</template>

<script>
    import tableList from './tableList.vue';
    export default {
        name: "restaurant_table",
        data: function () {
            return {
                title: 'List Tables',
                showSuccess: false,
                currentTables: null,
                tables: [],
            }
        },
        components: {
            'table-list': tableList,
        },
        methods: {
            getTables: function(){
                axios.get('api/restaurant_tables')
                    .then(response=>{console.log(response);this.tables = response.data.data;});

            }
        },
        mounted() {
            this.getTables();

        }
    }
</script>

<style scoped>

</style>