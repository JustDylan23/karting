import VueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    base: '/',
    routes: [
        {
            path: '/',
            name: 'home',
            component: () => import('@/views/TheHome'),
        },
        {
            path: '/activities',
            name: 'offerings',
            component: () => import('@/views/TheActivities'),
        },
    ],
});

export default router;
