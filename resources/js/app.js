
import './bootstrap';

Vue.component('flash-component', require('./components/FlashComponent.vue').default);
Vue.component('reply-component', require('./components/ReplyComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
