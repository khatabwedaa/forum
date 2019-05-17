<template>
    <button type="submit" class="btn btn-light" @click="toggle">
        <span><i class="fas fa-heart" :style="favorited"></i></span>
        <small v-text="count"></small>
    </button>
</template>

<script>
    export default {
        props: ['reply'],

        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited    
            }
        },

        computed: {
            favorited() {
                return this.active ? 'color:#dd4b39' : ''
            },

            endpoint() {
                return '/replies/' + this.reply.id + '/favorites';
            }
        },

        methods: {
            toggle() {
                this.active ? this.destroy() : this.create()
            },

            create() {
                axios.post(this.endpoint)

                this.active = true   
                this.count++   

                flash('favorited!')
            },

            destroy() {
                axios.delete(this.endpoint)

                this.active = false   
                this.count--

                flash('unfavorited!')
            }
        }

    }
</script>

