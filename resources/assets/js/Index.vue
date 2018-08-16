<template>
    <main>
        <navBar v-if="$route.meta.requiresAuth"></navBar>
        <vue-alert></vue-alert>
        <router-view></router-view>
    </main>
</template>

<script>
    import navBar from './components/NavBar';
    import paginate from './components/Paginate';
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
            paginate
        },

    }
</script>

<style scoped>
    .vue-alert {
        margin-top: 10px;
    }

</style>