<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

defineProps<{
    users: any[];
}>();
</script>

<template>
    <Head title="Manage Users" />
    <div>
        <h1 class="text-3xl font-bold text-white mb-6">Gestión de usuarios</h1>
        <div class="bg-gray-800/70 p-6 rounded-lg">
            <table class="w-full text-left text-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4">Nombres</th>
                        <th class="py-2 px-4">Identificación</th>
                        <th class="py-2 px-4">Correo electrónico</th>
                        <th class="py-2 px-4">rol</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users" :key="user.id" class="border-t border-gray-700">
                        <td class="py-2 px-4">{{ user.nombres }} {{ user.apellidos }}</td>
                        <td class="py-2 px-4">{{ user.tipo_documento }} {{ user.numero_documento }}</td>
                        <td class="py-2 px-4">{{ user.email }}</td>
                        <td class="py-2 px-4">{{ user.rol_id }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template> 