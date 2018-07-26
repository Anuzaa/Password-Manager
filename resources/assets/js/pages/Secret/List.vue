<template>
    <div id="secret">
        <div class="container">
            <div class="columns">
                <div class="column is-11">
                    <strong>Secrets</strong>

                </div>
                <div class="column is-1">
                    <router-link class="button is-info is-pulled-right " :to="{name:'secret.create'}">
                        Add
                    </router-link>
                </div>
            </div>
            <div class="columns">
                <div class="column is-12">
                    <table class="table is-hoverable is-fullwidth ">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>URL</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Category</th>
                            <th>User</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="secret in secrets.data" :key="secret.id">
                            <td>{{secret.id}}</td>
                            <td>{{secret.url}}</td>
                            <td>{{secret.name}}</td>
                            <td>{{secret.email}}</td>
                            <td v-html="getPassword(secret.id, secret.password)"></td>
                            <td>{{secret.category.data.name}}</td>
                            <td> {{secret.user.data.name}}</td>
                            <td>
                                <button class="button is-white" type="button"
                                        @click="togglePasswordVisibility(secret.id)">

                                    <i class="fa fa-eye"></i>
                                </button>
                                <router-link class="button is-white" type="button"
                                             :to="{name:'secret.edit',params:{id:secret.id}}">
                                    <i class="fas fa-edit"></i>
                                </router-link>
                                <button @click="deleteSecret(secret.id)" class="button is-white">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <router-link class="button is-white" type="button"
                                             :to="{name:'secret.share',params:{id:secret.id}}">
                                    <i class="fas fa-share-square"></i>
                                </router-link>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</template>

<script>

    export default {

        name: "secret-list",
        data() {
            return {
                secrets: {
                    user: {
                        data: {},
                    },
                },
                shownPasswordId: [],
            }
        },
        methods: {
            getPassword(id, password) {
                if (this.isPasswordShown(id)) {
                    return password;
                } else {
                    return '&bull;&bull;&bull;&bull;&bull;&bull;'
                }
            },
            isPasswordShown(id) {
                return this.shownPasswordId.includes(id);
            },
            togglePasswordVisibility(id) {
                if (this.isPasswordShown(id)) {
                    this.shownPasswordId = this.shownPasswordId.filter(pid => pid !== id);
                } else {
                    this.shownPasswordId.push(id)
                }
            },
            deleteSecret(id) {
                if (confirm("Are you sure?")) {
                    window.axios
                        .delete(`secrets/${id}`).then(() => {
                            this.getSecret();
                        }
                    )
                }
            },
            getSecret() {
                window.axios
                    .get('secrets')
                    .then((response) => {
                        this.secrets = response.data
                    })
            },

        },
        mounted() {
            this.getSecret();

        },
    }
</script>

<style scoped>

</style>