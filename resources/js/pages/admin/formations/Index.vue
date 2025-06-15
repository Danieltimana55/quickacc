<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { format } from 'date-fns';
import { es } from 'date-fns/locale';
import { ref, computed } from 'vue';

interface Formacion {
    id: number;
    nombre: string;
    nivel: string;
    numero_ficha: string;
    numero_ambiente: string;
    fecha_inicio: string;
    fecha_fin: string;
    instructor: {
        id: number;
        nombres: string;
        apellidos: string;
    } | null;
    jornada: {
        id: number;
        nombre: string;
    } | null;
}

const props = defineProps<{
    formaciones: Formacion[];
}>();

const formatDate = (dateString: string): string => {
    if (!dateString) return '';
    return format(new Date(dateString), 'dd/MM/yyyy', { locale: es });
};

const eliminarFormacion = (formacion: Formacion): void => {
    if (confirm(`¿Estás seguro de que deseas eliminar la formación "${formacion.nombre}"?`)) {
        router.delete(route('admin.formations.destroy', formacion.id));
    }
};

// Para búsqueda
const searchTerm = ref('');

// Filtrado de formaciones
const filteredFormaciones = computed(() => {
    if (!searchTerm.value) return props.formaciones;
    
    const term = searchTerm.value.toLowerCase();
    return props.formaciones.filter(formacion => 
        formacion.nombre.toLowerCase().includes(term) || 
        formacion.numero_ficha.toLowerCase().includes(term) ||
        (formacion.instructor && 
         `${formacion.instructor.nombres} ${formacion.instructor.apellidos}`.toLowerCase().includes(term))
    );
});
</script>

<template>
    <Head title="Gestión de Formaciones" />
    <div class="w-full px-4 md:px-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-4 sm:mb-0">Gestión de formaciones</h1>
            <button 
                @click="router.get(route('admin.formations.create'))"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
                Nueva Formación
            </button>
        </div>

        <!-- Barra de búsqueda -->
        <div class="mb-4">
            <input
                v-model="searchTerm"
                type="text"
                placeholder="Buscar formaciones..."
                class="w-full px-4 py-2 bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
        </div>

        <!-- Vista móvil: Tarjetas -->
        <div class="md:hidden space-y-4">
            <div 
                v-for="formacion in filteredFormaciones" 
                :key="formacion.id" 
                class="bg-gray-800/70 p-4 rounded-lg shadow-md"
            >
                <div class="flex justify-between items-start">
                    <h3 class="text-lg font-medium text-white">{{ formacion.nombre }}</h3>
                    <span class="bg-blue-600 text-xs text-white px-2 py-1 rounded-full">{{ formacion.nivel }}</span>
                </div>
                <div class="mt-2 space-y-1 text-sm">
                    <p class="text-gray-300"><span class="font-medium">Ficha:</span> {{ formacion.numero_ficha }}</p>
                    <p class="text-gray-300">
                        <span class="font-medium">Instructor:</span> 
                        {{ formacion.instructor ? `${formacion.instructor.nombres} ${formacion.instructor.apellidos}` : 'Sin asignar' }}
                    </p>
                    <p class="text-gray-300"><span class="font-medium">Ambiente:</span> {{ formacion.numero_ambiente }}</p>
                    <p class="text-gray-300">
                        <span class="font-medium">Jornada:</span> 
                        {{ formacion.jornada ? formacion.jornada.nombre : 'Sin asignar' }}
                    </p>
                    <p class="text-gray-300">
                        <span class="font-medium">Fechas:</span> 
                        {{ formatDate(formacion.fecha_inicio) }} - {{ formatDate(formacion.fecha_fin) }}
                    </p>
                </div>
                <div class="mt-4 flex justify-end space-x-4">
                    <button 
                        @click="router.get(route('admin.formations.edit', formacion.id))"
                        class="text-blue-400 hover:text-blue-300"
                    >
                        Editar
                    </button>
                    <button 
                        @click="eliminarFormacion(formacion)"
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
                        <th class="py-2 px-4">Nombre</th>
                        <th class="py-2 px-4">Ficha</th>
                        <th class="py-2 px-4">Nivel</th>
                        <th class="py-2 px-4">Instructor</th>
                        <th class="py-2 px-4">Ambiente</th>
                        <th class="py-2 px-4">Jornada</th>
                        <th class="py-2 px-4">Fechas</th>
                        <th class="py-2 px-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="formacion in filteredFormaciones" :key="formacion.id" class="border-t border-gray-700">
                        <td class="py-2 px-4">{{ formacion.nombre }}</td>
                        <td class="py-2 px-4">{{ formacion.numero_ficha }}</td>
                        <td class="py-2 px-4">{{ formacion.nivel }}</td>
                        <td class="py-2 px-4">
                            {{ formacion.instructor ? `${formacion.instructor.nombres} ${formacion.instructor.apellidos}` : 'Sin asignar' }}
                        </td>
                        <td class="py-2 px-4">{{ formacion.numero_ambiente }}</td>
                        <td class="py-2 px-4">{{ formacion.jornada ? formacion.jornada.nombre : 'Sin asignar' }}</td>
                        <td class="py-2 px-4">
                            {{ formatDate(formacion.fecha_inicio) }} - {{ formatDate(formacion.fecha_fin) }}
                        </td>
                        <td class="py-2 px-4">
                            <button 
                                @click="router.get(route('admin.formations.edit', formacion.id))"
                                class="text-blue-400 hover:text-blue-300 mr-4"
                            >
                                Editar
                            </button>
                            <button 
                                @click="eliminarFormacion(formacion)"
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
        <div v-if="filteredFormaciones.length === 0" class="bg-gray-800/70 p-6 rounded-lg text-center text-gray-300">
            No se encontraron formaciones
        </div>
    </div>
</template>

