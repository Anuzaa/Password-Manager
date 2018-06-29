<template>
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-4 is-offset-4">
                <h3 class="title has-text-grey">Login</h3>
                <p class="subtitle has-text-grey">Please login to proceed.</p>
                <div class="alert alert-danger" v-if="error">{{ error }}</div>

                <div class="box">

                    <form class="form-signin" @submit.prevent="login">
                        <div class="field">
                            <p class="control has-icons-left has-icons-right">
                                <input class="input" v-model="credentials.email" type="email" placeholder="Your Email"
                                       autofocus="">
                                <span class="icon is-small is-left">
                                  <i class="fas fa-envelope"></i>
                             </span>
                                <span class="icon is-small is-right">
                                   <i class="fas fa-check"></i>
                                </span>
                            </p>
                        </div>
                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox">
                                Remember me
                            </label>
                        </div>
                        <button class="button is-primary  is-medium is-fullwidth" type="submit">Send Magic Link</button>

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
                credentials: {
                    email: 'bb@gmail.com',
                },
                error: false,
                emailsent: false,
            };
        },
        methods: {
            login() {
                Auth.attempt(this.credentials).then(() => {
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