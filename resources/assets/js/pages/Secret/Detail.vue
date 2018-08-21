<template>
    <div class="container">
        <br>
        <div class="panel">
            <div class="panel-heading has-text-left">
                <div class="columns">
                    <div class="column is-four-fifths">
                        <strong>{{secret.name}}</strong>
                    </div>

                    <div class="column">
                        <router-link to="/secrets" class="button is-info is-pulled-right">Back</router-link>
                    </div>
                </div>
                <small>
                    <div class="panel-body">
                        <div class="column is-half">
                           <strong>{{secret.url}}</strong>
                        </div>
                        <div class="column is-half is-small">
                            Email : {{secret.name}}
                        </div>
                        <div class="column is-half is-small">
                           Author : {{secret.user.data.name}}
                        </div>
                        <div class="column is-half is-small">
                            Shared with <li>{{secret.sharedUser}}</li>
                        </div>
                        <hr>
                        <small>Created at {{secret.created_at.date}}</small>

                    </div>
                </small>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "secret-detail",
        data() {
            return {
                secret: {
                    user: {
                        data: {},
                    },
                    created_at: {},
                },
            }
        },
        mounted() {
            window.axios
                .get(`secrets/${this.$route.params.id}`)
                .then(response => {
                    this.secret= response.data.data;
                });

        }
    }
</script>

<style scoped>

</style>