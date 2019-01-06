<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Type</th>
<!--            <th>Photo</th>-->
            <th>Price</th>
            <!--<th>Actions</th>-->
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in items"  :key="item.id" :class="{active: editingItem === item}">
            <td>{{ item.name }}</td>
            <td>{{ item.type }}</td>
<!--            <td>
                <img :src='item.photo_url'/>
            </td>-->
            <td>{{ item.price }} €</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "addMeal",
        props: ['dishes_items','drink_items'],
        data: function(){
          return {
              editingItem: null,
          }
        },
        methods: {
            getDrinkItems: function () {

                this.$emit('drinkitems-click');
            },
            getDishItems: function () {

                this.$emit('dishitems-click');
            },
            getItems: function(){
                axios.get('api/items')
                    .then(response=>{this.items = response.data.data;});

            },
            editItem: function (item) {
                this.editingItem = item;
                this.$emit('edit-click', item);
            }
        },
        mounted() {
            this.getItems();
        }


    }

</script>

<style scoped>
/*    #addMealTab table {
        color : white;
        background-color: #428bca;
        padding : 5px 15px;
    }*/
</style>