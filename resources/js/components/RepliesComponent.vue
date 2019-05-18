<template>
    <div>
        <div v-for="(reply , index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>

        <new-reply :endpoint="endpoint" @created="add"></new-reply>
    </div>
</template>

<script>
import Reply from './ReplyComponent.vue'
import NewReply from './NewReplyComponent.vue'

    export default {
        props: ['data'],

        components: { Reply , NewReply },

        data() {
            return {
                items: this.data,
                endpoint: location.pathname + '/replies'
            }
        },

        methods: {
            add(reply) {
                this.items.push(reply);

                this.$emit('added');
            },

            remove(index) {
                this.items.splice(index , 1);

                this.$emit('removed');

                flash('Reply was deleted!');
            }
        }
    }
</script>

