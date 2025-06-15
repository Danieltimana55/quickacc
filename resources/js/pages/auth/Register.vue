<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
import { computed } from 'vue';

const form = useForm({
    nombres: '',
    apellidos: '',
    tipo_documento: 'CC',
    numero_documento: '',
    email: '',
    password: '',
    password_confirmation: '',
    rol_id: '4', // Por defecto, rol de aprendiz
    codigo_instructor: '', // Para validación de instructores
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation', 'codigo_instructor'),
    });
};

const tiposDocumento = [
    { value: 'CC', label: 'Cédula de Ciudadanía' },
    { value: 'TI', label: 'Tarjeta de Identidad' },
    { value: 'CE', label: 'Cédula de Extranjería' },
    { value: 'PAS', label: 'Pasaporte' },
];

const roles = [
    { value: '4', label: 'Aprendiz' },
    { value: '3', label: 'Instructor' },
];

// Mostrar u ocultar campo de código de instructor
const mostrarCodigoInstructor = computed(() => form.rol_id === '3');
</script>

<template>
    <AuthBase title="Crear una cuenta" description="Ingrese sus datos para crear una cuenta">
        <Head title="Registro" />

        <form @submit.prevent="submit" class="flex flex-col gap-6">
            <div class="grid gap-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="grid gap-2">
                        <Label for="nombres" class="text-gray-200">Nombres</Label>
                        <Input
                            id="nombres"
                            type="text"
                            required
                            autofocus
                            :tabindex="1"
                            v-model="form.nombres"
                            placeholder="Nombres"
                            class="bg-gray-700/50 border-gray-600/50 text-white placeholder-gray-400"
                        />
                        <InputError :message="form.errors.nombres" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="apellidos" class="text-gray-200">Apellidos</Label>
                        <Input
                            id="apellidos"
                            type="text"
                            required
                            :tabindex="2"
                            v-model="form.apellidos"
                            placeholder="Apellidos"
                            class="bg-gray-700/50 border-gray-600/50 text-white placeholder-gray-400"
                        />
                        <InputError :message="form.errors.apellidos" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="grid gap-2">
                        <Label for="tipo_documento" class="text-gray-200">Tipo de documento</Label>
                        <select
                            id="tipo_documento"
                            v-model="form.tipo_documento"
                            :tabindex="3"
                            class="bg-gray-700/50 border border-gray-600/50 rounded-md p-2 text-white"
                        >
                            <option v-for="tipo in tiposDocumento" :key="tipo.value" :value="tipo.value">
                                {{ tipo.label }}
                            </option>
                        </select>
                        <InputError :message="form.errors.tipo_documento" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="numero_documento" class="text-gray-200">Número de documento</Label>
                        <Input
                            id="numero_documento"
                            type="text"
                            required
                            :tabindex="4"
                            v-model="form.numero_documento"
                            placeholder="Número de documento"
                            class="bg-gray-700/50 border-gray-600/50 text-white placeholder-gray-400"
                        />
                        <InputError :message="form.errors.numero_documento" />
                    </div>
                </div>

                <div class="grid gap-2">
                    <Label for="email" class="text-gray-200">Correo electrónico</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        :tabindex="5"
                        autocomplete="email"
                        v-model="form.email"
                        placeholder="correo@ejemplo.com"
                        class="bg-gray-700/50 border-gray-600/50 text-white placeholder-gray-400"
                    />
                    <InputError :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="rol_id" class="text-gray-200">Tipo de Usuario</Label>
                    <select
                        id="rol_id"
                        v-model="form.rol_id"
                        :tabindex="6"
                        class="bg-gray-700/50 border border-gray-600/50 rounded-md p-2 text-white"
                    >
                        <option v-for="rol in roles" :key="rol.value" :value="rol.value">
                            {{ rol.label }}
                        </option>
                    </select>
                    <InputError :message="form.errors.rol_id" />
                </div>

                <div v-if="mostrarCodigoInstructor" class="grid gap-2">
                    <Label for="codigo_instructor" class="text-gray-200">Código de Verificación</Label>
                    <Input
                        id="codigo_instructor"
                        type="text"
                        :tabindex="7"
                        v-model="form.codigo_instructor"
                        placeholder="Ingrese el código de verificación de instructor"
                        class="bg-gray-700/50 border-gray-600/50 text-white placeholder-gray-400"
                    />
                    <p class="text-xs text-gray-400">Este código es proporcionado por el administrador del sistema.</p>
                    <InputError :message="form.errors.codigo_instructor" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="grid gap-2">
                        <Label for="password" class="text-gray-200">Contraseña</Label>
                        <Input
                            id="password"
                            type="password"
                            required
                            :tabindex="8"
                            autocomplete="new-password"
                            v-model="form.password"
                            placeholder="Contraseña"
                            class="bg-gray-700/50 border-gray-600/50 text-white placeholder-gray-400"
                        />
                        <InputError :message="form.errors.password" />
                    </div>

                    <div class="grid gap-2">
                        <Label for="password_confirmation" class="text-gray-200">Confirmar contraseña</Label>
                        <Input
                            id="password_confirmation"
                            type="password"
                            required
                            :tabindex="9"
                            autocomplete="new-password"
                            v-model="form.password_confirmation"
                            placeholder="Confirmar contraseña"
                            class="bg-gray-700/50 border-gray-600/50 text-white placeholder-gray-400"
                        />
                        <InputError :message="form.errors.password_confirmation" />
                    </div>
                </div>

                <Button type="submit" class="mt-2 w-full bg-blue-600 hover:bg-blue-700 text-white" :tabindex="10" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Crear cuenta
                </Button>
            </div>

            <div class="text-center text-sm text-gray-300">
                ¿Ya tiene una cuenta?
                <TextLink :href="route('login')" class="text-blue-400 hover:text-blue-300" :tabindex="11">Iniciar sesión</TextLink>
            </div>
        </form>
    </AuthBase>
</template>


