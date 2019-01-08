<template>
    <form class="dropdown-menu p-4 dropdown-menu-right" name="verifingUser">
        <div v-if="!this.$store.state.user">
            <h2>Login</h2>
            <div class="alert" :class="typeofmsg" v-if="showMessage">
                <button type="button" class="close-btn" v-on:click="showMessage=false">&times;</button>
                <strong>{{ message }}</strong>
            </div>
            <div class="form-group">
                <label for="exampleDropdownFormEmail2">Email address</label>
                <input v-model.trim="user.email" type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com">
            </div>
            <div class="form-group">
                <label for="exampleDropdownFormPassword2">Password</label>
                <input v-model="user.password" type="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Password">
            </div>
            <!--<div class="form-check">
                <input type="checkbox" class="form-check-input" id="dropdownCheck2">
                <label class="form-check-label" for="dropdownCheck2">
                    Remember me
                </label>
            </div>-->
            <button type="submit" class="btn btn-primary"  v-on:click.prevent="login">Login</button>
        </div>
        <div v-if="this.$store.state.user">

            <a class="dropdown-item">
                <img :src='this.$store.state.user.photo_url' />
                {{this.$store.state.user.username}}
            </a>

            <router-link class="dropdown-item" to="/profile">Edit Profile</router-link>

            <div class="dropdown-divider"></div>

            <a v-if="this.$store.state.user.shift_active" class="dropdown-item">
                <label>Shift started at:</label>
                <p>
                    {{this.$store.state.user.last_shift_start}}
                </p>
                <label>Time Enlapsed:</label>
                {{this.timeEnlapsed.hours}}:{{this.timeEnlapsed.minutes}}:{{this.timeEnlapsed.seconds}}
            </a>

            <a v-if="!this.$store.state.user.shift_active" class="dropdown-item">
                <label>Shift ended at:</label>
                <p>
                    {{this.$store.state.user.last_shift_end}}
                </p>
            </a>

            <button v-if="!this.$store.state.user.shift_active" v-on:click.prevent="startShift()" class="btn btn-dark">
                Start Shift
            </button>

            <button v-if="this.$store.state.user.shift_active" v-on:click.prevent="endShift()" class="btn btn-dark">
                End Shift
            </button>

            <div class="dropdown-divider"></div>

            <a class="dropdown-item" v-on:click.prevent="logout">Logout</a>
        </div>
    </form>
</template>

<script type="text/javascript">

    import profile from './profile.vue';
    export default {
        data: function(){
            return { 
                user: {
                    email:"",
                    password:"",
                    users: this.$store.state.user
                },
                timeEnlapsed: {
                    hours:0,
                    minutes:0,
                    seconds:0,
                    intervalId:null
                },
                typeofmsg: "alert-success",
                showMessage: false,
                message: "",
            }
        },
        component:{
            'profile': profile,
        },

        methods: {
            login() {
                this.showMessage = false;
                axios.post('api/login', this.user)
                    .then(response => {
                        this.$store.commit('setToken',response.data.access_token);
                        return axios.get('api/users/me');
                    })
                    .then(response => {
                        this.$store.commit('setUser',response.data.data);
                        this.typeofmsg = "alert-success";
                        this.message = "User authenticated correctly";
                        this.showMessage = true;
                    })
                    .catch(error => {
                        this.$store.commit('clearUserAndToken');
                        this.typeofmsg = "alert-danger";
                        this.message = "Invalid credentials";
                        this.showMessage = true;
                        console.log(error);
                    })
            },
            logout() {
                this.showMessage = false;
                axios.post('api/logout')
                    .then(response => {
                        this.$store.commit('clearUserAndToken');
                        this.$router.push({path:'/'});

                    })
                    .catch(error => {
                        this.$store.commit('clearUserAndToken');

                        console.log(error);
                    })
            },
            startShift(){
                axios.get('api/users/startShift')
                    .then(response => {
                        this.$store.commit('setUser',response.data.data);
                        this.timeEnlapsed.interval = setInterval(() => this.countTime(), 1000);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            endShift(){
                axios.get('api/users/endShift')
                    .then(response => {
                        this.$store.commit('setUser',response.data.data);
                        clearInterval(this.timeEnlapsed.intervalId);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            countTime(){
                this.timeEnlapsed.seconds++;
                if(this.timeEnlapsed.seconds==60){
                    this.timeEnlapsed.seconds=0;
                    this.timeEnlapsed.minutes++;
                }
                if(this.timeEnlapsed.minutes==60){
                    this.timeEnlapsed.hours++;
                }
            }
        },
    }
</script>

<style scoped>
    img {
        width: 30px;
    }
    .btn-dark{
        margin: 0.25rem 1.5rem;
    }
</style>
