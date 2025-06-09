<template>
    <AdminLayout>
        <div class="max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-white">Editar Rol</h1>
                <Link 
                    :href="route('admin.roles.index')"
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors"
                >
                    Volver
                </Link>
            </div>

            <form @submit.prevent="form.put(route('admin.roles.update', role.id))">
                <div class="space-y-6 bg-gray-800 p-6 rounded-lg shadow">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-300">
                            Nombre
                        </label>
                        <input
                            id="nombre"
                            v-model="form.nombre"
                            type="text"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                        <div v-if="form.errors.nombre" class="text-red-500 text-sm mt-1">
                            {{ form.errors.nombre }}
                        </div>
                    </div>

                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-300">
                            Descripción
                        </label>
                        <textarea
                            id="descripcion"
                            v-model="form.descripcion"
                            rows="3"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        ></textarea>
                        <div v-if="form.errors.descripcion" class="text-red-500 text-sm mt-1">
                            {{ form.errors.descripcion }}
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50"
                        >
                            Actualizar Rol
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

interface Props {
    role: {
        id: number;
        nombre: string;
        descripcion: string;
    };
}

const props = defineProps<Props>();

const form = useForm({
    nombre: props.role.nombre,
    descripcion: props.role.descripcion,
});
</script>
