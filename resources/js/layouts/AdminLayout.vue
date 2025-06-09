<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Users, Shield, BookOpen, Smartphone, FileText, LayoutDashboard } from 'lucide-vue-next';

const page = usePage();

// @ts-ignore
const user = page.props.auth.user;

const isUrl = (...urls: string[]) => {
    const currentUrl = page.url.substring(1);
    if (urls[0] === '') {
        return currentUrl === '';
    }
    return urls.some(url => currentUrl.startsWith(url));
};

const navigation = [
    { name: 'Dashboard', href: 'admin.dashboard', icon: LayoutDashboard, current: isUrl('admin/dashboard') },
    { name: 'Users', href: 'admin.users.index', icon: Users, current: isUrl('admin/users') },
    { name: 'Roles', href: 'admin.roles.index', icon: Shield, current: isUrl('admin/roles') },
    // { name: 'Formations', href: 'admin.formations.index', icon: BookOpen, current: isUrl('admin/formations') },
    // { name: 'Devices', href: 'admin.devices.index', icon: Smartphone, current: isUrl('admin/devices') },
    // { name: 'Records', href: 'admin.records.index', icon: FileText, current: isUrl('admin/records') },
];
</script>

<template>
    <div class="flex min-h-svh bg-gray-900 text-gray-300">
        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-gray-800/60 p-6 flex flex-col justify-between">
            <div>
                <div class="flex flex-col items-center gap-4 mb-8">
                    <Link :href="route('admin.dashboard')" class="flex flex-col items-center gap-2 font-medium">
                        <div class="mb-1 flex h-20 w-20 items-center justify-center rounded-full shadow-lg p-">
                            <AppLogoIcon class="h-full w-full object-contain" />
                        </div>
                    </Link>
                    <h2 class="text-lg font-semibold text-white">Admin Panel</h2>
                </div>
                <div class="text-center mb-4">
                    <p class="font-semibold text-white">{{ user.nombres }} {{ user.apellidos }}</p>
                    <p class="text-sm text-gray-400">{{ user.rol ? user.rol.nombre : 'Sin rol' }}</p>
                </div>
                <nav class="flex flex-col gap-2">
                    <Link v-for="item in navigation" :key="item.name" :href="route(item.href)"
                          :class="['flex items-center gap-3 rounded-lg px-3 py-2 text-gray-300 transition-all hover:text-white hover:bg-gray-700', { 'bg-gray-700 text-white': item.current }]">
                        <component :is="item.icon" class="h-4 w-4" />
                        {{ item.name }}
                    </Link>
                </nav>
            </div>
            <!-- User menu can go here -->
            <div class="mt-auto pt-6 border-t border-gray-700 mt-4">
                <Link 
                    :href="route('logout')" 
                    method="post" 
                    as="button" 
                    class="w-full text-red-400 hover:text-red-300 text-sm"
                >
                    Cerrar sesión
                </Link>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-10">
            <div class="w-full h-full backdrop-blur-md bg-gray-800/60 rounded-xl shadow-lg border border-gray-700/30 p-6 md:p-8">
                <slot />
            </div>
        </main>
    </div>
</template> 