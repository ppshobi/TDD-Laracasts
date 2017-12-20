<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>

        <new-reply @created="add" :endpoint="endpoint"></new-reply>
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
                endpoint: location.pathname + '/replies',
            };
        },

        created(){
            this.fetch();
        },

        methods: {

            fetch() {
                axios.get(this.url())
                    .then(this.refresh);
            },

            url() {
                return `${location.pathname}/replies`;
            },

            refresh(response) {
                console.log(response);
            },

            remove(index) {
                this.items.splice(index, 1);
                this.$emit('removed');
                flash('Reply Deleted');
            },

            add(reply){
                this.items.push(reply);
                this.$emit('added');
            },
        }
    }
</script>