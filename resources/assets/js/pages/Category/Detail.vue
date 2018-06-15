<template>

    <div class="container">
        <br>
        <div class="panel">
            <div class="panel-heading has-text-left">
                <div class="columns">
                    <div class="column is-four-fifths">
                        <strong>{{category.name}}</strong>
                    </div>

                    <div class="column">
                        <router-link to="/categories" class="button is-primary is-pulled-right">Back</router-link>
                    </div>
                </div>
                <small>
                    <div class="panel-body">
                        <div class="column is-half">
                            CategoryID #{{category.id}}
                        </div>
                        <div class="column is-half is-small">
                            UserID #{{category.user.data.id}}
                        </div>
                        <div class="column is-half is-small">
                            User : {{category.user.data.name}}
                        </div>
                        <hr>
                        <small>Created at {{category.created_at.date}}</small>

                    </div>
                </small>
            </div>
        </div>
    </div>


</template>

<script>

    export default {
        name: "category-detail",
        data() {
            return {
                category: {
                    user: {
                        data: {},
                    },
                    created_at: {},
                },
            }
        },
        mounted() {
           window.axios
                .get(`categories/${this.$route.params.id}`)
                .then(response => {
                    this.category = response.data.data;
                });

        }
    }
</script>

<style scoped>

</style>