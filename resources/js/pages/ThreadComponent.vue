<script>
import Replies from '../components/RepliesComponent.vue'

    export default {
        props: ['iniRepliesCount'],

        components: { Replies },

        data() {
            return {
                repliesCount: this.iniRepliesCount
            }
        }
    }
</script>
