<template>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell" v-show="notifications.length"></i>
            <i class="far fa-bell" v-show="notifications.length == 0"></i>
        </a>

        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <div v-for="notification in notifications" :key="notification.id">
                <a class="dropdown-item" 
                    :href="notification.data.link" 
                    v-text="notification.data.message"
                    @click="markAsRead(notification)"
                ></a>          
            </div> 
        </div>
    </li>
</template>

<script>
    export default {
        data() {
            return { notifications: false }
        },

        created() {
            axios.get("/profiles/" + window.App.user.name + "/notifications")
                .then(response => this.notifications = response.data);
        },
        
        methods: {
            markAsRead(notification) {
                axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id);
            }
        }
    }
</script>

