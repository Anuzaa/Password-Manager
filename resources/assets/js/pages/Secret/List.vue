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
                                <button @click="deleteSecret(secret.id)" class="button is-white" type="button">
                                    <i class="fa fa-trash"></i>
                                </button>
                                <button @click="showUser" class="button is-white" type="button">
                                    <i class="fas fa-share-square"></i>
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
    import Share from './Share.vue';

    const VIEW_NAME = 'my-unique-view-name';

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
                this.$dialog.confirm('Are you sure?')
                    .then(() => {
                        window.axios
                            .delete(`secrets/${id}`).then(() => {
                            this.getSecret();
                        });
                    })
                    .then(() => this.$alert.success({message:'Secret Successfully Deleted'}))
                    .catch(function () {
                        console.log('Clicked on cancel')
                    });
            },
            getSecret() {
                window.axios
                    .get('secrets')
                    .then((response) => {
                        this.secrets = response.data
                    })
            },
            showUser(id) {
                // Note: Use confirm instead of alert if you need to handle rejection
                this.$dialog.confirm('', {
                    view: VIEW_NAME, // can be set globally too
                    html: true,
                    animation: 'fade',
                    backdropClose: true
                }).then(() => {
                    window.axios
                        .post(`share/`, this.formData)
                        .then(() => {
                            this.$router.push({name: "secret"})
                        })
                        .then(() => this.$alert.success({message: 'Secret Successfully Shared'}));
                }).catch(() => {
                    console.log('catch');
                })
            },
        },
        mounted() {
            this.getSecret();
            this.$dialog.registerComponent(VIEW_NAME, Share);
        },
    }
</script>

<style scoped>

</style>