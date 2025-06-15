import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
}

export interface User {
    id: number;
    nombres: string;
    apellidos: string;
    tipo_documento: string;
    numero_documento: string;
    email: string;
    email_verified_at: string | null;
    rol_id: number;
    formacion_id?: number;
    rol?: Rol;
    formacion?: Formacion;
    created_at: string;
    updated_at: string;
}

export interface Rol {
    id: number;
    nombre: string;
    descripcion: string;
    created_at: string;
    updated_at: string;
}

export interface Formacion {
    id: number;
    nombre: string;
    nivel: string;
    numero_ficha: string;
    instructor_id?: number;
    numero_ambiente: string;
    fecha_inicio: string;
    fecha_fin: string;
    jornada_id?: number;
    created_at: string;
    updated_at: string;
}

export interface Jornada {
    id: number;
    nombre: string;
    hora_entrada: string;
    hora_salida: string;
    created_at: string;
    updated_at: string;
}

export interface Dispositivo {
    id: number;
    tipo_dispositivo: string;
    marca: string;
    serial: string;
    foto_serial: string;
    foto_dispositivo: string;
    user_id: number;
    created_at: string;
    updated_at: string;
}

export interface Registro {
    id: number;
    tipo_registro: string;
    user_id: number;
    rol_id: number;
    celador_id: number;
    observacion?: string;
    justificacion?: string;
    foto_soporte?: string;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
