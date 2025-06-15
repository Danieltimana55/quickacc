<template>
    <Head title="Editar Formación" />
    <div class="w-full max-w-5xl mx-auto px-4 md:px-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-2xl md:text-3xl font-semibold text-white mb-4 sm:mb-0">Editar Formación</h1>
            <Link 
                :href="route('admin.formations.index')"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors"
            >
                Volver
            </Link>
        </div>

        <form @submit.prevent="form.put(route('admin.formations.update', formacion.id))" class="w-full">
            <div class="space-y-6 bg-gray-800/90 p-4 md:p-6 rounded-lg shadow-lg">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-300">Nombre</label>
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

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nivel" class="block text-sm font-medium text-gray-300">Nivel</label>
                        <select
                            id="nivel"
                            v-model="form.nivel"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                            <option value="Técnico">Técnico</option>
                            <option value="Tecnólogo">Tecnólogo</option>
                            <option value="Especialización">Especialización</option>
                        </select>
                        <div v-if="form.errors.nivel" class="text-red-500 text-sm mt-1">
                            {{ form.errors.nivel }}
                        </div>
                    </div>

                    <div>
                        <label for="numero_ficha" class="block text-sm font-medium text-gray-300">Número de Ficha</label>
                        <input
                            id="numero_ficha"
                            v-model="form.numero_ficha"
                            type="text"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                        <div v-if="form.errors.numero_ficha" class="text-red-500 text-sm mt-1">
                            {{ form.errors.numero_ficha }}
                        </div>
                    </div>
                </div>

                <div>
                    <label for="instructor_id" class="block text-sm font-medium text-gray-300">Instructor</label>
                    <select
                        id="instructor_id"
                        v-model="form.instructor_id"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                        <option v-for="instructor in instructores" :key="instructor.id" :value="instructor.id">
                            {{ instructor.nombres }} {{ instructor.apellidos }}
                        </option>
                    </select>
                    <div v-if="form.errors.instructor_id" class="text-red-500 text-sm mt-1">
                        {{ form.errors.instructor_id }}
                    </div>
                </div>

                <div>
                    <label for="jornada_id" class="block text-sm font-medium text-gray-300">Jornada</label>
                    <select
                        id="jornada_id"
                        v-model="form.jornada_id"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                        <option v-for="jornada in jornadas" :key="jornada.id" :value="jornada.id">
                            {{ jornada.nombre }}
                        </option>
                    </select>
                    <div v-if="form.errors.jornada_id" class="text-red-500 text-sm mt-1">
                        {{ form.errors.jornada_id }}
                    </div>
                </div>

                <div>
                    <label for="numero_ambiente" class="block text-sm font-medium text-gray-300">Número de Ambiente</label>
                    <input
                        id="numero_ambiente"
                        v-model="form.numero_ambiente"
                        type="text"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                    <div v-if="form.errors.numero_ambiente" class="text-red-500 text-sm mt-1">
                        {{ form.errors.numero_ambiente }}
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="fecha_inicio" class="block text-sm font-medium text-gray-300">Fecha de Inicio</label>
                        <input
                            id="fecha_inicio"
                            v-model="form.fecha_inicio"
                            type="date"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                        <div v-if="form.errors.fecha_inicio" class="text-red-500 text-sm mt-1">
                            {{ form.errors.fecha_inicio }}
                        </div>
                    </div>

                    <div>
                        <label for="fecha_fin" class="block text-sm font-medium text-gray-300">Fecha de Finalización</label>
                        <input
                            id="fecha_fin"
                            v-model="form.fecha_fin"
                            type="date"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                        <div v-if="form.errors.fecha_fin" class="text-red-500 text-sm mt-1">
                            {{ form.errors.fecha_fin }}
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50"
                    >
                        Actualizar Formación
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';

interface Formacion {
    id: number;
    nombre: string;
    nivel: string;
    numero_ficha: string;
    instructor_id: number;
    numero_ambiente: string;
    fecha_inicio: string;
    fecha_fin: string;
    jornada_id: number;
}

interface Instructor {
    id: number;
    nombres: string;
    apellidos: string;
}

interface Jornada {
    id: number;
    nombre: string;
}

interface Props {
    formacion: Formacion;
    instructores: Instructor[];
    jornadas: Jornada[];
}

const props = defineProps<Props>();

// Format dates to YYYY-MM-DD for date inputs
const formatDate = (dateString: string): string => {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toISOString().split('T')[0];
};

const form = useForm({
    nombre: props.formacion.nombre,
    nivel: props.formacion.nivel,
    numero_ficha: props.formacion.numero_ficha,
    instructor_id: props.formacion.instructor_id,
    numero_ambiente: props.formacion.numero_ambiente,
    fecha_inicio: formatDate(props.formacion.fecha_inicio),
    fecha_fin: formatDate(props.formacion.fecha_fin),
    jornada_id: props.formacion.jornada_id,
});
</script>