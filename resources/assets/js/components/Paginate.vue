<template>
    <div class="container">
        <div class="columns">
            <div class="column is-1">
                <strong>{{ pagination.current_page }} of {{ pagination.total_pages }}</strong>
            </div>
            <div class="column-5">
                <button type="button" class="button" :disabled="!canPrev" @click.prevent="changePage('prev')"> Prev
                </button>
            </div>
            <div class="column-5">
                <button type="button" class="button" :disabled="!canNext" @click.prevent="changePage('next')"> Next
                </button>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['pagination'],
        data() {
            return {
                page: 1,

            };
        },
        computed: {
            canPrev() {
                return this.pagination.current_page > 1;
            },
            canNext() {
                return this.pagination.current_page < this.pagination.total_pages;
            },
        },
        methods: {
            //To change the page
            changePage(page) {
                if (page === 'next' && this.canNext) {
                    this.page = this.pagination.current_page + 1;
                }
                if (page === 'prev' && this.canPrev) {
                    this.page = this.pagination.current_page - 1;
                }
                this.$emit('paginate', this.page);
            },
        }
    }
</script>

<style scoped>

</style>