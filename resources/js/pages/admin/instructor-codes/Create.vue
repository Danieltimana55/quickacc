<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

const form = useForm({
    code: '',
    expires_at: '',
});

const submit = () => {
    form.post(route('admin.instructor-codes.store'));
};
</script>

<template>
    <Head title="Crear Código de Verificación" />

    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-white">Crear Código de Verificación</h1>
            <Link 
                :href="route('admin.instructor-codes.index')"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors"
            >
                Volver
            </Link>
        </div>

        <form @submit.prevent="submit">
            <div class="space-y-6 bg-gray-800 p-6 rounded-lg">
                <div>
                    <Label for="code" class="text-sm font-medium text-gray-300">
                        Código (opcional)
                    </Label>
                    <Input
                        id="code"
                        v-model="form.code"
                        type="text"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md"
                    />
                    <p class="text-xs text-gray-400 mt-1">
                        Si deja este campo vacío, se generará un código aleatorio.
                    </p>
                    <InputError :message="form.errors.code" />
                </div>

                <div>
                    <Label for="expires_at" class="text-sm font-medium text-gray-300">
                        Fecha de Expiración (opcional)
                    </Label>
                    <Input
                        id="expires_at"
                        v-model="form.expires_at"
                        type="date"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-gray-300 rounded-md"
                    />
                    <p class="text-xs text-gray-400 mt-1">
                        Si deja este campo vacío, el código no expirará.
                    </p>
                    <InputError :message="form.errors.expires_at" />
                </div>

                <div class="flex justify-end pt-4">
                    <Button 
                        type="submit"
                        :disabled="form.processing"
                        class="bg-blue-600 hover:bg-blue-700 text-white"
                    >
                        Crear Código
                    </Button>
                </div>
            </div>
        </form>
    </div>
</template> 