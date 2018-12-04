<template>
    <div class="jumbotron" >
        <h2>Edit Order</h2>
        <div class="form-group">
            <label for="inputState">State</label>
            <input
                    type="text" class="form-control" v-model="currentOrder.state"
                    name="state" id="inputState"
                    value="" />
        </div>
        <div class="form-group">
            <label for="item_id">Item</label>
            <select class="form-control" id="item_id" name="item_id" v-model="currentOrder.item_id" >
                <option v-for="item in items" v-bind:value="item.id"> {{ item.name }} </option>
            </select>
        </div>

        <div class="form-group">
            <label for="item_id">Responsable Cook</label>
            <select class="form-control" id="responsible_cook_id" name="responsible_cook_id" v-model="currentOrder.responsible_cook_id" >
                <option v-for="user in users" v-bind:value="item.id"> {{ user.name }} </option>
            </select>
        </div>



        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="saveItem()">Save</a>
            <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "orderEdit",
        props: [
            'currentOrder',
            'editingOrder'
        ],
        methods: {
            saveOrder: function () {
                this.$emit('order-saved');
            },
            cancelEdit: function () {
                this.$emit('order-canceled');
            }
        }

    }
</script>

<style scoped>

</style>
