<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

interface User {
    id: number;
    nombres: string;
    apellidos: string;
    email: string;
    numero_documento: string;
    rol: {
        id: number;
        nombre: string;
    } | null;
    formacion: {
        id: number;
        nombre: string;
    } | null;
}

const props = defineProps<{
    users: User[];
}>();

const eliminarUsuario = (user: User): void => {
    if (confirm(`¿Estás seguro de que deseas eliminar al usuario "${user.nombres} ${user.apellidos}"?`)) {
        router.delete(route('admin.users.destroy', user.id));
    }
};

// Para búsqueda
const searchTerm = ref('');

// Filtrado de usuarios
const filteredUsers = computed(() => {
    if (!searchTerm.value) return props.users;
    
    const term = searchTerm.value.toLowerCase();
    return props.users.filter(user => 
        user.nombres.toLowerCase().includes(term) || 
        user.apellidos.toLowerCase().includes(term) ||
        user.email.toLowerCase().includes(term) ||
        user.numero_documento.toLowerCase().includes(term) ||
        (user.rol && user.rol.nombre.toLowerCase().includes(term))
    );
});

// Nombre completo
const getNombreCompleto = (user: User): string => {
    return `${user.nombres} ${user.apellidos}`;
};
</script>

<template>
    <Head title="Gestión de Usuarios" />
    <div class="w-full px-4 md:px-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-4 sm:mb-0">Gestión de usuarios</h1>
            <button 
                @click="router.get(route('admin.users.create'))"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
                Nuevo Usuario
            </button>
        </div>

        <!-- Barra de búsqueda -->
        <div class="mb-4">
            <input
                v-model="searchTerm"
                type="text"
                placeholder="Buscar usuarios..."
                class="w-full px-4 py-2 bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
        </div>

        <!-- Vista móvil: Tarjetas -->
        <div class="md:hidden space-y-4">
            <div 
                v-for="user in filteredUsers" 
                :key="user.id" 
                class="bg-gray-800/70 p-4 rounded-lg shadow-md"
            >
                <div class="flex justify-between items-start">
                    <h3 class="text-lg font-medium text-white">{{ getNombreCompleto(user) }}</h3>
                    <span 
                        class="bg-blue-600 text-xs text-white px-2 py-1 rounded-full"
                        v-if="user.rol"
                    >
                        {{ user.rol.nombre }}
                    </span>
                </div>
                <div class="mt-2 space-y-1 text-sm">
                    <p class="text-gray-300"><span class="font-medium">Documento:</span> {{ user.numero_documento }}</p>
                    <p class="text-gray-300"><span class="font-medium">Email:</span> {{ user.email }}</p>
                    <p class="text-gray-300" v-if="user.formacion">
                        <span class="font-medium">Formación:</span> {{ user.formacion.nombre }}
                    </p>
                </div>
                <div class="mt-4 flex justify-end space-x-4">
                    <button 
                        @click="router.get(route('admin.users.edit', user.id))"
                        class="text-blue-400 hover:text-blue-300"
                    >
                        Editar
                    </button>
                    <button 
                        @click="eliminarUsuario(user)"
                        class="text-red-400 hover:text-red-300"
                    >
                        Eliminar
                    </button>
                </div>
            </div>
        </div>

        <!-- Vista desktop: Tabla -->
        <div class="hidden md:block bg-gray-800/70 p-4 md:p-6 rounded-lg overflow-x-auto">
            <table class="w-full text-left text-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4">Nombres</th>
                        <th class="py-2 px-4">Apellidos</th>
                        <th class="py-2 px-4">Documento</th>
                        <th class="py-2 px-4">Email</th>
                        <th class="py-2 px-4">Rol</th>
                        <th class="py-2 px-4">Formación</th>
                        <th class="py-2 px-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in filteredUsers" :key="user.id" class="border-t border-gray-700">
                        <td class="py-2 px-4">{{ user.nombres }}</td>
                        <td class="py-2 px-4">{{ user.apellidos }}</td>
                        <td class="py-2 px-4">{{ user.numero_documento }}</td>
                        <td class="py-2 px-4">{{ user.email }}</td>
                        <td class="py-2 px-4">{{ user.rol ? user.rol.nombre : 'Sin rol' }}</td>
                        <td class="py-2 px-4">{{ user.formacion ? user.formacion.nombre : 'N/A' }}</td>
                        <td class="py-2 px-4">
                            <button 
                                @click="router.get(route('admin.users.edit', user.id))"
                                class="text-blue-400 hover:text-blue-300 mr-4"
                            >
                                Editar
                            </button>
                            <button 
                                @click="eliminarUsuario(user)"
                                class="text-red-400 hover:text-red-300"
                            >
                                Eliminar
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Mensaje cuando no hay resultados -->
        <div v-if="filteredUsers.length === 0" class="bg-gray-800/70 p-6 rounded-lg text-center text-gray-300">
            No se encontraron usuarios
        </div>
    </div>
</template>