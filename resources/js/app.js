
import './bootstrap';

Vue.component('flash-component', require('./components/FlashComponent.vue').default);
Vue.component('paginator-component', require('./components/PaginatorComponent.vue').default);
Vue.component('user-notifications', require('./components/UserNotifiactions.vue').default);
Vue.component('thread-component', require('./pages/ThreadComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
