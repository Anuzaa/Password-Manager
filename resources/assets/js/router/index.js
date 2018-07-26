import Vue from 'vue';
import Router from 'vue-router';
import Login from '../pages/Login.vue';
import EmailVerify from '../components/EmailVerify.vue';
import ErrorPage from '../pages/ErrorPage.vue';
import Category from '../pages/Category/List.vue';
import Secret from '../pages/Secret/List.vue';
import CategoryDetail from '../pages/Category/Detail.vue';
import EditCategory from '../pages/Category/Edit.vue';
import CreateCategory from '../pages/Category/Create.vue';
import CreateSecret from '../pages/Secret/Create.vue';
import SecretDetail from '../pages/Secret/Detail.vue';
import EditSecret from '../pages/Secret/Edit.vue';
import ShareSecret from '../pages/Secret/Share.vue';
import Dashboard from '../pages/Dashboard.vue';
import Auth from '../common/auth/index';

Vue.use(Router);


const router = new Router({
    linkActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'login',
            component: Login,
            meta: {
                requiresAuth: false
            },
        },
        {
            path: '/verify',
            name: 'EmailVerify',
            component: EmailVerify,
            meta: {
                requiresAuth: false
            },
        },
        {
            path: '/error',
            name: 'ErrorPage',
            component: ErrorPage,
            meta: {
                requiresAuth: false
            },
        },
        {
            path: '/categories',
            name: 'category',
            component: Category,
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/secrets',
            name: 'secret',
            component: Secret,
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard,
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/category/:id/detail',
            name: 'category.detail',
            component: CategoryDetail,
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/category/create',
            name: 'category.create',
            component: CreateCategory,
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/category/:id/edit',
            name: 'category.edit',
            component: EditCategory,
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/secret/create',
            name: 'secret.create',
            component: CreateSecret,
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/secret/:id/detail',
            name: 'secret.detail',
            component: SecretDetail,
            meta: {
                requiresAuth: true
            },
        },
        {
            path: '/secret/:id/edit',
            name: 'secret.edit',
            component: EditSecret,
            meta: {
                requiresAuth: true
            },
        }, {
            path: '/secret/:id/share',
            name: 'secret.share',
            component: ShareSecret,
            meta: {
                requiresAuth: true
            },
        },


        {path: '*', redirect: '/'},
    ],
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        window.scrollTo(0, 0);
        if (!Auth.check()) {
            next({
                path: '/',
                query: {redirect: to.fullPath},
            });

        } else {
            next();
        }
    } else {
        next();
    }

});
export default router;
