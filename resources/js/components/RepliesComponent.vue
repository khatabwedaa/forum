<template>
    <div>
        <div v-for="(reply , index) in items" :key="reply.id">
            <reply :reply="reply" @deleted="remove(index)"></reply>
        </div>

        <paginator-component :dataSet="dataSet" @changed="fatch"></paginator-component>

        <p v-if="$parent.locked">
            This thread is locked no more replies allowed
        </p>

        <new-reply @created="add" v-else></new-reply>
    </div>
</template>

<script>
import Reply from './ReplyComponent.vue'
import NewReply from './NewReplyComponent.vue'
import collection from '../mixins/collection.js'

    export default {
        components: { Reply , NewReply },

        mixins: [ collection ],

        data() {
            return { dataSet: false }
        },

        created() {
            this.fatch();
        },

        methods: {
            fatch(page) {
                axios.get(this.url(page)).then(this.refresh);
            },

            url(page) {
                if(! page) {
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1] : 1;
                }
                return `${location.pathname}/replies?page=${page}` ;
            },

            refresh({data}) {
                this.dataSet = data;
                this.items = data.data;

                window.scrollTo(0 , 0);
            }
        }
    }
</script>

