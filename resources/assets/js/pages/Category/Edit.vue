<template>
    <div class="container">
        <form @submit.prevent="update">
            <div class="columns">
                <div class="column is-11">
                    <strong>Edit Category</strong>
                </div>
            </div>
            <div class="columns">
                <div class="column is-11">
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
        name: "edit-category",
        data() {
            return {
                formData: {
                    name: '',
                },
            }
        },

        methods: {
            update() {
                window.axios.put(`categories/${this.$route.params.id}`, this.formData)
                    .then(() => {
                        this.$router.push({name: "category"})
                    })
                    .then(() => this.$alert.success({message:'Category Successfully Updated'}));
            }
        },
        mounted() {
            window.axios
                .get(`categories/${this.$route.params.id}`)
                .then(response => {
                    // console.log(response.data.data.name);
                    this.formData.name = response.data.data.name;
                });


        }

    }
</script>

<style scoped>

</style>