<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>

        <new-reply></new-reply>
    </div>
</template>

<script>
    import Reply from "./Reply.vue";
    import NewReply from './NewReply.vue';

    export default {

        components: {Reply, NewReply},

        data() {
            return {
                items: [],
            };
        },

        created(){
            this.fetch();
        },

        methods: {

            fetch(){
                axios.get(this.url())
                    .then(this.refresh)
            },

            url(){

            },

            refresh(response){

            },

            remove(index){
                this.items.splice(index, 1);
                this.$emit('removed');
                flash('Reply Deleted');
            }
        }
    }
</script>