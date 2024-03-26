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
                    meta:{
                        title: 'Trang quản trị'

                    }
                },
                {
                    path: '/users',
                    name: 'users',
                    component: () => import('../views/pages/Users.vue'),
                    meta:{
                        title: 'Người dùng'
                    }
                },
                {
                    path: '/cars',
                    name: 'car',
                    component: () => import('../views/pages/Car.vue'),
                    meta:{
                        title: 'Xe'
                    }
                },
                {
                    path: '/bills',
                    name: 'bills',
                    component: () => import('../views/pages/Bills.vue'),
                    meta:{
                        title: 'Hoá đơn'
                    }
                },
                {
                    path: '/trips',
                    name: 'trips',
                    component: () => import('../views/pages/Trips.vue'),
                    meta:{
                        title: 'Chuyến đi'
                    }
                },
                {
                    path: '/maintenance',
                    name: 'maintenance',
                    component: () => import('../views/pages/Maintenance.vue'),
                    meta:{
                        title: 'Maintenance'
                    }
                },

                {
                    path: '/status',
                    name: 'status',
                    component: () => import('../views/pages/Status.vue'),
                    meta:{
                        title: 'Trạng thái'
                    }
                },
                {
                    path: '/places',
                    name: 'places',
                    component: () => import('../views/pages/Places.vue'),
                    meta:{
                        title: 'Chặng đường'
                    }
                },

            ],
        },
        {
            path: '/login',
            name: 'login',
            component: () => import('../views/pages/auth/Login.vue'),
            meta:{
                title: 'Đăng nhập'
            }
        },
        {
            path: '/forgotPassword',
            name: 'forgotPassword',
            component: () => import('../views/pages/auth/Forgotpassword.vue'),
            meta:{
                title: 'Quên mật khẩu'
            }
        },
        {
            path: '/register',
            name: 'register',
            component: () => import('../views/pages/auth/register.vue'),
            meta:{
                title: 'Register'
            }
        },
        {
            path: '/access',
            name: 'accessDenied',
            component: () => import('../views/pages/auth/Access.vue'),
            meta:{
                title: 'Access Denied'
            }
        },
        {
            path: '/error',
            name: 'error',
            component: () => import('../views/pages/auth/Error.vue'),
            meta:{
                title: 'Lỗi'
            }
        },
    ],
})
export default router
