<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Photo</th>
            <th>Price</th>
            <!--<th>Actions</th>-->
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in items"  :key="item.id" :class="{active: editingItem === item}">
            <td>{{ item.name }}</td>
            <td>{{ item.type }}</td>
            <td>
                <img :src='item.photo_url'/>
            </td>
            <td>{{ item.price }} €</td>

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
    img {
        width: 75px;
    }
</style>