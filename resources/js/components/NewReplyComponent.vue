<template>

    <div>
       <div v-if="signedIn">
            <div class="form-group">
                <textarea name="body" id="body" class="form-control" 
                        placeholder="Having something to say?" rows="4" v-model="body" required>
                </textarea>
            </div>

            <button class="btn btn-primary" @click="addReply">Post</button>
       </div>

        <p class="text-center" v-else>Please <a href="/login">sign in</a> to share in this  discussion</p>
    </div>

</template>

<script>
    export default {        
        data() {
            return {
                body: '',
            }
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies' , { body: this.body })
                    .then(({data}) => {
                    this.body = '';

                    flash('Your reply has been added.')

                    this.$emit('created' , data);
                });
            }
        }
    }
</script>
