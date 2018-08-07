<template>
    <div class="container">
        <form @submit.prevent="share">
            <div class="columns">
                <div class="column is-11">
                    <strong>Share Secret</strong>
                </div>
            </div>
            <div class="columns">
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Select User</label>
                        <v-select label="name" :options="users" v-model="selectedUser">
                        </v-select>

                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-11">
                    <div class="field is-grouped">
                        <div class="control">
                            <button type="submit" class="button is-info">Send</button>
                        </div>
                        <div class="control">
                            <button class="button" type="button" @click.prevent="handleDismiss">Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</template>

<script>
    import DialogMixin from 'vuejs-dialog/dist/vuejs-dialog-mixin.min'


    export default {
        mixins: [DialogMixin],
        name: "share-secret",
        data() {
            return {
                users: [],
                selectedUser: '',
            }

        },
        methods: {
            getUser() {
                window.axios
                    .get('users')
                    .then((response) => {
                        this.users = response.data.data;
                    })
            },

            share() {
                return this.proceed(this.selectedUser.id);
            },
            handleDismiss() {
                this.cancel();
            },
        },
        mounted() {
            this.getUser();
        }
    }
</script>

<style scoped>

</style>