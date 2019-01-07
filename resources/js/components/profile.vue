<template>
    <div class="jumbotron" >
        <h2>Edit User</h2>
        <div class="alert alert-success" v-if="showSuccess">
            <button type="button" class="close-btn" v-on:click="showSuccess=false">&times;</button>
            <strong>{{ successMessage }}</strong>
        </div>
        <div class="form-group">
            <label for="inputName">Name</label>
            <input
                type="text" class="form-control" v-model="user.name"
                name="name" id="inputName"
                placeholder="Fullname" value="" />
        </div>
        <div class="form-group">
            <label for="inputName">Username</label>
            <input
                type="text" class="form-control" v-model="user.username"
                name="name" id="inputUsername"
                placeholder="Username" value="" />
        </div>
        <div class="form-group">
            <label for="inputEmail">Email</label>
            <input
                type="email" class="form-control" disabled v-model="user.email"
                name="email" id="inputEmail"
                placeholder="Email address" value="" />
        </div>

        <div  class="form-group">
            <label for="inputPassword">Password</label>
            <input
                type="password" class="form-control" v-model="password"
                name="username" id="inputPassword" value="" />
        </div>

        <div class="form-group">
            <label for="selectType">Type</label>
            <select name="type" id="selectType" v-model="user.type" disabled>
                <option v-for="option in options" v-bind:value="option.value">
                    {{ option.text }}
                </option>
            </select>

        </div>
        <div class="large-12 medium-12 small-12 cell">
            <label>Photo
                <input type="file" id="file" ref="file" v-on:change="handleFile"/>
            </label>
        </div>

        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="saveUser()">Save</a>
            <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
        </div>

    </div>
</template>

<script>
    export default {
        name: "profile",
        props: [
            'usersTypes'
        ],
        data: function() {
            return {
                file:null,
                user: this.$store.state.user,
                password:'',
                showSuccess:false,
                successMessage:null,
                options: [
                    { text: 'Manager', value: 'manager' },
                    { text: 'Cook', value: 'cook' },
                    { text: 'Cashier', value: 'cashier' },
                    { text: 'Waiter', value: 'waiter' }
                ],
            }},
        methods: {

            saveUser: function() {
                var formData = new FormData();

                formData.append('name', this.user.name);
                formData.append('email', this.user.email);
                formData.append('type', this.user.type);
                formData.append('username', this.user.username);
                formData.append('password', this.password);
                if(this.file!=null){
                    formData.append('file', this.file, this.file.name);
                }

                axios.post('api/users/edit/', formData)
                    .then(response => {
                        this.showSuccess = true;
                        this.successMessage = 'User Edited';
                        this.$store.commit('setUser',response.data.data);
                    });
            },
            handleFile: function (event) {
                this.file = event.target.files[0];

            },
            cancelEdit: function () {
                this.$router.go(-1)
            },
        },
    }
</script>

<style scoped>

</style>
