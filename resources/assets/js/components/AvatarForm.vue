<template>
<div>
    <h1 v-text="user.name"></h1>
        <form v-if="canUpdate" method="post" enctype="multipart/form-data">
            <input type="file" name="avatar" accept="image/*"/>
            <button type="submit" class="btn btn-primary"> Add Avatar</button>
        </form>
    <img :src="avatar" width="200" height="200"/>
</div>
</template>

<script>
    export default {
        props: ['user'],
        data(){
            return {
                avatar: '',
            }
        },
        computed: {
            canUpdate(){
                return this.authorize(user => user.id === this.user.id);
            }
        }
    }
</script>