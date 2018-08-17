<template>
    <div id="category">
        <div class="container">
            <div class="columns">
                <div class="column is-8">
                    <strong>Categories</strong>
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
                    <router-link :to="{ name: 'category.create' }" class="button is-info is-pulled-right" tag="button"
                                 type="button">
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
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-if="categories.data && categories.data.length">
                        <tr v-for="category in categories.data" :key="category.id">
                            <td>{{category.id}}</td>
                            <td>{{category.name}}</td>
                            <td>
                                <router-link class="button is-white" tag="button" type="button"
                                             :to="{name:'category.detail',params:{id:category.id}}">
                                    <i class="fa fa-eye"></i>
                                </router-link>
                                <router-link class="button is-white" tag="button" type="button"
                                             :to="{name:'category.edit',params:{id:category.id}}">
                                    <i class="fas fa-edit"></i>
                                </router-link>
                                <button type="button" @click="deleteCategory(category.id)" class="button is-white">
                                    <i class="fa fa-trash"></i>
                                </button>
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
        </div>
    </div>
</template>

<script>
    import Paginate from '../../components/Paginate.vue';
    export default {
        name: "category-list",
        components:{
          Paginate
        },
        data() {
            return {
                categories: {},
                pagination: {},
                added: true,
            };
        },
        methods: {
            entered(e) {
                this.getCategory(e.target.value);
            },
            paginate(newPage) {
                this.getCategory('', newPage);
            },
            deleteCategory(id) {
                this.$dialog.confirm('Are you sure?')
                    .then(() => {
                        window.axios
                            .delete(`categories/${id}`).then(() => {
                            this.getCategory();
                        });
                    })

                    .catch(function () {
                        console.log('Clicked on cancel')
                    });
            },
            getCategory(query = '',page=1) {
                const endpoint = `categories?keywords=${query}&page=${page}`;
                window.axios
                    .get(endpoint)
                    .then((response) => {
                        this.categories = response.data;
                        this.pagination = response.data.meta.pagination;

                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
        },
        mounted() {
            this.getCategory();
        },
    };
</script>

<style scoped>

</style>
