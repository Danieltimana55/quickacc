import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import AdminLayout from './layouts/AdminLayout.vue';
import AprendizLayout from './layouts/AprendizLayout.vue';
import InstructorLayout from './layouts/InstructorLayout.vue';
import CeladorLayout from './layouts/CeladorLayout.vue';
import DashboardLayout from './layouts/DashboardLayout.vue';

const appName = 'QuickAcc';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = resolvePageComponent(`./pages/${name}.vue`, import.meta.glob('./pages/**/*.vue'));
        
        if (name.startsWith('admin/')) {
            page.then((module) => {
                module.default.layout = AdminLayout;
            });
        } else if (name.startsWith('aprendiz/')) {
            page.then((module) => {
                module.default.layout = AprendizLayout;
            });
        } else if (name.startsWith('instructor/')) {
            page.then((module) => {
                module.default.layout = InstructorLayout;
            });
        } else if (name.startsWith('celador/')) {
            page.then((module) => {
                module.default.layout = CeladorLayout;
            });
        } else if (!name.startsWith('auth/')) {
            page.then((module) => {
                module.default.layout = DashboardLayout;
            });
        }
        
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
}); 