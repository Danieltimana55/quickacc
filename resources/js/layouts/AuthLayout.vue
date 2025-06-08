<script setup lang="ts">
defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-900 p-4">
        <div class="w-full max-w-md bg-gray-800 p-6 rounded-lg">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-white">{{ title }}</h2>
                <p class="text-gray-300">{{ description }}</p>
            </div>
            <slot />
        </div>
    </div>
</template> 