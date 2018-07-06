import axios from 'axios';

const LOGIN_URL = 'login';

export default {
    user: {
        authenticated: false,
    },

    attempt(credentials) {
        return axios.post(LOGIN_URL, credentials).then((req => {
            const token = req.data.token;
            console.log(token);
            localStorage.setItem('auth_token', token);
            this.user.authenticated = true;
        }))
    },
    storeToken(token) {
        localStorage.setItem('auth_token', token);
        this.user.authenticated = true;
    },
    logout() {
        localStorage.removeItem('auth_token');
        this.user.authenticated = false;
    },
    check() {
        this.user.authenticated  = this.getBearerToken();
        return this.user.authenticated;

    },

    getAuthHeader() {
        return {
            Authorization: this.getBearerToken(),
        };


    },
    getBearerToken() {
        return `Bearer ${localStorage.getItem('auth_token')}`;

    },
};