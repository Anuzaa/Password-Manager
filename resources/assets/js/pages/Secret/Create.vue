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
                    <div class="field" :class="{'is-danger': errors.has('url')}">
                        <label class="label">URL <span class="is-danger">*</span></label>
                        <div class="control">
                            <input class="input" type="text" name="url" placeholder="Enter URL"
                                   v-model="formData.url"
                                   v-validate="'url:require_protocol'">
                            <p class="help is-danger" v-if="errors.has('url')">{{errors.first('url')}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-half">
                    <div class="field" :class="{'is-danger': errors.has('name')}">
                        <label class="label">Name <span class="is-danger">*</span></label>
                        <div class="control">
                            <input class="input" type="text" name="name" placeholder="Enter name"
                                   v-model="formData.name"
                                   v-validate="'required'">
                            <p class="help is-danger" v-if="errors.has('name')">{{errors.first('name')}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-half">
                    <div class="field" :class="{'is-danger': errors.has('email')}">
                        <label class="label">Email <span class="is-danger">*</span></label>
                        <div class="control">
                            <input class="input" type="email" name="email" placeholder="Enter email"
                                   v-model="formData.email" v-validate="'required|email'">
                            <p class="help is-danger" v-if="errors.has('email')">{{errors.first('email')}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-half">
                    <div class="field" :class="{'is-danger': errors.has('password')}">
                        <label class="label">Password <span class="is-danger">*</span></label>
                        <div class="control">
                            <input class="input" type="password" name="password" placeholder="Enter password"
                                   v-model="formData.password" v-validate="'required|max:6'">
                            <p class="help is-danger" v-if="errors.has('password')">{{errors.first('password')}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column is-half">
                    <label class="label">Category</label>
                    <v-select label="name" :options="categories" v-model="selectedCategory"
                              placeholder="Choose category">
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
                this.$validator.validateAll().then(() => {
                    if (!this.errors.any()) {
                        this.formData.category_id = this.selectedCategory.id;
                        window.axios.post('secrets', this.formData).then(() => {
                            this.$router.push({name: 'secret'});
                        })
                            .then(() => this.$alert.success({message: 'Secret Successfully created'}));
                    }
                })
        },
        getCategory() {
            window.axios
                .get('categories')
                .then(response => {
                    this.categories = response.data.data;
                });
        },
    }
    ,
    mounted()
    {
        this.getCategory();
    }
    ,
    }

</script>

<style scoped>

</style>