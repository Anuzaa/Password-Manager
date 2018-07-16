<template>
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h3 class="title has-text-grey">Login</h3>
                <p class="subtitle has-text-grey">Please login to proceed.</p>
                <div class="alert alert-danger" v-if="error">{{ error }}</div>

                <div class="box">

                    <form class="form-signin" @submit.prevent="login">
                        <div class="field has-addons">
                            <p class="control">
                                <input class="input" v-model="name" type="text" placeholder="Your email">
                            </p>
                            <p class="control">
                                <a class="button is-static">
                                    @introcept.co
                                </a>
                            </p>
                        </div>
                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox">
                                Remember me
                            </label>
                        </div>
                        <button class="button is-info  is-medium is-fullwidth" type="submit">Send Magic Link</button>

                    </form>
                </div>
                <div class="alert alert-danger" v-if="emailsent">{{ emailsent}}</div>
            </div>
        </div>
    </div>

</template>

<script>
    import Auth from '../common/auth/index';

    export default {
        name: "Login",
        data() {
            return {
                name: 'anuja.bhattarai',
                domain: '@introcept.co',
                error: false,
                emailsent: false,
            };
        },
        computed: {
            email: function () {
                return this.name + '' + this.domain;
            },
        },
        methods: {
            login() {
                const email = this.email;
                Auth.attempt({email}).then(() => {
                    this.emailsent = "Please Check your email";
                })
                    .catch(() => {
                        this.error = "Login failed";
                    });
            }
        }

    }
</script>

<style scoped>

</style>