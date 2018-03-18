<template>
<div>
    <h1 v-text="user.name"></h1>
        <form v-if="canUpdate" method="post" enctype="multipart/form-data">
            <image-upload name="avatar" @loaded="onLoad"></image-upload>
            <button type="submit" class="btn btn-primary"> Add Avatar</button>
        </form>
    <img :src="avatar" width="200" height="200"/>
</div>
</template>

<script>
    import ImageUpload from './ImageUpload.vue';
    export default {
        props: ['user'],
        components: { ImageUpload },
        data(){
            return {
                avatar: this.user.avatar_path,
            }
        },
        methods: {
            onLoad(avatar) {
                this.avatar = avatar.src;
                this.persist(avatar.file);
            },

            persist(avatar) {
                let data= new FormData();
                data.append('avatar', avatar);
                axios.post(`/api/users/${this.user.name}/avatar`, data)
                .then(()=>{
                    flash('Avatar Uploaded');
                });
            }
        },
        computed: {
            canUpdate(){
                return this.authorize(user => user.id === this.user.id);
            }
        }
    }
</script>