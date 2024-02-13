import { createRouter, createWebHistory } from "vue-router";
import MainePage from '../pages/MainePage.vue';
import AuthPage from '../pages/AuthPage.vue';
import NonFoundPage from '../pages/NonFoundPage.vue';

const routes = [
    {
        path: '/',
        component: MainePage
    },
    {
        path: '/auth',
        component: AuthPage
    },
    {
        path: '/:pathMatch(.*)*', 
        name: 'NotFound', 
        component: NonFoundPage
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {

    const accessToken = localStorage.getItem('access_token');

    if (to.path !== '/auth') {
        if (!accessToken) {
            return next('/auth');
        }
    } else if (to.path === '/auth' && accessToken) {
        return next('/');
    }

    next();
});

export default router;