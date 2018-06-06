<template>
    <div id="category">

        <div class="panel">
            <div class="panel-heading">Categories</div>
            <div class="panel-block" v-for="category in categories.data" :key="category.id">
               {{category.id}} : {{category.name}}
            </div>
        </div>
    </div>
</template>

<script>


    export default {
        name: "categoryList",
        data() {
            return {
                categories: {},
            }
        },
        mounted() {
            this.$http
                .get('categories')
                .then(response => (this.categories = response.data));

        }
    }
</script>

<style scoped>

</style>