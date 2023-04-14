import { createRouter, createWebHistory } from 'vue-router'
import FormCreatePage from '@/pages/FormCreatePage.vue';
import FormShowPage from '@/pages/FormShowPage.vue';

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/form/create',
            name: 'form-create',
            component: FormCreatePage
        },
        {
            path: '/form/show',
            name: 'form-show',
            component: FormShowPage
        }
    ]
})

export default router
