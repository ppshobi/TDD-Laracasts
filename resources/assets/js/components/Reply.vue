<script>
    import Favorite from './Favorite.vue'
    export default {
        props: ['data'],

        components: {Favorite},

        data() {
            return {
                editing: false,
                body: this.data.body,
            };
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                });

                this.editing = false;

                flash('Reply Updated');
            },

            destroy() {
                axios.delete('/replies/' + this.data.id);

                $(this.$el).fadeOut(300, () => {
                    flash('Reply Deleted');
                });
            }
        }
    }
</script>