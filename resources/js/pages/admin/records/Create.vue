<template>
    <Head title="Crear Registro" />
    <div class="w-full max-w-5xl mx-auto px-4 md:px-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-2xl md:text-3xl font-semibold text-white mb-4 sm:mb-0">Crear Registro</h1>
            <Link 
                :href="route('admin.records.index')"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors"
            >
                Volver
            </Link>
        </div>

        <form @submit.prevent="submitForm" class="w-full">
            <div class="space-y-6 bg-gray-800/90 p-4 md:p-6 rounded-lg shadow-lg">
                <div>
                    <label for="dispositivo_id" class="block text-sm font-medium text-gray-300">Dispositivo</label>
                    <select
                        id="dispositivo_id"
                        v-model="form.dispositivo_id"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        required
                    >
                        <option value="" disabled selected>Seleccione un dispositivo</option>
                        <option v-for="dispositivo in dispositivos" :key="dispositivo.id" :value="dispositivo.id">
                            {{ dispositivo.marca }} - {{ dispositivo.serial }} ({{ getNombreUsuario(dispositivo) }})
                        </option>
                    </select>
                    <div v-if="form.errors.dispositivo_id" class="text-red-500 text-sm mt-1">
                        {{ form.errors.dispositivo_id }}
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="hora_entrada" class="block text-sm font-medium text-gray-300">Hora de Entrada</label>
                        <input
                            id="hora_entrada"
                            v-model="form.hora_entrada"
                            type="time"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                        <div v-if="form.errors.hora_entrada" class="text-red-500 text-sm mt-1">
                            {{ form.errors.hora_entrada }}
                        </div>
                    </div>

                    <div>
                        <label for="hora_salida" class="block text-sm font-medium text-gray-300">Hora de Salida</label>
                        <input
                            id="hora_salida"
                            v-model="form.hora_salida"
                            type="time"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        >
                        <div v-if="form.errors.hora_salida" class="text-red-500 text-sm mt-1">
                            {{ form.errors.hora_salida }}
                        </div>
                    </div>
                </div>

                <div>
                    <label for="observaciones" class="block text-sm font-medium text-gray-300">Observaciones</label>
                    <textarea
                        id="observaciones"
                        v-model="form.observaciones"
                        rows="4"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    ></textarea>
                    <div v-if="form.errors.observaciones" class="text-red-500 text-sm mt-1">
                        {{ form.errors.observaciones }}
                    </div>
                </div>

                <div>
                    <label for="foto_registro" class="block text-sm font-medium text-gray-300">Foto del Registro</label>
                    <input
                        id="foto_registro"
                        type="file"
                        accept="image/*"
                        @input="setFotoRegistro"
                        class="mt-1 block w-full text-white file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700"
                    >
                    <div v-if="form.errors.foto_registro" class="text-red-500 text-sm mt-1">
                        {{ form.errors.foto_registro }}
                    </div>
                    <div v-if="previewRegistro" class="mt-3">
                        <p class="text-sm text-gray-300 mb-2">Vista previa:</p>
                        <img :src="previewRegistro" alt="Vista previa del registro" class="max-w-full max-h-48 h-auto rounded">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50"
                    >
                        Crear Registro
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Usuario {
    id: number;
    nombres: string;
    apellidos: string;
}

interface Dispositivo {
    id: number;
    marca: string;
    serial: string;
    usuario: Usuario | null;
}

interface Props {
    dispositivos: Dispositivo[];
}

const props = defineProps<Props>();

const form = useForm({
    dispositivo_id: '',
    hora_entrada: '',
    hora_salida: '',
    observaciones: '',
    foto_registro: null as File | null,
});

// Vista previa de imagen
const previewRegistro = ref<string | null>(null);

// Función para establecer archivo y crear vista previa
const setFotoRegistro = (event: Event): void => {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files.length > 0) {
        form.foto_registro = input.files[0];
        createPreview(input.files[0], previewRegistro);
    }
};

const createPreview = (file: File, preview: any): void => {
    const reader = new FileReader();
    reader.onload = (e) => {
        preview.value = e.target?.result as string;
    };
    reader.readAsDataURL(file);
};

// Obtener nombre completo del usuario
const getNombreUsuario = (dispositivo: Dispositivo): string => {
    return dispositivo.usuario 
        ? `${dispositivo.usuario.nombres} ${dispositivo.usuario.apellidos}` 
        : 'Sin asignar';
};

// Enviar formulario
const submitForm = (): void => {
    form.post(route('admin.records.store'));
};
</script> 