<template>
    <form>
        <div class="dropdown-menu">
            <a v-if="this.$store.state.user" class="dropdown-item">{{this.$store.state.user.username}}</a>

            <router-link class="dropdown-item" to="/profile">Editar Perfil</router-link>
<!--
            <a class="dropdown-item" v-on:click.prevent="logout">Editar Perfil</a>
-->
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" v-on:click.prevent="logout">Logout</a>
        </div>
        <div>
            <div class="jumbotron">
                <h2>Confirmar Logout</h2>
                <div class="form-group">
                    <a class="btn btn-primary" ></a>
                </div>
            </div>
        </div>
    </form>
</template>

<script type="text/javascript">    
    export default {
        data: function(){
            return { 
                /*typeofmsg: "alert-success",
                showMessage: false,
                message: ""*/
            }
        },
        methods: {
            logout() {
                this.showMessage = false;
                axios.post('api/logout')
                    .then(response => {
                        this.$store.commit('clearUserAndToken');
                        /*this.typeofmsg = "alert-success";
                        this.message = "User has logged out correctly";
                        this.showMessage = true;*/
                    })
                    .catch(error => {
                        this.$store.commit('clearUserAndToken');
                        /*this.typeofmsg = "alert-danger";
                        this.message = "Logout incorrect. But local credentials were discarded";
                        this.showMessage = true;*/
                        console.log(error);
                    })            
                }
        }
    }
</script>
