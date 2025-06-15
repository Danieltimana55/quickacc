<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { format } from 'date-fns';
import { es } from 'date-fns/locale';
import { ref, computed } from 'vue';

interface Registro {
    id: number;
    dispositivo: {
        id: number;
        marca: string;
        serial: string;
        usuario: {
            id: number;
            nombres: string;
            apellidos: string;
        } | null;
    };
    hora_entrada: string;
    hora_salida: string | null;
    fecha: string;
    observaciones: string | null;
    foto_registro: string | null;
}

const props = defineProps<{
    registros: Registro[];
}>();

const formatFecha = (dateString: string): string => {
    if (!dateString) return '';
    return format(new Date(dateString), 'dd/MM/yyyy', { locale: es });
};

const formatHora = (timeString: string): string => {
    if (!timeString) return '';
    return timeString.substring(0, 5); // Formato HH:MM
};

const eliminarRegistro = (registro: Registro): void => {
    if (confirm(`¿Estás seguro de que deseas eliminar este registro?`)) {
        router.delete(route('admin.records.destroy', registro.id));
    }
};

// Función para obtener la URL completa de una imagen
const getImageUrl = (path: string | null): string => {
    if (!path) return '';
    return `/storage/${path}`;
};

// Verificar si existe una imagen
const hasImage = (path: string | null): boolean => {
    return !!path;
};

// Abrir imagen en ventana modal
const openImage = (url: string): void => {
    window.open(url, '_blank');
};

// Para búsqueda
const searchTerm = ref('');

// Filtrado de registros
const filteredRegistros = computed(() => {
    if (!searchTerm.value) return props.registros;
    
    const term = searchTerm.value.toLowerCase();
    return props.registros.filter(registro => 
        (registro.dispositivo && registro.dispositivo.marca.toLowerCase().includes(term)) || 
        (registro.dispositivo && registro.dispositivo.serial.toLowerCase().includes(term)) ||
        (registro.dispositivo && registro.dispositivo.usuario && 
         `${registro.dispositivo.usuario.nombres} ${registro.dispositivo.usuario.apellidos}`.toLowerCase().includes(term)) ||
        (registro.observaciones && registro.observaciones.toLowerCase().includes(term))
    );
});

// Nombre completo del usuario
const getNombreUsuario = (registro: Registro): string => {
    return registro.dispositivo && registro.dispositivo.usuario 
        ? `${registro.dispositivo.usuario.nombres} ${registro.dispositivo.usuario.apellidos}` 
        : 'Sin asignar';
};
</script>

<template>
    <Head title="Gestión de Registros" />
    <div class="w-full px-4 md:px-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-4 sm:mb-0">Gestión de registros</h1>
            <button 
                @click="router.get(route('admin.records.create'))"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
                Nuevo Registro
            </button>
        </div>

        <!-- Barra de búsqueda -->
        <div class="mb-4">
            <input
                v-model="searchTerm"
                type="text"
                placeholder="Buscar registros..."
                class="w-full px-4 py-2 bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
        </div>

        <!-- Vista móvil: Tarjetas -->
        <div class="md:hidden space-y-4">
            <div 
                v-for="registro in filteredRegistros" 
                :key="registro.id" 
                class="bg-gray-800/70 p-4 rounded-lg shadow-md"
            >
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-medium text-white">
                            {{ registro.dispositivo.marca }} - {{ registro.dispositivo.serial }}
                        </h3>
                        <p class="text-sm text-gray-300">{{ getNombreUsuario(registro) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-300">{{ formatFecha(registro.fecha) }}</p>
                    </div>
                </div>
                
                <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <span class="font-medium text-gray-300">Entrada:</span>
                        <span class="text-white ml-1">{{ formatHora(registro.hora_entrada) }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-300">Salida:</span>
                        <span class="text-white ml-1">{{ registro.hora_salida ? formatHora(registro.hora_salida) : 'Pendiente' }}</span>
                    </div>
                </div>

                <div v-if="registro.observaciones" class="mt-2 text-sm">
                    <p class="text-gray-300">
                        <span class="font-medium">Observaciones:</span> {{ registro.observaciones }}
                    </p>
                </div>

                <!-- Foto del registro en vista móvil -->
                <div v-if="hasImage(registro.foto_registro)" class="mt-3">
                    <img 
                        :src="getImageUrl(registro.foto_registro)" 
                        alt="Foto del registro" 
                        class="w-full h-32 object-cover rounded cursor-pointer"
                        @click="openImage(getImageUrl(registro.foto_registro))"
                    />
                </div>

                <div class="mt-4 flex justify-end space-x-4">
                    <button 
                        @click="router.get(route('admin.records.edit', registro.id))"
                        class="text-blue-400 hover:text-blue-300"
                    >
                        Editar
                    </button>
                    <button 
                        @click="eliminarRegistro(registro)"
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
                        <th class="py-2 px-4">Fecha</th>
                        <th class="py-2 px-4">Dispositivo</th>
                        <th class="py-2 px-4">Propietario</th>
                        <th class="py-2 px-4">Hora Entrada</th>
                        <th class="py-2 px-4">Hora Salida</th>
                        <th class="py-2 px-4">Observaciones</th>
                        <th class="py-2 px-4">Foto</th>
                        <th class="py-2 px-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="registro in filteredRegistros" :key="registro.id" class="border-t border-gray-700">
                        <td class="py-2 px-4">{{ formatFecha(registro.fecha) }}</td>
                        <td class="py-2 px-4">{{ registro.dispositivo.marca }} - {{ registro.dispositivo.serial }}</td>
                        <td class="py-2 px-4">{{ getNombreUsuario(registro) }}</td>
                        <td class="py-2 px-4">{{ formatHora(registro.hora_entrada) }}</td>
                        <td class="py-2 px-4">{{ registro.hora_salida ? formatHora(registro.hora_salida) : 'Pendiente' }}</td>
                        <td class="py-2 px-4">{{ registro.observaciones || 'Sin observaciones' }}</td>
                        <td class="py-2 px-4">
                            <button 
                                v-if="hasImage(registro.foto_registro)" 
                                @click="openImage(getImageUrl(registro.foto_registro))"
                                class="text-blue-400 hover:text-blue-300"
                            >
                                Ver foto
                            </button>
                            <span v-else class="text-gray-500">Sin foto</span>
                        </td>
                        <td class="py-2 px-4">
                            <button 
                                @click="router.get(route('admin.records.edit', registro.id))"
                                class="text-blue-400 hover:text-blue-300 mr-4"
                            >
                                Editar
                            </button>
                            <button 
                                @click="eliminarRegistro(registro)"
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
        <div v-if="filteredRegistros.length === 0" class="bg-gray-800/70 p-6 rounded-lg text-center text-gray-300">
            No se encontraron registros
        </div>
    </div>
</template> 