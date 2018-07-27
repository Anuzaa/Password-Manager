<template>
    <div class="container">
        <form @submit.prevent="share">
            <div class="columns">
                <div class="column is-11">
                    <strong>Share Secret</strong>
                </div>
            </div>
            <div class="columns">
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Select User</label>
                        <select class="form-control" v-model="formData.author_id">
                            <option disabled value=''>Please select one</option>
                            <option v-for="user in users.data" v-bind:value="user.id">
                                {{ user.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-11">
                    <div class="field is-grouped">
                        <div class="control">
                            <button type="submit" class="button is-info">Send</button>
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
        name: "share-secret",
        data() {
            return {
                users: [],
                formData: {
                    author_id: '',
                },
            }

        },
        methods: {
            getUser() {
                window.axios
                    .get('users')
                    .then((response) => {
                        this.users = response.data
                    })
            },

            share() {
                window.axios
                    .post(`share/${this.$route.params.id}`, this.formData)
                    .then(() => {
                        this.$router.push({name: "secret"})
                    })
            }
        },
        mounted() {
            this.getUser();
        }
    }
</script>

<style scoped>

</style>