import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from './components/Login.vue';
import CategoryList from './components/CategoryList.vue'

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'Login',
        component: Login,
    },
    {
        path: '/categories',
        name: 'CategoryList',
        component: CategoryList,
    },
];

export default new VueRouter({
    routes
});