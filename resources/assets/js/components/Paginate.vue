<template>
    <div>
        <ul>
            <li v-for="p in paginatedData">
                {{p.first}}
                {{p.last}}
                {{p.suffix}}
            </li>
        </ul>
        <button @click="prevPage">
            Previous
        </button>
        <button @click="nextPage">
            Next
        </button>
    </div>
</template>

<script>
    export default {
        name: "Paginate",
        props: {
            listData: {
                type: Array,
                required: true
            },
            size:{
                type:Number,
                required:false,
                default:10
            }
        },

        data() {
            return {
                pageNumber: 1,
                prevUrl: false,
                nextUrl: false
            }

        },
        methods:{
            nextPage(){
                this.pageNumber++;
            },
            prevPage(){
                this.pageNumber--;
            }
        },
        computed: {
            pageCount(){
                let l = this.listData.length,
                    s = this.size;
                return Math.floor(l/s);
            },
            paginatedData(){
                const start = this.pageNumber * this.size,
                    end = start + this.size;
                return this.listData.slice(start, end);
            }

        }
    }
</script>

<style scoped>

</style>