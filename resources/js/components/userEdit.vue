<template>
    <div class="jumbotron" >
        <h2>Edit User</h2>
        <div class="form-group">
            <label for="inputName">Name</label>
            <input
                type="text" class="form-control" v-model="currentUser.name"
                name="name" id="inputName"
                placeholder="Fullname" value="" />
        </div>
        <div class="form-group">
            <label for="inputName">Username</label>
            <input
                    type="text" class="form-control" v-model="currentUser.username"
                    name="name" id="inputUsername"
                    placeholder="Username" value="" />
        </div>
        <div class="form-group">
            <label for="inputEmail">Email</label>
            <input
                type="email" class="form-control" v-model="currentUser.email"
                name="email" id="inputEmail"
                placeholder="Email address" value="" disabled/>
        </div>
        <div class="form-group">

            <select name="type" id="selectType" v-model="currentUser.type">
                <option v-for="option in options" v-bind:value="option.value">
                    {{ option.text }}
                </option>
            </select>


        </div>
        <!--<div class="large-12 medium-12 small-12 cell">
            <label>File
                <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
            </label>
            <button v-on:click="submitFile()">Submit</button>
        </div>-->

        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="saveUser()">Save</a>
            <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
        </div>

    </div>
</template>

<script>
    export default {
        name: "userEdit",
        props: [
            'currentUser','editingUser','usersTypes'
        ],
        data: function() {
            return {
                user: [this.$store.state.user],
                selected: '',//todo colocar aqui o tipo de user que está na bd
                options: [
                    { text: 'Manager', value: 'manager' },
                    { text: 'Cook', value: 'cook' },
                    { text: 'Cashier', value: 'cashier' },
                    { text: 'Waiter', value: 'waiter' }
                ]
            }},
        methods: {
            createUser: function () {
                this.$emit('user-created');
            },
            saveUser: function () {
                this.$emit('user-saved');
            },
            cancelEdit: function () {
                this.$emit('user-canceled');
            }
        }

    }
</script>

<style scoped>

</style>
