
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import router from './routes';


window.axios = axios;
Vue.use(VueAxios, axios);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Index from './components/Index.vue';


new Vue({
    el: '#app',
    router,
    axios,
    components: {
        Index,
    },
});
