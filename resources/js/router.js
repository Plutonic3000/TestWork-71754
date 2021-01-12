import Vue from 'vue';
import VueRouter from 'vue-router';
import Records from './views/Records';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'mainpage',
        component: Records
    },
    {
        path: '/account',
        name: 'account',
        component: () => import('./views/Account')
    },
    {
        path: '/admin',
        name: 'admin',
        component: () => import('./views/Admin')
    },
    {
        path: '/register',
        name: 'register',
        component: () => import('./views/auth/Register')
    },
];

const router = new VueRouter({
    mode: 'history',
    routes: routes,
    linkActiveClass: 'active'
});

export default router;
