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
                    <div class="field has-addons">
                        <div class="control">
                            <input class="input" type="text" placeholder="Find a repository">
                        </div>
                        <div class="control">
                            <a class="button is-info">
                                Search
                            </a>
                        </div>
                    </div>
                    <a class="navbar-item" @click.prevent="logout">Logout</a>
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