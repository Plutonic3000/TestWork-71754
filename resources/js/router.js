import Vue from 'vue';
import VueRouter from 'vue-router';
import Mainpage from './views/Mainpage';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'mainpage',
        component: Mainpage
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
    routes: routes,
    linkActiveClass: 'active'
});

export default router;
