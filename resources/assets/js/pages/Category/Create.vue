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
                        <label class="label">Category Name <span class="is-danger">*</span></label>
                        <div class="control">
                            <input class="input" type="text" name="name"
                                   v-model="formData.name" placeholder="Enter category name"
                                   v-validate="'required'">
                            <p class="help is-danger" v-if="errors.has('name')">{{errors.first('name')}}</p>
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
                            <router-link to="/categories" tag="button" type="button" class="button">Cancel</router-link>
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
                window.axios.post('categories', this.formData)
                    .then(() => this.$router.push({name: 'category'}))
                    .then(() => this.$alert.success({message: 'Category Successfully Added'}));
            }
        }
    }
</script>

<style scoped>
</style>
