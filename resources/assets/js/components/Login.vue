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
                                <input class="input" v-model="email" type="email" placeholder="Your Email" autofocus="">
                                <span class="icon is-small is-left">
                                  <i class="fas fa-envelope"></i>
                             </span>
                                <span class="icon is-small is-right">
                                   <i class="fas fa-check"></i>
                                </span>
                            </p>
                        </div>


                        <div class="field">
                            <p class="control has-icons-left">
                                <input class="input" v-model="password" type="password" placeholder="Your Password">
                                <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                            </span>
                            </p>

                        </div>

                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox">
                                Remember me
                            </label>
                        </div>
                        <button class="button is-primary  is-medium is-fullwidth" type="submit">Login</button>
                    </form>
                </div>
                <!--<p class="has-text-grey">-->
                <!--<a href="../">Sign Up</a> &nbsp;·&nbsp;-->
                <!--<a href="../">Forgot Password</a> &nbsp;·&nbsp;-->
                <!--<a href="../">Need Help?</a>-->
                <!--</p>-->
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "Login",
        data() {

            return {
                email: '',
                password: '',
                error: false
            }
        },
        methods: {
            login() {
                this.$http.post('/login',
                    {
                        email: this.email,
                        password: this.password
                    })
                    .then(request => this.loginSuccessful(request))
                    .catch(() => this.loginFailed())
            },

            loginSuccessful(req) {
                if (!req.data.token) {
                    this.loginFailed();
                }
                localStorage.token = req.data.token;
                this.error = false;
                this.$router.replace(this.$route.query.redirect || '/categories');
            },
            loginFailed() {
                this.error = 'Login failed';
                delete localStorage.token;
            },

        }
    }
</script>

<style scoped>

</style>