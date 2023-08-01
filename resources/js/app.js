require('./bootstrap');

window.Vue = require('vue').default;

// Vue.component('messages', require('./components/admin/Messages.vue').default);

const app = new Vue({
    el: '#app',
});
