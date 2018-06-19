<template>
    <div id="secret">
        <div class="container">
            <div class="columns">
                <div class="column is-11">
                    <strong>Secrets</strong>

                </div>
                <div class="column is-1">
                    <router-link class="button is-primary is-pulled-right " :to="{name:'secret.create'}">
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
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="secret in secrets.data" :key="secret.id">
                            <td>{{secret.id}}</td>
                            <td>{{secret.url}}</td>
                            <td>{{secret.name}}</td>
                            <td>{{secret.email}}</td>
                            <td>{{secret.password}}</td>
                            <td>
                                <router-link class="button is-white" type="button"
                                             :to="{name:'secret.detail',params:{id:secret.id}}">
                                    <i class="fa fa-eye"></i>
                                </router-link>
                                <router-link class="button is-white" type="button"
                                             :to="{name:'secret.edit',params:{id:secret.id}}">
                                    <i class="fas fa-edit"></i>
                                </router-link>
                                <button @click="deleteSecret(secret.id)" class="button is-white">
                                    <i class="fa fa-trash"></i>
                                </button>
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
                secrets: {},

            }
        },

        methods: {
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
                    .then(response => {
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