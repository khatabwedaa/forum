<template>
    <div :id="'reply-'+id" class="card" style="margin-bottom:1rem;">
        <div class="card-header" :class="isBest ? 'success' : ''">
            <div class="level">
                <div class="flex">
                    <a :href="'/profiles/'+reply.owner.name" 
                        v-text="reply.owner.name"></a> 
                    said <span v-text="ago"></span>
                </div>

                <div v-if="signedIn">
                    <favorite :reply="reply"></favorite>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div v-if="editing">
               <form @submit="update">
                    <div class="form-group">
                        <textarea name="body" class="form-control" v-model="body" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                    <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
               </form>
            </div>

            <div v-else v-html="body"></div>
        </div>


        <div class="card-header level" v-if="authorize('owns' , reply) || authorize('owns' , reply.thread)"> 
            <div v-if="authorize('owns', reply)">
                <button class="btn btn-sm" @click="destroy"><i class="fas fa-trash" style="color:#ce2910"></i></button>
                <button class="btn mr-1" @click="editing = true" style="color:#023689"><i class="far fa-edit"></i></button>
            </div>

            <button class="btn btn-success btn-sm ml-a" @click="markBestRely" v-if="authorize('owns' , reply.thread) && ! isBest">Best Reply?</button>
        </div>
    </div>
</template>

<script>
import Favorite from './FavoriteComponent.vue';
import moment from 'moment';

    export default {
        props: ['reply'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest,
            }
        },

        computed: {
            ago() {
                return moment(this.reply.created_at).fromNow();
            },
        },

        created() {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id)
            });
        },

        methods: {
            update() {
                axios.patch(
                    '/replies/' + this.id , {
                    body: this.body
                }) 
                .catch(error => {
                    flash(error.response.data , 'danger');              
                })
                .then(
                    flash('Your reply Updated.')
                );

                this.editing = false;

            },

            destroy() {
                axios.delete('/replies/' + this.id);

                this.$emit('deleted' , this.id);
            },

            markBestRely() {
                axios.post('/replies/'+ this.id +'/best');

                window.events.$emit('best-reply-selected' , this.id);
            }
        }
    }
</script>

<style>
.success {
    background-color: #7af5ae80;
}
</style>
