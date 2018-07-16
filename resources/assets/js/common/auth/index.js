import axios from 'axios';

const LOGIN_URL = 'login';

export default {
    user: {
        authenticated: false,
    },
    attempt(email) {
        return axios.post(LOGIN_URL, email);
    },
    refreshToken(refreshedToken) {
        this.storeToken(refreshedToken);
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
        this.user.authenticated = this.getBearerToken();
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