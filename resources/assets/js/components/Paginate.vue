<template>
    <div class="container" style="margin-top: 16px;">
        <button type="button" @click="prev" :disabled="!canPrev">Prev</button>
        <button type="button" disabled>{{pagination.current}}/{{pagination.total}}</button>
        <button type="button" @click="next" :disabled="!canNext">Next</button>
        <!--<ul class="pagination">-->
        <!--<li v-if="pagination.current_page > 1">-->
        <!--<a href="javascript:void(0)" aria-label="Previous" @click.prevent="prev" :disabled="!canPrev">-->
        <!--<span aria-hidden="true">«</span>-->
        <!--</a>-->
        <!--</li>-->
        <!--<li v-for="page in pagesNumber" :class="{'active': page == pagination.current_page}">-->
        <!--<a href="javascript:void(0)" v-on:click.prevent="changePage(page)">{{ page }}</a>-->
        <!--</li>-->
        <!--<li v-if="pagination.current_page < pagination.last_page">-->
        <!--<a href="javascript:void(0)" aria-label="Next" v-on:click.prevent="changePage(pagination.current_page + 1)">-->
        <!--<span aria-hidden="true">»</span>-->
        <!--</a>-->
        <!--</li>-->
        <!--</ul>-->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                pagination: {
                    total: 5,
                    current: 1,
                },
            };
        },
        computed: {
            canPrev() {
                return this.pagination.current > 1;
            },
            canNext() {
                return this.pagination.current < this.pagination.total;
            },
        },
        methods: {
            prev() {
                if (this.canPrev) {
                    this.pagination.current -= 1;
                }
            },
            next() {
                if (this.canNext) {
                    this.pagination.current += 1;
                }
            }
        }
    }
</script>

<style scoped>

</style>