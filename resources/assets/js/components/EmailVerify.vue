<template>
    <main>
        <div class="loader">Loading...</div>
    </main>
</template>

<script>
    import Auth from '../common/auth/index';
    export default {
        name: "EmailVerify",

        mounted(){
           const { token } = this.$route.query;
           if (token) {
               Auth.storeToken(token);
               this.$router.push({ name: 'dashboard' });
           } else {
               this.$router.push({ name: 'error' });
           }
        }
    }
</script>

<style scoped>
    main {
        background-color: #12d9e9;
        margin: 0;
        height: 100vh;
        width: 100vw;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loader,
    .loader:before,
    .loader:after {
        background: #fffef1;
        -webkit-animation: load1 1s infinite ease-in-out;
        animation: load1 1s infinite ease-in-out;
        width: 1em;
        height: 4em;
    }
    .loader {
        color: #fffef1;
        text-indent: -9999em;
        position: relative;
        font-size: 11px;
        -webkit-transform: translateZ(0);
        -ms-transform: translateZ(0);
        transform: translateZ(0);
        -webkit-animation-delay: -0.16s;
        animation-delay: -0.16s;
    }
    .loader:before,
    .loader:after {
        position: absolute;
        top: 0;
        content: '';
    }
    .loader:before {
        left: -1.5em;
        -webkit-animation-delay: -0.32s;
        animation-delay: -0.32s;
    }
    .loader:after {
        left: 1.5em;
    }
    @-webkit-keyframes load1 {
        0%,
        80%,
        100% {
            box-shadow: 0 0;
            height: 4em;
        }
        40% {
            box-shadow: 0 -2em;
            height: 5em;
        }
    }
    @keyframes load1 {
        0%,
        80%,
        100% {
            box-shadow: 0 0;
            height: 4em;
        }
        40% {
            box-shadow: 0 -2em;
            height: 5em;
        }
    }
</style>
