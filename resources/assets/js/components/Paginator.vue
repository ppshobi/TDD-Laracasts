<template>
    <ul class="pagination" v-if="shouldPaginate">
        <li v-show="prevUrl">
            <a href="#" aria-label="Previous" rel="prev">
                <span aria-hidden="true">&laquo; Previous</span>
            </a>
        </li>
        <li v-show="nextUrl">
            <a href="#" aria-label="Next" rel="next">
                <span aria-hidden="true">Next &raquo; </span>
            </a>
        </li>
    </ul>
</template>

<script>
    export default {

        props: ['dataSet'],

        data() {
            return{
                page: 1,
                nextUrl: false,
                prevUrl: false,
            };
        },

        computed: {
            shouldPaginate(){
                return this.prevUrl || this.nextUrl;
            },
        },

        watch:{
            dataSet(){
                this.page    = this.dataSet.current_page;
                this.nextUrl = this.dataSet.next_page_url;
                this.prevUrl = this.dataSet.prev_page_url;
            },
        }
    }
</script>
