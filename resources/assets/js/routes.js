import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from './components/Login.vue';
import CategoryList from './components/CategoryList.vue';
import Home from './components/Home.vue';
import Register from './components/Register.vue';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
    },
    {
        path: '/',
        name: 'Register',
        component: Register,
        meta:{
            auth:false
        }
    },
    {
        path: '/',
        name: 'Login',
        component: Login,
        meta:{
            auth:false
        }
    },
    {
        path: '/categories',
        name: 'CategoryList',
        component: CategoryList,
        meta:{
            auth:true
        }
    },

];

export default new VueRouter({
    routes
});