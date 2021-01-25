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
                editing: false,
                title: this.thread.title,
                body: this.thread.body,
                form: {
                    title: this.thread.title,
                    body: this.thread.body,
                }
            }
        },

        methods: {
            toggleLock() {
                axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug);

                this.locked = ! this.locked;
            },

            update() {
                axios.patch(location.pathname , this.form) 
                .catch(error => {
                    flash(error.response.data , 'danger');
                })
                .then(
                    this.title = this.form.title,
                    this.body = this.form.body,

                    flash('Your Thread Updated.')
                );

                this.editing = false;

            },

            cancel() {
                this.form.title = this.title;
                this.form.body = this.body;

                this.editing = false;
            }
        }
    }
</script>
