<template>
    <button :class="classes" @click="subscribe">
        <i class="fab fa-angellist"></i> <span v-text="this.active ? 'unsubscribe' : 'subscribe' "></span>
    </button>
</template>

<script>
    export default {
        props: ['active'],

        computed: {
            classes() {
                return ['btn btn-sm' , this.active ? 'btn-dark' : 'btn-danger'];
            }
        },

        methods: {
            subscribe() {
                axios[
                    (this.active ? 'delete' : 'post')
                ](location.pathname + '/subscriptions');

                this.active = ! this.active;

            }
        }
    }
</script>