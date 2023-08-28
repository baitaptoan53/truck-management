import { createRouter, createWebHashHistory } from 'vue-router'
import AppLayout from '../layout/AppLayout.vue'

const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        {
            component: AppLayout,
            path: '/',
            children: [
                {
                    path: '/',
                    name: 'dashboard',
                    component: () => import('../views/pages/Home.vue'),
                },
                {
                    path: '/users',
                    name: 'users',
                    component: () => import('../views/pages/Users.vue'),
                },
                {
                    path: '/cars',
                    name: 'car',
                    component: () => import('../views/pages/Car.vue'),
                },
                {
                    path: '/bills',
                    name: 'bills',
                    component: () => import('../views/pages/Bills.vue'),
                },
                {
                    path: '/trips',
                    name: 'trips',
                    component: () => import('../views/pages/Trips.vue'),
                },
                {
                    path: '/maintenance',
                    name: 'maintenance',
                    component: () => import('../views/pages/Maintenance.vue'),
                },

                {
                    path: '/status',
                    name: 'status',
                    component: () => import('../views/pages/Status.vue'),
                },
                
            ],
        },
        {
            path: '/login',
            name: 'login',
            component: () => import('../views/pages/auth/Login.vue'),
        },
        {
            path: '/forgotPassword',
            name: 'forgotPassword',
            component: () => import('../views/pages/auth/Forgotpassword.vue'),
        },
        {
            path: '/register',
            name: 'register',
            component: () => import('../views/pages/auth/register.vue'),
        },
        {
            path: '/access',
            name: 'accessDenied',
            component: () => import('../views/pages/auth/Access.vue'),
        },
        {
            path: '/error',
            name: 'error',
            component: () => import('../views/pages/auth/Error.vue'),
        },
    ],
})
export default router
