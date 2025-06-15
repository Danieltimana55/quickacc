<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

interface Dispositivo {
    id: number;
    tipo_dispositivo: string;
    marca: string;
    serial: string;
    foto_serial: string | null;
    foto_dispositivo: string | null;
    usuario: {
        id: number;
        nombres: string;
        apellidos: string;
    } | null;
}

const props = defineProps<{
    dispositivos: Dispositivo[];
}>();

const eliminarDispositivo = (dispositivo: Dispositivo): void => {
    if (confirm(`¿Estás seguro de que deseas eliminar el dispositivo ${dispositivo.marca} - ${dispositivo.serial}?`)) {
        router.delete(route('admin.devices.destroy', dispositivo.id));
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

// Filtrado de dispositivos
const filteredDispositivos = computed(() => {
    if (!searchTerm.value) return props.dispositivos;
    
    const term = searchTerm.value.toLowerCase();
    return props.dispositivos.filter(dispositivo => 
        dispositivo.marca.toLowerCase().includes(term) || 
        dispositivo.serial.toLowerCase().includes(term) ||
        dispositivo.tipo_dispositivo.toLowerCase().includes(term) ||
        (dispositivo.usuario && 
         `${dispositivo.usuario.nombres} ${dispositivo.usuario.apellidos}`.toLowerCase().includes(term))
    );
});

// Nombre completo del usuario
const getNombreUsuario = (dispositivo: Dispositivo): string => {
    return dispositivo.usuario ? `${dispositivo.usuario.nombres} ${dispositivo.usuario.apellidos}` : 'Sin asignar';
};
</script>

<template>
    <Head title="Gestión de Dispositivos" />
    <div class="w-full px-4 md:px-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-4 sm:mb-0">Gestión de dispositivos</h1>
            <button 
                @click="router.get(route('admin.devices.create'))"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
                Nuevo Dispositivo
            </button>
        </div>

        <!-- Barra de búsqueda -->
        <div class="mb-4">
            <input
                v-model="searchTerm"
                type="text"
                placeholder="Buscar dispositivos..."
                class="w-full px-4 py-2 bg-gray-700 border-gray-600 text-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
        </div>

        <!-- Vista móvil: Tarjetas -->
        <div class="md:hidden space-y-4">
            <div 
                v-for="dispositivo in filteredDispositivos" 
                :key="dispositivo.id" 
                class="bg-gray-800/70 p-4 rounded-lg shadow-md"
            >
                <div class="flex justify-between items-start">
                    <h3 class="text-lg font-medium text-white">{{ dispositivo.marca }}</h3>
                    <span class="bg-blue-600 text-xs text-white px-2 py-1 rounded-full">
                        {{ dispositivo.tipo_dispositivo }}
                    </span>
                </div>
                <div class="mt-2 space-y-1 text-sm">
                    <p class="text-gray-300"><span class="font-medium">Serial:</span> {{ dispositivo.serial }}</p>
                    <p class="text-gray-300"><span class="font-medium">Propietario:</span> {{ getNombreUsuario(dispositivo) }}</p>
                </div>

                <!-- Fotos en vista móvil -->
                <div class="mt-3 flex flex-wrap gap-2 justify-start">
                    <div v-if="hasImage(dispositivo.foto_dispositivo)" class="w-24 h-24 relative">
                        <img 
                            :src="getImageUrl(dispositivo.foto_dispositivo)" 
                            alt="Foto del dispositivo" 
                            class="w-full h-full object-cover rounded" 
                            @click="openImage(getImageUrl(dispositivo.foto_dispositivo))"
                        />
                        <span class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-70 text-white text-xs text-center p-1">
                            Dispositivo
                        </span>
                    </div>
                    <div v-if="hasImage(dispositivo.foto_serial)" class="w-24 h-24 relative">
                        <img 
                            :src="getImageUrl(dispositivo.foto_serial)" 
                            alt="Foto del serial" 
                            class="w-full h-full object-cover rounded" 
                            @click="openImage(getImageUrl(dispositivo.foto_serial))"
                        />
                        <span class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-70 text-white text-xs text-center p-1">
                            Serial
                        </span>
                    </div>
                </div>

                <div class="mt-4 flex justify-end space-x-4">
                    <button 
                        @click="router.get(route('admin.devices.edit', dispositivo.id))"
                        class="text-blue-400 hover:text-blue-300"
                    >
                        Editar
                    </button>
                    <button 
                        @click="eliminarDispositivo(dispositivo)"
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
                        <th class="py-2 px-4">Propietario</th>
                        <th class="py-2 px-4">Tipo</th>
                        <th class="py-2 px-4">Marca</th>
                        <th class="py-2 px-4">Serial</th>
                        <th class="py-2 px-4">Fotos</th>
                        <th class="py-2 px-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="dispositivo in filteredDispositivos" :key="dispositivo.id" class="border-t border-gray-700">
                        <td class="py-2 px-4">
                            {{ getNombreUsuario(dispositivo) }}
                        </td>
                        <td class="py-2 px-4">{{ dispositivo.tipo_dispositivo }}</td>
                        <td class="py-2 px-4">{{ dispositivo.marca }}</td>
                        <td class="py-2 px-4">{{ dispositivo.serial }}</td>
                        <td class="py-2 px-4">
                            <div class="flex gap-2">
                                <button 
                                    v-if="hasImage(dispositivo.foto_dispositivo)" 
                                    @click="openImage(getImageUrl(dispositivo.foto_dispositivo))"
                                    class="text-blue-400 hover:text-blue-300"
                                >
                                    Ver dispositivo
                                </button>
                                <button 
                                    v-if="hasImage(dispositivo.foto_serial)" 
                                    @click="openImage(getImageUrl(dispositivo.foto_serial))"
                                    class="text-blue-400 hover:text-blue-300"
                                >
                                    Ver serial
                                </button>
                            </div>
                        </td>
                        <td class="py-2 px-4">
                            <button 
                                @click="router.get(route('admin.devices.edit', dispositivo.id))"
                                class="text-blue-400 hover:text-blue-300 mr-4"
                            >
                                Editar
                            </button>
                            <button 
                                @click="eliminarDispositivo(dispositivo)"
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
        <div v-if="filteredDispositivos.length === 0" class="bg-gray-800/70 p-6 rounded-lg text-center text-gray-300">
            No se encontraron dispositivos
        </div>
    </div>
</template>
