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
            <label for="inputEmail">Email</label>
            <input
                type="email" class="form-control" v-model="currentUser.email"
                name="email" id="inputEmail"
                placeholder="Email address" value="" disabled/>
        </div>
        <div class="form-group">
            <label for="inputType">Type</label>
            <!--<select class="form-control" id="inputType" name="user_type" v-model="user.type">
                <option v-for="userType in usersTypes" v-bind:value="usersTypes.userType"> {{ user.type }} </option>
            </select>-->

            <!--<input
                type="text" class="form-control" v-model="currentUser.type"
                name="type" id="inputType"
                placeholder="Type" value=""/>-->
        </div>
        <!--<div class="form-group">
            <label for="department_id">Department:</label>
            <select class="form-control" id="department_id" name="department_id" v-model="currentUser.department_id" >
                <option v-for="department in departments" v-bind:value="department.id"> {{ department.name }} </option>
            </select>
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
        methods: {
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
