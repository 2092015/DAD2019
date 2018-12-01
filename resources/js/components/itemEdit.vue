<template>
    <div class="jumbotron" >
        <h2>Edit Item</h2>
        <div class="form-group">
            <label for="inputName">Name</label>
            <input
                    type="text" class="form-control" v-model="currentItem.name"
                    name="name" id="inputName"
                    placeholder="Fullname" value="" />
        </div>
        <div class="form-group">
            <label for="inputType">Type</label>
            <input
                    type="text" class="form-control" v-model="currentItem.type"
                    name="type" id="inputType"
                    placeholder="Type" value=""/>
        </div>
        <div class="form-group">
            <label for="inputDescription">Description</label>
            <input
                    type="text" class="form-control" v-model="currentItem.description"
                    name="description" id="inputDescription"
                    placeholder="Description" value=""/>
        </div>
        <div class="form-group">
            <label for="inputPhoto">Photo</label>
            <input
                    type="image" class="form-control" v-model="currentItem.photo_url"
                    name="photo" id="inputPhoto"
                    value=""/>
        </div>
        <div class="form-group">
            <label for="inputPrice">Price</label>
            <input
                    type="number" min="0.00" max="99.00" class="form-control" v-model="currentItem.price"
                    name="price" id="inputPrice"
                    value=""/>
        </div>


        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="saveItem()">Save</a>
            <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
        </div>

    </div>
</template>

<script>
    export default {
        name: "itemEdit",
        props: [
            'currentItem',
            'editingItem'
        ],
        methods: {
            saveItem: function () {
                this.$emit('item-saved');
            },
            cancelEdit: function () {
                this.$emit('item-canceled');
            }
        }

    }
</script>

<style scoped>

</style>
