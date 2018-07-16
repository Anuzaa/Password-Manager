import Vue from 'vue';
import _axios from 'axios';
import axios from 'axios';
import router from './router/index';
import Index from './Index.vue';
import Auth from "./common/auth";

const TOKEN_EXPIRED_MSG = 'Token has expired';

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
    console.log(error.response);
    const originalRequest = error.config;
    const requestOptions = {};
    requestOptions.headers = Auth.getAuthHeader();
    // debugger;
    if (error.response.status === 401 && error.response.data.message === TOKEN_EXPIRED_MSG && !originalRequest._retry) {
        return _axios.get('/token', requestOptions)
            .then((response) => {
                if (response.data.token) {
                    Auth.storeToken(response.data.token);
                }
            })
            .catch(e => {
                console.log(e.response);
                debugger;
            });
    }
    return Promise.reject(error);
});

new Vue({
    el: '#app',
    router,

    components: {
        Index,

    },
});
