import {createRouter, createWebHistory} from "vue-router";
import ExampleComponent from '../components/ExampleComponent.vue';
import AboutComponent from '../components/AboutComponent.vue';
import NonFoundPage from '../pages/NonFoundPage.vue';

const routes = [
    {
        path: '/',
        component: ExampleComponent
    },
    {
        path: '/about',
        component: AboutComponent
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

export default router;