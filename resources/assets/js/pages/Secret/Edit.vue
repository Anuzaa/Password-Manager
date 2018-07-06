<template>
    <div class="container">
        <form @submit.prevent="update">
            <div class="columns">
                <div class="column is-11">
                    <strong>Edit Secret</strong>
                </div>
            </div>
            <div class="columns">
                <div class="column is-11">
                    <div class="field">
                        <label class="label">URL</label>
                        <div class="control">
                            <input class="input" type="text"
                                   v-model="formData.url"
                                   required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-11">
                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control">
                            <input class="input" type="text"
                                   v-model="formData.name"
                                   required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-11">
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input" type="email"
                                   v-model="formData.email"
                                   required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-11">
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input" type="password"
                                   v-model="formData.password"
                                   required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-11">
                    <div class="field is-grouped">
                        <div class="control">
                            <button type="submit" class="button is-info">Save</button>
                        </div>
                        <div class="control">
                            <router-link to="/secrets" button class="button">Cancel</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "edit-secret",
        data() {
            return {
                formData: {
                    url: '',
                    name: '',
                    email: '',
                    password: ''
                },
            }
        },
        methods: {
            update() {
                window.axios.put(`secrets/${this.$route.params.id}`, this.formData)
                    .then(() => {
                        this.$router.push({name: "secret"})
                    });
            }
        },
        mounted() {
            window.axios
                .get(`secrets/${this.$route.params.id}`)
                .then(response => {
                    // console.log(response.data.data.name);
                    this.formData.url = response.data.data.url;
                    this.formData.name = response.data.data.name;
                    this.formData.email = response.data.data.email;
                    this.formData.password = response.data.data.password;
                });

        }


    }
</script>

<style scoped>

</style>