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
    export default {
        name: "invoice"
    }
</script>

<style scoped>

</style>