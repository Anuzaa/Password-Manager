<template>
    <div class="container">
        <form @submit.prevent="update">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">Edit Category</p>
                </header>
                <section class="card-body">
                    <div class="field">
                        <label class="label">Category Name</label>
                        <div class="control">
                            <input class="input" type="text" placeholder="Enter Category Name"
                                   v-model="formData.name"
                                   required>
                        </div>
                    </div>
                </section>
                <footer class="card-footer">
                    <button type="submit" class="button is-success">Save</button>
                    <router-link to="/categories" button class="button">Cancel</router-link>
                </footer>
            </div>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';

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
                axios.put(`categories/${this.$route.params.id}`)
                    .then(response => {
                        this.formData = response.data.data;
                    });
            }
        }

    }
</script>

<style scoped>

</style>