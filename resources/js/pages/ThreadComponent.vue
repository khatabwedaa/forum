<script>
import RepliesComponent from '../components/RepliesComponent.vue'
import SubscribeButton from '../components/SubscribeButton.vue'

    export default {
        props: ['thread'],

        components: { RepliesComponent , SubscribeButton },

        data() {
            return {
                repliesCount: this.thread.replies_count,
                locked: JSON.parse(this.thread.locked),
            }
        },

        methods: {
            toggleLock() {
                axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug);

                this.locked = ! this.locked;
            }
        }
    }
</script>
