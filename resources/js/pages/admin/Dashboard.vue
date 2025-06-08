<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Users, Shield, Smartphone, BookOpen } from 'lucide-vue-next';

const stats = [
    { name: 'Total Users', value: '0', icon: Users },
    { name: 'Total Roles', value: '0', icon: Shield },
    { name: 'Total Devices', value: '0', icon: Smartphone },
    { name: 'Total Formations', value: '0', icon: BookOpen },
];
</script>

<template>
    <Head title="Admin Dashboard" />
    <div>
        <h1 class="text-3xl font-bold text-white mb-6">Admin Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div v-for="stat in stats" :key="stat.name" class="bg-gray-800/70 p-6 rounded-lg flex items-center gap-6">
                <component :is="stat.icon" class="h-8 w-8 text-blue-400" />
                <div>
                    <p class="text-sm text-gray-400">{{ stat.name }}</p>
                    <p class="text-2xl font-semibold text-white">{{ stat.value }}</p>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-xl font-bold text-white mb-4">Recent Activity</h2>
            <div class="bg-gray-800/70 p-6 rounded-lg">
                <p class="text-gray-400">Activity logs will be displayed here.</p>
            </div>
        </div>
    </div>
</template> 