<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, SlidersHorizontal, Landmark, List, ShoppingBag, HousePlus } from 'lucide-vue-next';

import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Slider',
        href: '/sliders',
        icon: SlidersHorizontal,
    },
    {
        title: 'Category',
        href: '/categories',
        icon: List,
    },
    {
        title: 'Band',
        href: '/brands',
        icon: Landmark,
    },

    {
        title: 'Shop',
        href: '/shops',
        icon: HousePlus,
    },
    {
        title: 'Product',
        href: '/products',
        icon: ShoppingBag,
    },
    {
        title: 'Order',
        href: '/admin_orders',
        icon: ShoppingBag,
    },

];

// const footerNavItems: NavItem[] = [
//     {
//         title: 'Github Repo',
//         href: 'https://github.com/laravel/vue-starter-kit',
//         icon: Folder,
//     },
//     {
//         title: 'Documentation',
//         href: 'https://laravel.com/docs/starter-kits#vue',
//         icon: BookOpen,
//     },
// ];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')" class="text-3xl font-extrabold tracking-tight">
                            <span class="bg-gradient-to-r from-blue-700 to-purple-500 bg-clip-text text-transparent">Review</span>
                             <span class="text-red-500">Hub</span>
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
