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
    import 'at.js';
    import 'jquery.caret';
    export default {

        data(){
            return {
                body: '',
            }
        },

        mounted() {
            $('#body').atwho({
                at:"@",
                delay:750,
                callbacks: {
                    remoteFilter: function(query, callback) {
                         console.log('called');
//                        $.getJson('user.php', {q : query}, function(usernames){
//                            callback(usernames);
//                        });
                    }
                }
            });
        },

        methods: {
            addReply(){
                axios.post(`${location.pathname}/replies`, {body: this.body})
                    .then(response => {
                        this.body='';
                        flash('Your Reply Successfully posted');
                        this.$emit('created', response.data);
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger');
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
