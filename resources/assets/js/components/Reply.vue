<template>
    <div :id="'reply-'+id" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a href="'/profiles/' + data.owner.name" v-text="data.owner.name">
                    </a> said <span v-text="ago"></span>
                </h5>
                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div v-if="editing">
                <form @submit="update">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body" required></textarea>
                    </div>

                    <button class="btn btn-xs btn-primary">Update</button>
                    <button class="btn btn-xs btn-link" type="button" @click="editing=false ">Cancel</button>
                </form>
            </div>

            <div v-else v-html="body"></div>
        </div>
        <!--@can('update', $reply)-->
            <div class="panel-footer level" v-if="canUpdate">
                <button class="btn btn-xs mr-1" @click="editing = true">Edit</button>
                <button class="btn btn-xs btn-danger" @click="destroy">Delete</button>
            </div>
        <!--@endcan-->
    </div>
</template>
<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['data'],

        components: {Favorite},

        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body,
            };
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                }).then(response => {
                    flash('Reply Updated');
                }).catch(error => {
                    flash(error.response.data, 'danger')
                });

                this.editing = false;

            },

            destroy() {
                axios.delete('/replies/' + this.data.id);
                this.$emit('deleted', this.data.id);
            }
        },

        computed:{
            ago(){
                return moment(this.data.created_at).fromNow() + '...';
            },

            signedIn(){
                return window.App.signedIn;
            },

            canUpdate(){
                return this.authorize( user => this.data.user_id == window.App.user.id);
            }
        }
    }
</script>