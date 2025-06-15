<template>
    <Head title="Crear Usuario" />
    <div class="w-full max-w-5xl mx-auto px-4 md:px-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-2xl md:text-3xl font-semibold text-white mb-4 sm:mb-0">Crear Usuario</h1>
            <Link 
                :href="route('admin.users.index')"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors"
            >
                Volver
            </Link>
        </div>

        <form @submit.prevent="form.post(route('admin.users.store'))" class="w-full">
            <div class="space-y-6 bg-gray-800/90 p-4 md:p-6 rounded-lg shadow-lg">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nombres" class="block text-sm font-medium text-gray-300">Nombres</label>
                        <input
                            id="nombres"
                            v-model="form.nombres"
                            type="text"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                        <div v-if="form.errors.nombres" class="text-red-500 text-sm mt-1">
                            {{ form.errors.nombres }}
                        </div>
                    </div>

                    <div>
                        <label for="apellidos" class="block text-sm font-medium text-gray-300">Apellidos</label>
                        <input
                            id="apellidos"
                            v-model="form.apellidos"
                            type="text"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                        <div v-if="form.errors.apellidos" class="text-red-500 text-sm mt-1">
                            {{ form.errors.apellidos }}
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="tipo_documento" class="block text-sm font-medium text-gray-300">Tipo Documento</label>
                        <select
                            id="tipo_documento"
                            v-model="form.tipo_documento"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                            <option value="CC">Cédula de Ciudadanía</option>
                            <option value="TI">Tarjeta de Identidad</option>
                            <option value="CE">Cédula de Extranjería</option>
                            <option value="PAS">Pasaporte</option>
                        </select>
                        <div v-if="form.errors.tipo_documento" class="text-red-500 text-sm mt-1">
                            {{ form.errors.tipo_documento }}
                        </div>
                    </div>

                    <div>
                        <label for="numero_documento" class="block text-sm font-medium text-gray-300">Número Documento</label>
                        <input
                            id="numero_documento"
                            v-model="form.numero_documento"
                            type="text"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                        <div v-if="form.errors.numero_documento" class="text-red-500 text-sm mt-1">
                            {{ form.errors.numero_documento }}
                        </div>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Correo Electrónico</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                    <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">
                        {{ form.errors.email }}
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">Contraseña</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                    <div v-if="form.errors.password" class="text-red-500 text-sm mt-1">
                        {{ form.errors.password }}
                    </div>
                </div>

                <div>
                    <label for="rol_id" class="block text-sm font-medium text-gray-300">Rol</label>
                    <select
                        id="rol_id"
                        v-model="form.rol_id"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                        <option value="" disabled selected>Seleccione un rol</option>
                        <option v-for="rol in roles" :key="rol.id" :value="rol.id">{{ rol.nombre }}</option>
                    </select>
                    <div v-if="form.errors.rol_id" class="text-red-500 text-sm mt-1">
                        {{ form.errors.rol_id }}
                    </div>
                </div>

                <div v-if="esAprendiz">
                    <label for="formacion_id" class="block text-sm font-medium text-gray-300">Formación</label>
                    <select
                        id="formacion_id"
                        v-model="form.formacion_id"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        :required="esAprendiz"
                    >
                        <option value="" disabled selected>Seleccione una formación</option>
                        <option v-for="formacion in formaciones" :key="formacion.id" :value="formacion.id">
                            {{ formacion.nombre }} ({{ formacion.numero_ficha }})
                        </option>
                    </select>
                    <div v-if="form.errors.formacion_id" class="text-red-500 text-sm mt-1">
                        {{ form.errors.formacion_id }}
                    </div>
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50"
                    >
                        Crear Usuario
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Props {
    roles: {
        id: number;
        nombre: string;
    }[];
    formaciones: {
        id: number;
        nombre: string;
        numero_ficha: string;
    }[];
}

const props = defineProps<Props>();

const form = useForm({
    nombres: '',
    apellidos: '',
    tipo_documento: 'CC',
    numero_documento: '',
    email: '',
    password: '',
    rol_id: '',
    formacion_id: null,
});

// Si el rol es 'aprendiz', mostrar el campo de formación
const esAprendiz = computed(() => {
    const aprendizRol = props.roles.find(rol => rol.nombre.toLowerCase() === 'aprendiz');
    return aprendizRol && form.rol_id && Number(form.rol_id) === aprendizRol.id;
});
</script>