<script>
    export default {
        props: ['reply'],

        data() {
            return {
                favoritesCount: this.reply.favoritesCount,
            }
        },

        methods: {
            toggle() {
                if (isFavorited) {
                    //unfavorite
                    axios.delete('/replies/' + this.reply.id + '/favorites');
                } else {
                    axios.post('/replies/' + this.reply.id + '/favorites');
                }
            },
        }
    }
</script>

<template>
    <button type="submit" class="btn btn-default" @click="toggle">
        <span class="glyphicon glyphicon-heart"></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>