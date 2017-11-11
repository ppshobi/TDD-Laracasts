<script>
    export default {
        data() {
            return {
                favoritesCount: 10,
            }
        }
    }
</script>

<template>
    <button type="submit" class="btn btn-default">
        <span class="glyphicon glyphicon-heart"></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>