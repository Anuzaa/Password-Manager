<template>
    <div id="secret">
        <div class="container">
            <div class="columns">
                <div class="column is-8">
                    <strong>Secrets</strong>

                </div>
                <div class="column is-3">
                    <div class="control has-icons-left has-icons-right">
                        <input class="input"
                               type="text"
                               placeholder="Search..."
                               @keydown.enter="entered"
                        />
                        <span class="icon is-medium is-left">
                 <i class="fas fa-search"></i>
                    </span>
                    </div>
                </div>
                <div class="column is-1">
                    <router-link class="button is-info is-pulled-right " :to="{name:'secret.create'}">
                        <i class="fas fa-plus"></i>
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
                        <template v-if="hasSecret">
                            <tr v-for="secret in secrets.data" :key="secret.id">
                                <td> {{secret.id}}</td>
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
                                    <button @click="shareSecret(secret.id)" class="button is-white" type="button">
                                        <i class="fas fa-share-square"></i>
                                    </button>
                                    <router-link  class="button is-white" type="button" :to="{name:'secret.detail',params:{id:secret.id}}">
                                        <i class="fas fa-info-circle"></i>
                                    </router-link>
                                </td>
                            </tr>
                        </template>
                        <tr v-else>
                            <td colspan="7" class="has-text-centered"> No matching records found.</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <paginate :pagination="pagination" @paginate="paginate"></paginate>
            <div class="columns" style="height: 100px"></div>
        </div>
    </div>
</template>
<script>
    import Share from './Share.vue';
    import Paginate from '../../components/Paginate.vue';


    const VIEW_NAME = 'my-unique-view-name';

    export default {

        name: "secret-list",
        components:{
            Paginate,
        },
        data() {
            return {
                secrets: {},
                pagination: {},
                shownPasswordId: [],
                showdata: true,
            }
        },
        computed: {
            hasSecret() {
                return this.secrets.data && this.secrets.data.length;
            },
        },
        methods: {
            entered(e) {
                this.getSecret(e.target.value);
            },
            paginate(newPage) {
                this.getSecret('', newPage);
            },

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
                    .then(() => this.$alert.success({message: 'Secret Successfully Deleted'}))
                    .catch(function () {
                        console.log('Clicked on cancel')
                    });
            },
            getSecret(query = '', page = 1) {
                const endpoint = `secrets?keywords=${query}&page=${page}`;
                window.axios
                    .get(endpoint)
                    .then((response) => {
                        this.secrets = response.data;
                        this.pagination = response.data.meta.pagination;
                    })
            },
            shareSecret(id) {
                this.$dialog.confirm('', {
                    view: VIEW_NAME, // can be set globally too
                    html: true,
                    animation: 'fade',
                    backdropClose: true
                }).then((authorId) => {
                    const payload = {
                        author_id: authorId,
                    };
                    window.axios
                        .post(`share/${id}`, payload)
                        .then(() => {
                            this.getSecret();
                        })
                        .then(() => this.$alert.success({message: 'Secret Successfully Shared'}))
                        .catch(() => this.$alert.danger({message: 'Secret Share Failed'}));
                });
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