import Vue from 'vue';
import VueAlert from '@vuejs-pt/vue-alert';
import VeeValidate from 'vee-validate';
import axios from 'axios';
import vSelect from 'vue-select';
import VuejsDialog from 'vuejs-dialog';
import 'vuejs-dialog/dist/vuejs-dialog.min.css';
import router from './router/index';
import Index from './Index.vue';
import Auth from "./common/auth";

const TOKEN_EXPIRED_MSG = 'Token has expired';

window.axios = axios;
window.axios.defaults.baseURL = '/api/';
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.axios.interceptors.request.use((config) => {
    const Config = config;
    console.log(Auth.getBearerToken());
    if (Auth.check()) {
        Config.headers.common.Authorization = Auth.getBearerToken();
    }
    Config.headers.common.Accept = 'application/json';
    return Config;
}, error =>
    Promise.reject(error));

// Add a response interceptor
window.axios.interceptors.response.use(response =>
    response, (error) => {
    // console.log(error.response);
    const originalRequest = error.config;
    const requestOptions = {};
    requestOptions.headers = Auth.getAuthHeader();

    if (error.response.status === 401 && error.response.data.message === TOKEN_EXPIRED_MSG && !originalRequest._retry) {
        originalRequest._retry = true;
        originalRequest.url = originalRequest.url.replace('/api/', '');
        return window.axios.get('/token', requestOptions)
            .then((response) => {
                if (response.data && response.data.token) {
                    // window.axios.defaults.headers.Authorization = 'Bearer ' + response.data.token;
                    originalRequest.headers.Authorization = 'Bearer ' + response.data.token;
                    Auth.storeToken(response.data.token);
                    console.log(originalRequest);
                    return window.axios(originalRequest);
                }
            })
            .then(() => {
                originalRequest._retry = false;
            })
            .catch((err) => {
                console.log('token error', err.response);
            }) ;
    }
    return Promise.reject(error);
});
Vue.use(VueAlert);
Vue.use(VuejsDialog);
Vue.component('v-select', vSelect);

Vue.use(VeeValidate);


new Vue({
    el: '#app',
    router,
    components: {
        Index,
    },
});
