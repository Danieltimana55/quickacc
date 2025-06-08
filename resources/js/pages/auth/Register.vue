<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
    nombres: '',
    apellidos: '',
    tipo_documento: 'CC',
    numero_documento: '',
    email: '',
    password: '',
    password_confirmation: '',
    rol_id: '4', // Por defecto, rol de aprendiz
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};

const tiposDocumento = [
    { value: 'CC', label: 'Cédula de Ciudadanía' },
    { value: 'TI', label: 'Tarjeta de Identidad' },
    { value: 'CE', label: 'Cédula de Extranjería' },
    { value: 'PAS', label: 'Pasaporte' },
];
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="grid gap-2">
                        <Label for="password" class="text-gray-200">Contraseña</Label>
                        <Input
                            id="password"
                            type="password"
                            required
                            :tabindex="6"
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
                            :tabindex="7"
                            autocomplete="new-password"
                            v-model="form.password_confirmation"
                            placeholder="Confirmar contraseña"
                            class="bg-gray-700/50 border-gray-600/50 text-white placeholder-gray-400"
                        />
                        <InputError :message="form.errors.password_confirmation" />
                    </div>
                </div>

                <Button type="submit" class="mt-2 w-full bg-blue-600 hover:bg-blue-700 text-white" :tabindex="8" :disabled="form.processing">
                    <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                    Crear cuenta
                </Button>
            </div>

            <div class="text-center text-sm text-gray-300">
                ¿Ya tiene una cuenta?
                <TextLink :href="route('login')" class="text-blue-400 hover:text-blue-300" :tabindex="9">Iniciar sesión</TextLink>
            </div>
        </form>
    </AuthBase>
</template>


