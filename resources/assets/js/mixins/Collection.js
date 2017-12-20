export default {
    data(){
        return {
            items: []
        };
    },

    methods:{
        remove(item) {
            this.items.splice(item, 1);
            this.$emit('removed');
        },

        add(reply){
            this.items.push(reply);
            this.$emit('added');
        },
    }
}