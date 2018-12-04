<template>
    <div>
        <div class="jumbotron">
            <h1>{{ title }}</h1>
        </div>

        <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div>

        <item-list v-bind:items = 'items' @edit-click="editItem" @delete-click="deleteItem"></item-list>
        <item-edit v-bind:current-item = 'currentItem' v-if="currentItem" @item-saved="saveItem" @item-canceled="cancelEdit"></item-edit>
    </div>
</template>

<script>
    import itemList from './itemList.vue';
    import itemEdit from './itemEdit.vue';

    export default {
        data: function(){
            return {
                title: 'Menu',
                editingItem: false,
                showSuccess: false,
                showFailure: false,
                successMessage: '',
                failMessage: '',
                currentItem: null,
                items: [],
            }
        },
        components: {
            'item-list': itemList,
            'item-edit': itemEdit
        },
        methods: {
            editItem: function(item){
                this.currentItem = item;
                this.editingItem = true;
                this.showSuccess = false;
            },

            deleteItem: function(item){
                axios.delete('api/items/'+item.id)
                    .then(response => {
                        this.showSuccess = true;
                        this.successMessage = 'item Deleted';
                        this.getItems();
                    });
            },
            saveItem: function(){
                this.editingItem = false;
                axios.put('api/items/'+this.currentItem.id,this.currentItem)
                    .then(response=>{
                        this.showSuccess = true;
                        this.successMessage = 'item Saved';
                        // Copies response.data.data properties to this.currentItem
                        // without changing this.currentItem reference
                        Object.assign(this.currentItem, response.data.data);
                        this.currentItem = null;
                        this.editingItem = false;
                    });
            },
            cancelEdit: function(){
                this.showSuccess = false;
                this.editingItem = false;
                axios.get('api/items/'+this.currentItem.id)
                    .then(response=>{
                        console.dir (this.currentItem);
                        // Copies response.data.data properties to this.currentItem
                        // without changing this.currentItem reference
                        Object.assign(this.currentItem, response.data.data);
                        console.dir (this.currentItem);
                        this.currentItem = null;
                    });
            },
            getItems: function(){
                axios.get('api/items')
                    .then(response=>{console.log(response);this.items = response.data.data;});

            }
        },
        mounted() {
            this.getItems();

        }
    }
</script>

<style scoped>
    .dropdown-menu.p-4.dropdown-menu-right{
        min-width: 15rem;
    }
</style>
