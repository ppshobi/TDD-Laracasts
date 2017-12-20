<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>
    </div>
</template>

<script>
    import Reply from "./Reply";

    export default {

        components: {Reply},

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
                axios.get(this.url)
                    .then(this.refresh)
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