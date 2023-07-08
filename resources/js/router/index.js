import { createRouter, createWebHashHistory } from 'vue-router'
import AppLayout from '../layout/AppLayout.vue'

const router = createRouter({
    history: createWebHashHistory(),
    routes: [
        {
            path: '/',
            component: AppLayout,
            name: 'dashboard',
            component: () => import('../views/pages/home.vue'),
            children: [
                {
                    path: '/uikit/formlayout',
                    name: 'formlayout',
                    component: () => import('../views/uikit/FormLayout.vue'),
                },
                {
                    path: '/uikit/input',
                    name: 'input',
                    component: () => import('../views/uikit/Input.vue'),
                },
                {
                    path: '/uikit/floatlabel',
                    name: 'floatlabel',
                    component: () => import('../views/uikit/FloatLabel.vue'),
                },
                {
                    path: '/uikit/invalidstate',
                    name: 'invalidstate',
                    component: () => import('../views/uikit/InvalidState.vue'),
                },
                {
                    path: '/uikit/button',
                    name: 'button',
                    component: () => import('../views/uikit/Button.vue'),
                },
                {
                    path: '/uikit/table',
                    name: 'table',
                    component: () => import('../views/uikit/Table.vue'),
                },
                {
                    path: '/uikit/list',
                    name: 'list',
                    component: () => import('../views/uikit/List.vue'),
                },
                {
                    path: '/uikit/tree',
                    name: 'tree',
                    component: () => import('../views/uikit/Tree.vue'),
                },
                {
                    path: '/uikit/panel',
                    name: 'panel',
                    component: () => import('../views/uikit/Panels.vue'),
                },

                {
                    path: '/uikit/overlay',
                    name: 'overlay',
                    component: () => import('../views/uikit/Overlay.vue'),
                },
                {
                    path: '/uikit/media',
                    name: 'media',
                    component: () => import('../views/uikit/Media.vue'),
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
