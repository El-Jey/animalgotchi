import Vue from 'vue';

// Plugins
require('./bootstrap');
const axios = require('axios').default;
import store from './store';

// Components
import AppAnimalgotchi from "./components/Animalgotchi";

// Axios
Vue.prototype.$axios = axios;
Vue.prototype.$axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    Vue.prototype.$axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

new Vue({
    el: '#app',
    components: {
        AppAnimalgotchi
    },
    store,
});
