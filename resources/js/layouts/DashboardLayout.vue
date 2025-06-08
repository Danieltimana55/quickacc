<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';

// @ts-ignore
const user = usePage().props.auth.user;
</script>

<template>
    <div class="flex min-h-svh bg-gray-900 text-gray-300">
        <!-- Sidebar -->
        <aside class="w-64 flex-shrink-0 bg-gray-800/60 p-6">
            <div class="flex flex-col gap-8">
                <Link :href="route('dashboard')" class="flex flex-col items-center gap-2 font-medium">
                    <div class="mb-1 flex h-20 w-20 items-center justify-center rounded-full bg-gray-700/80 shadow-md p-1">
                        <AppLogoIcon class="h-full w-full object-contain" />
                    </div>
                </Link>
                <div class="text-center mb-4">
                    <p class="text-lg font-semibold text-white">{{ user.nombres }} {{ user.apellidos }}</p>
                    <p class="text-sm text-gray-400">{{ user.rol ? user.rol.nombre : 'Sin rol' }}</p>
                </div>
                <nav class="flex flex-col gap-2">
                    <!-- Navigation items will go here -->
                    <Link :href="route('dashboard')" class="text-blue-400 hover:text-blue-300">
                        Dashboard
                    </Link>
                </nav>
            </div>
            
            <div class="mt-auto pt-6 border-t border-gray-700 mt-8">
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