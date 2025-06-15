<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Plus, Trash } from 'lucide-vue-next';
import { defineProps } from 'vue';

interface User {
    id: number;
    nombres: string;
    apellidos: string;
}

interface Code {
    id: number;
    code: string;
    is_used: boolean;
    used_at: string | null;
    expires_at: string | null;
    used_by_user: User | null;
}

interface Props {
    codes: Code[];
}

const props = defineProps<Props>();

const formatDate = (dateString: string | null) => {
    if (!dateString) return 'N/A';
    return new Date(dateString).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const deleteCode = (id: number) => {
    if (confirm('¿Está seguro de eliminar este código de verificación?')) {
        router.delete(route('admin.instructor-codes.destroy', id));
    }
};

</script>

<template>
    <Head title="Códigos de Verificación de Instructores" />

    <div>
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-white">Códigos de Verificación de Instructores</h1>
            <Link :href="route('admin.instructor-codes.create')">
                <Button variant="default" class="bg-blue-600 hover:bg-blue-700">
                    <Plus class="h-4 w-4 mr-2" />
                    Crear Código
                </Button>
            </Link>
        </div>

        <div class="bg-gray-800/70 p-6 rounded-lg overflow-x-auto">
            <table class="w-full text-left text-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4">Código</th>
                        <th class="py-2 px-4">Estado</th>
                        <th class="py-2 px-4">Utilizado por</th>
                        <th class="py-2 px-4">Fecha de Uso</th>
                        <th class="py-2 px-4">Fecha de Expiración</th>
                        <th class="py-2 px-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="code in codes" :key="code.id" class="border-t border-gray-700">
                        <td class="py-2 px-4">{{ code.code }}</td>
                        <td class="py-2 px-4">
                            <span v-if="code.is_used" class="px-2 py-1 rounded-full text-xs bg-red-500/20 text-red-400">Utilizado</span>
                            <span v-else class="px-2 py-1 rounded-full text-xs bg-green-500/20 text-green-400">Disponible</span>
                        </td>
                        <td class="py-2 px-4">
                            {{ code.used_by_user ? `${code.used_by_user.nombres} ${code.used_by_user.apellidos}` : 'N/A' }}
                        </td>
                        <td class="py-2 px-4">{{ formatDate(code.used_at) }}</td>
                        <td class="py-2 px-4">{{ formatDate(code.expires_at) }}</td>
                        <td class="py-2 px-4">
                            <button 
                                v-if="!code.is_used" 
                                @click="deleteCode(code.id)"
                                class="text-red-400 hover:text-red-300"
                            >
                                <Trash class="h-4 w-4" />
                            </button>
                            <span v-else class="text-gray-500">N/A</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template> 