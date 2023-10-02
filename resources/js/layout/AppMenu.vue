<script setup>
import { ref } from 'vue';

import AppMenuItem from './AppMenuItem.vue';

const model = ref([
    {
        label: 'Home',
        items: [{ label: 'Dashboard', icon: 'pi pi-fw pi-home', to: '/' }]
    },
    {
        label: 'Quản lý',
        items: [{ label: 'Người dùng', icon: 'pi pi-users', to: '/users' },
            {
                label: 'Xe',
                icon: 'pi pi-car',
                items: [
                    {
                        label: 'Danh sách xe',
                        icon: 'pi pi-list',
                        to: '/cars'
                    },
                    {
                        label: 'Chuyến xe', icon: 'pi pi-car', to: '/trips'
                    },
                    {
                        label: 'Bảo trì', icon: 'pi pi-briefcase', to: '/maintenance'
                    }
                ]
            },
        { label: 'Hóa đơn', icon: 'pi pi-file', to: '/bills' },
            { label: 'Trạng thái', icon: 'pi pi-briefcase', to: '/status' },
            {label: 'Địa điểm', icon: 'pi pi-map', to: '/places'},
        ]
    },
]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
        <li>
            <a href="https://www.primefaces.org/primeblocks-vue/#/" target="_blank">
                <img src="/layout/images/banner-primeblocks.png" alt="Prime Blocks" class="w-full mt-3" />
            </a>
        </li>
    </ul>
</template>

<style lang="scss" scoped></style>
