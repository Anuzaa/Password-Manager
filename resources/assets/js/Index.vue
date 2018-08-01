<template>
    <main>
        <navBar v-if="$route.meta.requiresAuth"></navBar>
        <router-view></router-view>
    </main>
</template>

<script>
    import navBar from './components/NavBar';
    import 'bulma';

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