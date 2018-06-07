<template>
    <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <router-link :to="{name:'home'}" class="navbar-item"> Home</router-link>
        </div>
        <div class="navbar-end">
            <router-link :to="{name:'login'}" class="navbar-item"> Login</router-link>
            <router-link :to="{name:'register'}" class="navbar-item"> Register</router-link>
            <a href="#" @click.prevent="$auth.logout()">Logout</a>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "navBar",
    }
</script>

<style scoped>

</style>