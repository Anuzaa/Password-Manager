<template>
    <div class="container">
        <form @submit.prevent="create">
            <div class="columns">
                <div class="column is-11">
                    <strong>Add Category</strong>
                </div>
            </div>
            <div class="columns">
                <div class="column is-half">
                    <div class="field">
                        <label class="label">Category Name</label>
                        <div class="control">
                            <input class="input" type="text"
                                   v-model="formData.name"
                                   required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-11">
                    <div class="field is-grouped">
                        <div class="control">
                            <button type="submit" class="button is-info">Save</button>
                        </div>
                        <div class="control">
                            <router-link to="/categories" button class="button">Cancel</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>


    export default {
        name: "category-create",
        data() {
            return {
                formData: {
                    name: '',
                },

            }

        },
        methods: {
            create() {
                window.axios.post('categories', this.formData).then(() => {
                    this.$router.push({name: 'category'});
                });
            }
        }
    }
</script>

<style scoped>

</style>