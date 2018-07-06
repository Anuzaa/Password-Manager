<template>
    <main>
        <navBar v-if="$route.meta.requiresAuth"></navBar>

        <router-view></router-view>
    </main>
</template>

<script>
    import 'bulma';
    import navBar from './components/NavBar';
    import EmailVerify from "./components/EmailVerify";


    export default {
        name: 'Index',
        data() {
            return {
                loggedIn: true,
                loaded: false
            };
        },
        components: {

            navBar,
        },
    }
</script>

<style scoped>

</style>