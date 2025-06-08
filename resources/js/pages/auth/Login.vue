<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import AuthLayout from '@/layouts/AuthLayout.vue';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <AuthLayout title="Iniciar sesión" description="Ingrese sus credenciales para acceder al sistema">
        <Head title="Iniciar sesión" />
        
        <div v-if="status" class="mb-4 p-2 bg-green-800 text-green-100 rounded">
            {{ status }}
        </div>
        
        <form @submit.prevent="submit">
            <div class="mb-4">
                <label for="email" class="block mb-1 text-white">Correo electrónico</label>
                <input
                    id="email"
                    type="email"
                    v-model="form.email"
                    class="w-full px-3 py-2 bg-gray-700 rounded text-white"
                    required
                />
                <div v-if="form.errors.email" class="text-red-500 mt-1">
                    {{ form.errors.email }}
                </div>
            </div>
            
            <div class="mb-4">
                <label for="password" class="block mb-1 text-white">Contraseña</label>
                <input
                    id="password"
                    type="password"
                    v-model="form.password"
                    class="w-full px-3 py-2 bg-gray-700 rounded text-white"
                    required
                />
                <div v-if="form.errors.password" class="text-red-500 mt-1">
                    {{ form.errors.password }}
                </div>
            </div>
            
            <div class="mb-4 flex items-center">
                <input
                    id="remember"
                    type="checkbox"
                    v-model="form.remember"
                    class="mr-2"
                />
                <label for="remember" class="text-white">Recordarme</label>
            </div>
            
            <div class="mb-4">
                <button
                    type="submit"
                    class="w-full py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    :disabled="form.processing"
                >
                    <span v-if="form.processing">Procesando...</span>
                    <span v-else>Iniciar sesión</span>
                </button>
            </div>
            
            <div class="text-center" v-if="canResetPassword">
                <a :href="route('password.request')" class="text-blue-400 hover:text-blue-300">
                    ¿Olvidó su contraseña?
                </a>
            </div>
        </form>
    </AuthLayout>
</template>


