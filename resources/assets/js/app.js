import Vue from 'vue';
import axios from 'axios';
import router from './router/index';
import Index from './Index.vue';
import EmailVerify from './components/EmailVerify.vue';

import Auth from "./common/auth";


window.axios = axios;
window.axios.defaults.baseURL = '/api/';

window.axios.interceptors.request.use((config) => {
    const Config = config;
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
    if (error.response.status === 401) { // if the error is 401 and hasnt already been retried
        return Auth.logout();
    }
    return Promise.reject(error);
});

new Vue({
    el: '#app',
    router,

    components: {
        Index,
        EmailVerify,
    },
});
