<template>
    <div class="jumbotron" >
        <h2>Edit Profile</h2>
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
            <label for="inputTypeUser">Type</label>
            <label>{{currentUser.type}}</label>
        </div>
        <div class="large-12 medium-12 small-12 cell">
            <label>Photo
                <input type="file" id="file" ref="file" v-on:change="handleFileUpload"/>
            </label>
        </div>

        <div class="form-group">
            <a class="btn btn-primary" v-on:click.prevent="saveUser()">Save</a>
            <a class="btn btn-light" v-on:click.prevent="cancelEdit()">Cancel</a>
        </div>

    </div>
</template>

<script type="text/javascript">


    export default {
        name:"profile",
        props: [
            'currentUser','file'
        ],
        data: function(){
            return {
                /*user: [this.$store.state.user],*/
                successMessage: "",
                showSuccess: false
            }
        },
        methods: {
            getInformationFromLoggedUser() {
                this.currentUser = this.$store.state.user;
            },
            saveUser: function () {
                console.log(this.currentUser);
                this.$emit('user-saved');
            },
            cancelEdit: function () {
                this.$emit('user-canceled');
            },
            handleFileUpload: function (event) {
                this.file= event.target.files[0]; //this.$refs.file.files[0];
            }
        },
        mounted() {
            this.getInformationFromLoggedUser();
        }
    }
</script>