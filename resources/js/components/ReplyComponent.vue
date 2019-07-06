<template>
    <div :id="'reply-'+id" class="card" style="margin-bottom:1rem;">
        <div class="card-header" :class="isBest ? 'success' : ''">
            <div class="level">
                <div class="flex">
                    <a :href="'/profiles/'+data.owner.name" 
                        v-text="data.owner.name"></a> 
                    said <span v-text="ago"></span>
                </div>

                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
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


        <div class="card-header level"> 
            <div v-if="authorize('updateReply', reply)">
                <button class="btn btn-sm" @click="destroy"><i class="fas fa-trash" style="color:#ce2910"></i></button>
                <button class="btn mr-1" @click="editing = true" style="color:#023689"><i class="far fa-edit"></i></button>
            </div>

            <button class="btn btn-success btn-sm ml-a" @click="markBestRely" v-show="! isBest">Best Reply?</button>
        </div>
    </div>
</template>

<script>
import Favorite from './FavoriteComponent.vue';
import moment from 'moment';

    export default {
        props: ['data'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body,
                isBest: this.data.isBest,
                reply: this.data
            }
        },

        computed: {
            ago() {
                return moment(this.data.created_at).fromNow();
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
                    '/replies/' + this.data.id , {
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
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted' , this.data.id);
            },

            markBestRely() {
                axios.post('/replies/'+ this.data.id +'/best');

                window.events.$emit('best-reply-selected' , this.data.id);
            }
        }
    }
</script>

<style>
.success {
    background-color: #7af5ae80;
}
</style>
