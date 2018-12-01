<template>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Type</th>
            <!--<th>Sifht Active</th>-->
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="user in users"  :key="user.id" :class="{active: editingUser === user}">
            <td>{{ user.name }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.type }}</td>
            <!--<td>{{ user.department }}</td>-->
            <td>
                <a class="btn btn-sm btn-primary" v-on:click.prevent="editUser(user)">Edit</a>
                <a class="btn btn-sm btn-danger" v-on:click.prevent="deleteUser(user)">Delete</a>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: "userList",
        props: ['users'],
        data: function(){
            return{
                editingUser: null,
            }
        },
        methods: {
            editUser: function (user) {
                this.editingUser = user;
                this.$emit('edit-click', user);
            },
            deleteUser: function (user) {
                this.$emit('delete-click', user);
            }
        }
    }
</script>

<style scoped>

</style>
