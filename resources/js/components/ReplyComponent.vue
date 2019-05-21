<template>
    <div :id="'reply-'+id" class="card" style="margin-bottom:1rem;">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <a :href="'/reply/'+data.owner.name" 
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
                <div class="form-group">
                    <textarea name="body" class="form-control" v-model="body"></textarea>
                </div>

                <button type="submit" class="btn btn-sm btn-primary" @click="update">Update</button>
                <button type="submit" class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
            </div>

            <div v-else v-text="body"></div>
        </div>


        <div class="card-header level" v-if="canUpdate"> 
            <button class="btn btn-sm" @click="destroy"><i class="fas fa-trash" style="color:#ce2910"></i></button>
            <button class="btn mr-1" @click="editing = true" style="color:#023689"><i class="far fa-edit"></i></button>
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
                body: this.data.body
            }
        },

        computed: {
            ago() {
                return moment(this.data.created_at).fromNow();
            },

            signedIn() {
                return window.App.signedIn;
            },

            canUpdate() {
                return this.authorize(user => this.data.user_id == user.id);
            }
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.data.id , {
                    body: this.body
                });

                this.editing = false;

                flash('Updated!');
            },

            destroy() {
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted' , this.data.id);
            }
        }
    }
</script>