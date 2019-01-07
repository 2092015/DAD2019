<template>
    <div class="jumbotron" >
        <h2>Register User</h2>
        <form id="form">
            <div class="form-group">
                <label for="inputName">Name</label>
                <input
                        type="text" class="form-control" v-model="currentUser.name"
                        name="username" id="inputName"
                        placeholder="Name" value="" />
            </div>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input
                        type="email" class="form-control" v-model="currentUser.email"
                        name="email" id="inputEmail"
                        placeholder="Email address" value="" />
            </div>
            <div class="form-group">
                <label for="inputUsername">Username</label>
                <input
                    type="text" class="form-control" v-model="currentUser.username"
                    name="username" id="inputUsername"
                    placeholder="Username" value="" />
            </div>

            <div class="form-group">
                <label for="selectType">Type</label>
                <select name="type" id="selectType" v-model="currentUser.type">
                    <option v-for="option in options" v-bind:value="option.value">
                        {{ option.text }}
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="inputEmail">Image</label>
                <input type="file" class="form-control" v-on:change="handleFile" name="image" id="inputImage" />
            </div>

            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="register()">Register User</a>
                <a class="btn btn-light" v-on:click.prevent="cancelRegister()">Cancel</a>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "register",
        props: [
            'usersTypes', 'currentUser'
        ],
        data: function() {
            return {
                file:null,
                options: [
                    { text: 'Manager', value: 'manager' },
                    { text: 'Cook', value: 'cook' },
                    { text: 'Cashier', value: 'cashier' },
                    { text: 'Waiter', value: 'waiter' }
                ],
            }
        },

        methods: {
            register: function(){
                this.$emit('user-added', this.file);
            },
            handleFile: function (event) {
                this.file = event.target.files[0];

            },
            cancelRegister: function () {
                this.$emit('user-canceled');
            },

        },
    }
</script>

<style scoped>

</style>
