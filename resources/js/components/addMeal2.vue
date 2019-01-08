<template>
    <div class="container mt-4">

        <table class="table table-bordered mt-4">
            <thead class="thead-light">
            <tr>
                <th width="10%">Type</th>
                <th width="33%">Name</th>
                <th width="10%">Qty</th>
                <th width="10%">Price</th>
                <th width="15%">Total</th>
                <th width="27%">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(mealItem, index) in mealItems" :key="index">
                <td >
                    <span v-if="editIndex !== index">{{ mealItem.type }}</span>
                    <select v-if="editIndex === index" v-model="auxItem.type" v-on:change="getItemsByType"
                            class="form-control form-control-sm">
                        <option value="drink">Drink</option>
                        <option value="dish">Dish</option>
                    </select>
                </td>
                <td>
                    <span v-if="editIndex !== index">{{ mealItem.name }}</span>
                    <select v-if="editIndex === index" v-model="auxItem.index" v-on:change="fillItem()" class="form-control form-control-sm">

                        <option v-for="(item, index2) in items" :value="index2" :key="item.id">
                            {{ item.name }}
                        </option>

                    </select>
                </td>
                <td>
                    <span v-if="editIndex !== index">{{ mealItem.qty }}</span>
                    <span v-if="editIndex === index">
                      <input class="form-control form-control-sm" type="number" v-model.number="auxItem.qty">
                    </span>
                </td>
                <td>
                    <span v-if="editIndex !== index">{{mealItem.price}}</span>
                    <span v-if="editIndex === index">{{mealItem.price}}</span>
                </td>
                <td>
                    <span v-if="editIndex !== index">{{mealItem.sub_total}}</span>
                    <span v-if="editIndex === index" class="text-right">{{ subtotal(auxItem)}} €</span>
                </td>
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
                auxItem:{
                    index:null,
                    name: '',
                    type: '',
                    price:'',
                    sub_total:'',
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
                this.mealItems.push(item);
                this.auxItem = {
                    index:null,
                    name: '',
                    type: '',
                    price:'',
                    sub_total:'',
                    qty:'1'
                };
            },
            subtotal(item) {
                this.auxItem.sub_total = (item.qty * item.price)
                return this.auxItem.sub_total;
            },
            saveMeal(mealItems) {
                axios.post('api/meals')
                    .then(response=>{this.mealItems = response.data.data;});
            },
            getItemsByType() {

                if (this.auxItem.type=='drink'){

                    axios.get('api/drink_items')
                        .then(response=>{
                            this.items = response.data.data;
                        });

                }else {
                    axios.get('api/dish_items')
                        .then(response=>{this.items = response.data.data;});
                }

            },
            fillItem(){
                console.log(this.auxItem.index);
                let item = this.items[this.auxItem.index];
                this.auxItem.name = item.name;
                this.auxItem.price = item.price;
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
