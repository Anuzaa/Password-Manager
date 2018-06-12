<template>
    <div id="category">

        <div class="panel">
            <div class="panel-heading has-text-centered"><strong>Categories</strong>
                <router-link to="/category/create" class="is-pulled-right">
                    <a class="button is-primary" >Add</a>
                </router-link>
            </div>
            <br>

        </div>
        <div class="container">
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
                                     :to="{name:'category.detail',params:{id:category.id}}">
                            <i class="fa fa-trash"></i>
                        </router-link>
                    </td>

                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>


    export default {

        name: "List",
        data() {
            return {
                categories: {},
            }
        },
        mounted() {
            window.axios
                .get('categories')
                .then(response => {
                    this.categories = response.data
                });

        }
    }
</script>

<style scoped>

</style>