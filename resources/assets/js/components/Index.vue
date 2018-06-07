<template>
    <main>
        <nav-bar></nav-bar>
        <div class="panel">
            <router-view></router-view>
        </div>
    </main>
</template>

<script>
    import 'bulma';
    import navBar from './NavBar';


    export default {
        name: 'Index',
        components: {
            navBar
        }
    }
</script>

<style scoped>

</style>