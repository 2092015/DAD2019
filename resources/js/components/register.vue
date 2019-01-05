<template>
    <div class="jumbotron" >
        <h2>Register User</h2>
        <form>
            <div class="form-group">
                <label for="inputName">Name</label>
                <input
                        type="text" class="form-control" v-model="user.name"
                        name="username" id="inputName"
                        placeholder="Name" value="" />
            </div>
            <div class="form-group">
                <label for="inputEmail">Email</label>
                <input
                        type="email" class="form-control" v-model="user.email"
                        name="email" id="inputEmail"
                        placeholder="Email address" value="" />
            </div>
            <div class="form-group">

                <select name="type" id="selectType" v-model="user.type">
                    <option v-for="option in options" v-bind:value="option.value">
                        {{ option.text }}
                    </option>
                </select>


            </div>
            <div class="form-group">
                <a class="btn btn-primary" v-on:click.prevent="register()">Register User</a>
                <router-link to="/users" class="btn btn-light">Cancel</router-link>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "register",
        props: [
            'usersTypes'
        ],
        data: function() {
            return {
                user:{
                    name:'',
                    email:''
                },
                selected: '',//todo colocar aqui o tipo de user que está na bd
                options: [
                    { text: 'Manager', value: 'manager' },
                    { text: 'Cook', value: 'cook' },
                    { text: 'Cashier', value: 'cashier' },
                    { text: 'Waiter', value: 'waiter' }
                ],
            }},

        methods: {
            register: function(){
                axios.post('api/users/',this.user)
                    .then(response=>{
                        this.showSuccess = true;
                        this.successMessage = 'User Created';
                    });
                //this.$router.push({ name: 'users', query: { redirect: '/users' } });
            },


        }

    }
</script>

<style scoped>

</style>
