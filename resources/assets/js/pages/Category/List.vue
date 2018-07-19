<template>
    <div id="category">
        <div class="container">
            <div class="columns">
                <div class="column is-11">
                    <strong>Categories</strong>

                </div>
                <div class="column is-1">
                    <router-link class="button is-info is-pulled-right " :to="{name:'category.create'}">
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
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="category in categories.data" :key="category.id">
                            <td>{{category.id}}</td>
                            <td>{{category.name}}</td>
                            <td>
                                <router-link class="button is-white" type="button"
                                             :to="{name:'category.detail',params:{id:category.id}}">
                                    <i class="fa fa-eye"></i>
                                </router-link>
                                <router-link class="button is-white" type="button"
                                             :to="{name:'category.edit',params:{id:category.id}}">
                                    <i class="fas fa-edit"></i>
                                </router-link>
                                <button @click="deleteCategory(category.id)" class="button is-white">
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

        name: "category-list",
        data() {
            return {
                categories: {},
                added: true,
            }
        },
        methods: {
            deleteCategory(id) {
                if (confirm("Are you sure?")) {
                    window.axios
                        .delete(`categories/${id}`).then(() => {
                            this.getCategory();


                        }
                    )
                }
            },
            getCategory() {

                window.axios
                    .get('categories')
                    .then((response) => {

                        this.categories=response.data
                        // console.log(response.data)
                    })
                    .catch(error =>{
                        console.log(error);
                    })
                    // .then((response) => {
                    //     console.log(response.data)
                    // })



            },
        },
        mounted() {

            this.getCategory();
        },
    }
</script>

<style scoped>

</style>