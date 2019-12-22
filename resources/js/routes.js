import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from '@/js/pages/Home';
import Login from '@/js/pages/Login';
import Register from '@/js/pages/Register';
import Profile from '@/js/pages/Profile';
import MyPosts from '@/js/pages/MyPosts';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/profile',
            name: 'profile',
            component: Profile
        },
        {
            path: '/my-posts',
            name: 'my-posts',
            component: MyPosts
        },
    ]
});

export default router;