<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
            <textarea name="body"
                      id="body"
                      rows="5"
                      class="form-control"
                      placeholder="Say Something"
                      required
                      v-model="body">
            </textarea>
            </div>
            <button class="btn btn-default" type="submit" @click="addReply"> Post</button>
        </div>


        <p class="text-center" v-else>
            <a href="/login">Sign in</a> to post Comments
        </p>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                body: '',
                endpoint:'/threads/rerum/26/replies',
            }
        },

        methods: {
            addReply(){
                axios.post(this.endpoint, {body: this.body})
                    .then(response => {
                        this.body='';

                        flash('Your Reply has been Posted');
                        this.$emit('created', response.data);
                    });
            },
        },

        computed:{
            signedIn(){
                return window.App.signedIn;
            }
        }
    }
</script>
