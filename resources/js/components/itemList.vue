<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Photo</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in items"  :key="item.id" :class="{active: editingItem === item}">
            <td>{{ item.name }}</td>
            <td>{{ item.type }}</td>
            <td>{{ item.photo_url }}</td>
            <td>{{ item.price }} €</td>
            <!--<td>{{ item.department }}</td>-->
            <td>
                <a class="btn btn-sm btn-primary" v-on:click.prevent="editItem(item)">Edit</a>
                <a class="btn btn-sm btn-danger" v-on:click.prevent="deleteItem(item)">Delete</a>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "itemList",
        props: ['items'],
        data: function(){
            return{
                editingItem: null,
            }
        },
        methods: {
            editItem: function (item) {
                this.editingItem = item;
                this.$emit('edit-click', item);
            },
            deleteItem: function (item) {
                this.$emit('delete-click', item);
            }
        }
    }
</script>

<style scoped>

</style>