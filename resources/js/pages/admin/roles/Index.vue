<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

interface Role {
    id: number;
    nombre: string;
    descripcion: string;
}

defineProps<{
    roles: Role[];
}>();

const eliminarRol = (role: Role) => {
    if (confirm(`¿Estás seguro de que deseas eliminar el rol "${role.nombre}"?`)) {
        router.delete(route('admin.roles.destroy', role.id));
    }
};
</script>

<template>
    <Head title="Gestión de Roles" />
    <div>
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">Gestión de roles</h1>
            <button 
                @click="router.get(route('admin.roles.create'))"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
                Nuevo Rol
            </button>
        </div>
        <div class="bg-gray-800/70 p-6 rounded-lg">
            <table class="w-full text-left text-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4">ID</th>
                        <th class="py-2 px-4">Nombre</th>
                        <th class="py-2 px-4">Descripción</th>
                        <th class="py-2 px-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="role in roles" :key="role.id" class="border-t border-gray-700">
                        <td class="py-2 px-4">{{ role.id }}</td>
                        <td class="py-2 px-4">{{ role.nombre }}</td>
                        <td class="py-2 px-4">{{ role.descripcion }}</td>
                        <td class="py-2 px-4">
                            <button 
                                @click="router.get(route('admin.roles.edit', role.id))"
                                class="text-blue-400 hover:text-blue-300 mr-4"
                            >
                                Editar
                            </button>
                            <button 
                                @click="eliminarRol(role)"
                                class="text-red-400 hover:text-red-300"
                            >
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
