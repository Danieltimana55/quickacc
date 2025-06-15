<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@/layouts/AdminLayout.vue';
import { User, Rol, Formacion } from '@/types';

interface Props {
  user: User & {
    rol: Rol;
    formacion: Formacion | null;
  };
}

const props = defineProps<Props>();
</script>
<template>
   <Head title="Detalles del Usuario"/>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="mb-6">
              <a
                :href="route('admin.users.index')"
                class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition"
              >
                Volver a la lista
              </a>
              <a
                :href="route('admin.users.edit', props.user.id)"
                class="ml-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500 transition"
              >
                Editar
              </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <h3 class="text-lg font-semibold mb-4">Información Personal</h3>
                <div class="mb-4">
                  <p class="text-sm text-gray-600">Nombres</p>
                  <p class="font-medium">{{ props.user.nombres }}</p>
                </div>
                <div class="mb-4">
                  <p class="text-sm text-gray-600">Apellidos</p>
                  <p class="font-medium">{{ props.user.apellidos }}</p>
                </div>
                <div class="mb-4">
                  <p class="text-sm text-gray-600">Tipo de Documento</p>
                  <p class="font-medium">{{ props.user.tipo_documento }}</p>
                </div>
                <div class="mb-4">
                  <p class="text-sm text-gray-600">Número de Documento</p>
                  <p class="font-medium">{{ props.user.numero_documento }}</p>
                </div>
              </div>

              <div>
                <h3 class="text-lg font-semibold mb-4">Información de Cuenta</h3>
                <div class="mb-4">
                  <p class="text-sm text-gray-600">Correo Electrónico</p>
                  <p class="font-medium">{{ props.user.email }}</p>
                </div>
                <div class="mb-4">
                  <p class="text-sm text-gray-600">Rol</p>
                  <p class="font-medium">{{ props.user.rol.nombre }}</p>
                </div>
                <div v-if="props.user.formacion" class="mb-4">
                  <p class="text-sm text-gray-600">Formación</p>
                  <p class="font-medium">{{ props.user.formacion.nombre }}</p>
                </div>
                <div class="mb-4">
                  <p class="text-sm text-gray-600">Fecha de Creación</p>
                  <p class="font-medium">{{ new Date(props.user.created_at).toLocaleDateString() }}</p>
                </div>
                <div class="mb-4">
                  <p class="text-sm text-gray-600">Última Actualización</p>
                  <p class="font-medium">{{ new Date(props.user.updated_at).toLocaleDateString() }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>