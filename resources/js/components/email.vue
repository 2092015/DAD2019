<template>
    <div>
        <h1>Please verify that it’s you</h1>
        Foi escolhido para trabalhar no Restaurant por favor aceda ao link abaixo para confirmar o seu email.
        <a href="http://restaurant.test/api/confirm/">Clique aqui para confirmar o seu email.</a>
    </div>
</template>

<script>
    export default {
        name: "email",
        props: [
            'currentUser','editingUser','usersTypes'
        ],
    }
</script>

<style scoped>

</style>
