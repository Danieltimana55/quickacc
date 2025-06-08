<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { usePage, Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, Users, Laptop, ClipboardList, School, ShieldCheck } from 'lucide-vue-next';
import { computed } from 'vue';
import AppLogo from './AppLogo.vue';

// Acceder al usuario actual
const { auth } = usePage().props as any;
const user = computed(() => auth.user);
const isAdmin = computed(() => user.value && user.value.rol && user.value.rol.nombre === 'administrador');

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
];

// Elementos de navegación para administradores
const adminNavItems: NavItem[] = [
    {
        title: 'Panel Admin',
        href: route('admin.dashboard'),
        icon: ShieldCheck,
    },
    {
        title: 'Usuarios',
        href: route('admin.users.index'),
        icon: Users,
    },
    {
        title: 'Dispositivos',
        href: route('admin.devices.index'),
        icon: Laptop,
    },
    {
        title: 'Formaciones',
        href: route('admin.formaciones.index'),
        icon: School,
    },
    {
        title: 'Registros',
        href: route('admin.registros.index'),
        icon: ClipboardList,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
            
            <!-- Menú de administración para usuarios con rol de administrador -->
            <template v-if="isAdmin">
                <div class="px-3 py-2">
                    <h2 class="mb-2 px-4 text-lg font-semibold tracking-tight">Administración</h2>
                    <NavMain :items="adminNavItems" />
                </div>
            </template>
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
