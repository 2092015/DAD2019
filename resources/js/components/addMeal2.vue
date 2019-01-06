<template>
    <div class="container mt-4">

        <table class="table table-bordered mt-4">
            <thead class="thead-light">
            <tr>
                <th width="15%">Type</th>
                <th width="45%">Name</th>
                <th width="10%">Qty</th>
                <th width="10%">Price</th>
                <th width="15%">Total</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(mealItem, index) in mealItems" :key="index">
                <td>
                    <select v-model="item.type" v-on:change="getItemsByType" class="form-control form-control-sm">
                        <option v-for="option in options" v-bind:value="option.value" >
                            {{ option.text }}
                        </option>
                    </select>
                </td>
                <td>
                    <select v-model="item.name" class="form-control form-control-sm">
                        <option v-for="item in items" type="option.text" :key="item.id">{{ item.name }}  </option>
                    </select>
                </td>
                <td>
                    <span v-if="editIndex !== index">{{ item.qty }}</span>
                    <span v-if="editIndex === index">
              <input class="form-control form-control-sm" type="number" v-model.number="item.qty">
            </span>
                </td>
                <td >{{items.price}}</td>
                <td><div class="text-right">{{ subtotal(item)}} €</div></td>
                <td>
            <span v-if="editIndex !== index">
              <button @click="edit(mealItem, index)" class="btn btn-sm btn-outline-secondary mr-2">Edit</button>
              <button @click="remove(mealItem, index)" class="btn btn-sm btn-outline-secondary mr-2">Remove</button>
            </span>
                    <span v-else>
              <button class="btn btn-sm btn-outline-secondary mr-2" @click="cancel(mealItem)">Cancel</button>
              <button class="btn btn-sm btn-outline-secondary mr-2" @click="save(mealItem)">Save</button>
            </span>
                </td>
            </tr>
            </tbody>

        </table>
        <div class="col-3 offset-9 text-right my-3">
            <button v-show="!editIndex" @click="add" class="btn btn-sm btn-secondary">Add item</button>
        </div>


        <div class="col-3 offset-9">

            <div class="input-group input-group-sm mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Sub total</span>
                </div>
                <input class="form-control form-control-sm text-right" disabled :value="this.allSubTotal">
            </div>

            <div class="input-group input-group-lg mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Total</span>
                </div>
                <input class="form-control form-control-sm text-right" disabled :value="this.total">
            </div>

        </div>
        <div class="col-3 offset-9 text-right my-3">
            <button v-show="!editIndex" @click="saveMeal" class="btn btn-sm btn-secondary">Save Meal</button>
        </div>

    </div>
</template>

<script>
    export default {
        name: 'addMeal2',
        data() {

            return {
                editIndex: null,
                originalData: null,
                mealItems: [],
                items:[],
                item:{
                    name: '',
                    type: '',
                    price:'',
                    qty:'1'

                },
                orders:[],
                options: [
                    { text: 'Drink', value: 'drink' },
                    { text: 'Dish', value: 'dish' }
                ]
            }
        },
        methods: {
            add() {
                this.originalData = null
                this.mealItems.push({ type: '', name: '', price: '', qty: 1 })
                this.editIndex = this.mealItems.length - 1
            },
            edit(mealItem, index) {
                this.originalData = Object.assign({}, mealItem)
                this.editIndex = index
            },
            cancel(mealItem) {
                this.editIndex = null
                if (!this.originalData) {
                    this.mealItems.splice(this.mealItems.indexOf(mealItem), 1)
                    return
                }
                Object.assign(mealItem, this.originalData)
                this.originalData = null
            },
            remove(mealItem, index) {
                this.items.splice(index, 1)
            },
            save(item) {
                this.originalData = null
                this.editIndex = null
            },
            subtotal(mealItem) {
                return (mealItem.qty * mealItem.price)
            },
            saveMeal(mealItems) {
                axios.post('api/meals')
                    .then(response=>{this.mealItems = response.data.data;});
            },
            getItemsByType() {

                if (this.item.type=='drink'){

                    axios.get('api/drink_items')
                        .then(response=>{this.items = response.data.data;});

                }else {
                    axios.get('api/dish_items')
                        .then(response=>{this.items = response.data.data;});
                }

            }

        },
        computed: {
            allSubTotal() {
                return this.items
                    .map(item => this.subtotal(item))
                    .reduce((a, b) => a + b, 0)
            },
            total() {
                return this.allSubTotal
            }
        },
        /*mounted (){
            this.getItems();



        }*/
    }
</script>

<style>
    input[type="number"] {
        text-align: right;
    }
</style>