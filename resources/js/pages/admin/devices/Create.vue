<template>
        <div class="max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-white">Registrar Dispositivo</h1>
                <Link 
                    :href="route('admin.devices.index')"
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors"
                >
                    Volver
                </Link>
            </div>

            <form @submit.prevent="submitForm">
                <div class="space-y-6 bg-gray-800 p-6 rounded-lg shadow">
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-300">Propietario</label>
                        <select
                            id="user_id"
                            v-model="form.user_id"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                            <option value="">Seleccione un usuario</option>
                            <option v-for="usuario in usuarios" :key="usuario.id" :value="usuario.id">
                                {{ usuario.nombres }} {{ usuario.apellidos }}
                            </option>
                        </select>
                        <div v-if="form.errors.user_id" class="text-red-500 text-sm mt-1">
                            {{ form.errors.user_id }}
                        </div>
                    </div>

                    <div>
                        <label for="tipo_dispositivo" class="block text-sm font-medium text-gray-300">Tipo de Dispositivo</label>
                        <select
                            id="tipo_dispositivo"
                            v-model="form.tipo_dispositivo"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                            <option value="">Seleccione un tipo</option>
                            <option value="Laptop">Laptop</option>
                            <option value="Tablet">Tablet</option>
                            <option value="Celular">Celular</option>
                            <option value="Otro">Otro</option>
                        </select>
                        <div v-if="form.errors.tipo_dispositivo" class="text-red-500 text-sm mt-1">
                            {{ form.errors.tipo_dispositivo }}
                        </div>
                    </div>

                    <div>
                        <label for="marca" class="block text-sm font-medium text-gray-300">Marca</label>
                        <input
                            id="marca"
                            v-model="form.marca"
                            type="text"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                        <div v-if="form.errors.marca" class="text-red-500 text-sm mt-1">
                            {{ form.errors.marca }}
                        </div>
                    </div>

                    <div>
                        <label for="serial" class="block text-sm font-medium text-gray-300">Número de Serial</label>
                        <input
                            id="serial"
                            v-model="form.serial"
                            type="text"
                            class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            required
                        >
                        <div v-if="form.errors.serial" class="text-red-500 text-sm mt-1">
                            {{ form.errors.serial }}
                        </div>
                    </div>

                    <div>
                        <label for="foto_dispositivo" class="block text-sm font-medium text-gray-300">Foto del Dispositivo</label>
                        <input
                            id="foto_dispositivo"
                            type="file"
                            accept="image/*"
                            @input="setFotoDispositivo"
                            class="mt-1 block w-full text-white file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700"
                        >
                        <div v-if="form.errors.foto_dispositivo" class="text-red-500 text-sm mt-1">
                            {{ form.errors.foto_dispositivo }}
                        </div>
                        <div v-if="previewDispositivo" class="mt-3">
                            <p class="text-sm text-gray-300 mb-2">Vista previa:</p>
                            <img :src="previewDispositivo" alt="Vista previa del dispositivo" class="max-w-xs rounded">
                        </div>
                    </div>

                    <div>
                        <label for="foto_serial" class="block text-sm font-medium text-gray-300">Foto del Serial</label>
                        <input
                            id="foto_serial"
                            type="file"
                            accept="image/*"
                            @input="setFotoSerial"
                            class="mt-1 block w-full text-white file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700"
                        >
                        <div v-if="form.errors.foto_serial" class="text-red-500 text-sm mt-1">
                            {{ form.errors.foto_serial }}
                        </div>
                        <div v-if="previewSerial" class="mt-3">
                            <p class="text-sm text-gray-300 mb-2">Vista previa:</p>
                            <img :src="previewSerial" alt="Vista previa del serial" class="max-w-xs rounded">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50"
                        >
                            Registrar Dispositivo
                        </button>
                    </div>
                </div>
            </form>
        </div>
</template>

<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Usuario {
    id: number;
    nombres: string;
    apellidos: string;
}

interface Props {
    usuarios: Usuario[];
}

const props = defineProps<Props>();

const form = useForm({
    user_id: '',
    tipo_dispositivo: '',
    marca: '',
    serial: '',
    foto_dispositivo: null as File | null,
    foto_serial: null as File | null,
});

// Vistas previas de imágenes
const previewDispositivo = ref<string | null>(null);
const previewSerial = ref<string | null>(null);

// Funciones para establecer archivos y crear vistas previas
const setFotoDispositivo = (event: Event) => {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files.length > 0) {
        form.foto_dispositivo = input.files[0];
        createPreview(input.files[0], previewDispositivo);
    }
};

const setFotoSerial = (event: Event) => {
    const input = event.target as HTMLInputElement;
    if (input.files && input.files.length > 0) {
        form.foto_serial = input.files[0];
        createPreview(input.files[0], previewSerial);
    }
};

const createPreview = (file: File, preview: any) => {
    const reader = new FileReader();
    reader.onload = (e) => {
        preview.value = e.target?.result as string;
    };
    reader.readAsDataURL(file);
};

// Enviar formulario
const submitForm = () => {
    form.post(route('admin.devices.store'));
};
</script>
