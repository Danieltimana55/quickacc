<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex min-h-svh flex-col items-center justify-center p-6 md:p-10 bg-gray-900">
        <div class="w-full max-w-md backdrop-blur-md bg-gray-800/60 rounded-xl shadow-lg border border-gray-700/30 p-6 md:p-8">
            <div class="flex flex-col gap-8">
                <div class="flex flex-col items-center gap-4">
                    <Link :href="route('home')" class="flex flex-col items-center gap-2 font-medium">
                        <div class="mb-1 flex h-20 w-20 items-center justify-center rounded-full bg-gray-700/80 shadow-md p-1">
                            <AppLogoIcon class="h-full w-full object-contain" />
                        </div>
                        <span class="sr-only">{{ title }}</span>
                    </Link>
                    <div class="space-y-2 text-center">
                        <h1 class="text-2xl font-bold text-white">{{ title }}</h1>
                        <p class="text-center text-sm text-gray-300">{{ description }}</p>
                    </div>
                </div>
                <slot />
            </div>
        </div>
    </div>
</template> 