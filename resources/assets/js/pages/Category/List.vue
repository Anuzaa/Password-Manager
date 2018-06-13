<template>
    <div id="category">

        <div class="panel">
            <div class="panel-heading has-text-centered"><strong>Categories</strong>
                <router-link class="button is-primary is-pulled-right " :to="{name:'category.create'}">
                    Add
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
                                     :to="{name:'category.edit',params:{id:category.id}}">
                            <i class="fas fa-edit"></i>
                        </router-link>
                        <router-link class="button is-white" type="button"
                                     :to="{name:'category.list',params:{id:category.id}}">
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

        name: "category-list",
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

        },
        methods:{
          delete(){

          }
        }
    }
</script>

<style scoped>

</style>