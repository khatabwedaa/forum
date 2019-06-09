<template>
    <div>
        <div class="level mb-1">
            <img :src="avatar" width="50" height="50" class="mr-1">

            <h2 class="head-h" v-text="user.name"></h2>
        </div>

        <form v-if="canUpdate" method="post" enctype="multipart/form-data">
            <image-upload name="avatar" @loaded="onLoad"></image-upload>
        </form>
    </div>
</template>

<script>
import ImageUpload from './ImageUpload.vue';

    export default {
        props:['user'],

        components: { ImageUpload },

        data() {
            return {
                avatar: this.user.avatar_path
            };
        },

        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id)
            }
        },

        methods: {
            onLoad(avatar) {
                this.avatar = avatar.src;

                this.persist(avatar.file);
            },

            persist(avatar) {
                let data = new FormData;

                data.append('avatar' , avatar);

                axios.post(`/api/users/${this.user.name}/avatar` , data)
                    .then(() => flash('Avatar uploaded!'));
            }
        }
    }
</script>
