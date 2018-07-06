<template>
    <div class="columns">
        <div class="column is-12">
            <nav class="navbar is-info" role="navigation" aria-label="main navigation">
                <div class="navbar-brand">
                    <router-link :to="{name:'dashboard'}" class="navbar-item"> Home</router-link>
                </div>
                <div class="navbar-brand">
                    <router-link :to="{name:'category'}" class="navbar-item">Category</router-link>
                </div>
                <div class="navbar-brand">
                    <router-link :to="{name:'secret'}" class="navbar-item">Secret</router-link>
                </div>
                <div class="navbar-end">
                    <a href="#" class="navbar-item" @click.prevent="logout">Logout</a>
                </div>
            </nav>
        </div>
    </div>
</template>

<script>
    import Auth from '../common/auth/index';

    export default {
        name: "navBar",
        methods: {
            logout() {
                Auth.logout();
                this.$router.push({name: 'login'});
            }
        }
    }
</script>

<style scoped>

</style>