<template>
    <div class="container">
        <form @submit.prevent="create">
            <div class="columns">
                <div class="column is-11">
                    <strong>Add Secret</strong>
                </div>
            </div>
            <div class="columns">
                <div class="column is-half">
                    <div class="field">
                        <label class="label">URL</label>
                        <div class="control">
                            <input class="input" type="text"
                                   v-model="formData.url"
                                   required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control">
                            <input class="input" type="text"
                                   v-model="formData.name"
                                   required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input" type="email"
                                   v-model="formData.email"
                                   required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input" type="password"
                                   v-model="formData.password"
                                   required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-half">
                    <label class="label">Category</label>
                    <v-select label="name" :options="categories" v-model="selectedCategory">
                    </v-select>
                </div>
            </div>
            <div class="columns">
                <div class="column is-11">
                    <div class="field is-grouped">
                        <div class="control">
                            <button type="submit" class="button is-info">Save</button>
                        </div>
                        <div class="control">
                            <router-link to="/secrets" button class="button">Cancel</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "secret-create",
        data() {
            return {
                categories: [],
                selectedCategory: '',
                formData: {
                    url: '',
                    name: '',
                    email: '',
                    password: '',
                    category_id: '',
                },

            }

        },
        methods: {
            create() {
                this.formData.category_id = this.selectedCategory.id;
                window.axios.post('secrets', this.formData).then(() => {
                    this.$router.push({name: 'secret'});
                })
                    .then(() => this.$alert.success({message: 'Secret Successfully created'}));


            },
            getCategory() {
                window.axios
                    .get('categories')
                    .then(response => {
                        this.categories = response.data.data;

                    });


            },
        },
        mounted() {
            this.getCategory();
        },
    }

</script>

<style scoped>

</style>