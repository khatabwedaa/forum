<script>
import RepliesComponent from '../components/RepliesComponent.vue'

    export default {
        props: ['iniRepliesCount'],

        components: { RepliesComponent },

        data() {
            return {
                repliesCount: this.iniRepliesCount
            }
        }
    }
</script>
