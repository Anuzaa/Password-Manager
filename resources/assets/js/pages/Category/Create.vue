<template>
    <div class="modal is-active">
        <div class="modal-background">
            <form @submit.prevent="create">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Add Category</p>
                    </header>
                    <section class="modal-card-body">
                        <div class="field">
                            <label class="label">Category Name</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="Enter Category Name"
                                       v-model="formData.name"
                                       required>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button type="submit" class="button is-success">Save</button>
                        <router-link to="/categories" button class="button">Cancel</router-link>
                    </footer>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

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
                axios.post('categories', this.formData).then(() => {
                    this.$router.push({name: 'category'});
                });
            }
        }
    }
</script>

<style scoped>

</style>