<template>
    <div class="pt-2 pb-3 space-y-1">
        <div class="px-4 text-center">
            <div class="font-medium text-base text-skyblue-vlight">
                {{ $page.props.auth.user.nombre }}
                {{ $page.props.auth.user.apellidos }}
            </div>
            <div class="font-medium text-sm text-lavender-vlight">
                {{ $page.props.auth.user.email }}
            </div>
        </div>
        <ResponsiveNavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            Panel de Usuario
        </ResponsiveNavLink>
        <ResponsiveNavLink
            :href="route('admin.indexInforme')"
            :active="
                route().current('admin.indexInforme') ||
                route().current('admin.ultimoMesInforme') ||
                route().current('admin.informeGeneral') ||
                route().current('admin.personalizarInforme') ||
                ruta === '/informe_personalizado'
            "
        >
            Informes
        </ResponsiveNavLink>
        <ResponsiveNavLink
            :href="route('admin.indexReservas')"
            :active="
                route().current('admin.indexReservas') ||
                route().current('admin.listReservas')
            "
        >
            Gestión de Reservas
        </ResponsiveNavLink>
    </div>
    <div class="pt-2 pb-3 space-y-1 border-t border-skyblue-vlight">
        <div class="px-4">
            <div class="font-sm text-base text-center text-skyblue-vlight">
                Gestión de Datos
            </div>
        </div>
        <ResponsiveNavLink
            :href="route('admin.indexCode')"
            :active="
                route().current('admin.indexCode') ||
                route().current('admin.genCode') ||
                route().current('admin.delCode')
            "
        >
            Códigos de Registro
        </ResponsiveNavLink>
        <ResponsiveNavLink
            :href="route('admin.indexCenter')"
            :active="
                route().current('admin.indexCenter') ||
                route().current('admin.createCenter') ||
                route().current('admin.listCenter') ||
                route().current('admin.modCenter')
            "
        >
            Centros Asociados
        </ResponsiveNavLink>
        <ResponsiveNavLink
            :href="route('admin.indexZona')"
            :active="
                route().current('admin.indexZona') ||
                route().current('admin.createZona') ||
                route().current('admin.listZona') ||
                route().current('admin.modZona')
            "
        >
            Zonas Tratamiento
        </ResponsiveNavLink>
        <ResponsiveNavLink
            :href="route('admin.indexDias')"
            :active="
                route().current('admin.indexDias') ||
                route().current('admin.createDias') ||
                route().current('admin.listDias') ||
                route().current('admin.modDias')
            "
        >
            Dias Asignados
        </ResponsiveNavLink>
    </div>
    <div class="pt-4 pb-1 border-t border-skyblue-vlight">
        <div class="space-y-1">
            <ResponsiveNavLink :href="route('home')">
                Volver al Inicio
            </ResponsiveNavLink>
            <ResponsiveNavLink
                :href="route('admin.profileEdit')"
                :active="route().current('admin.profileEdit')"
            >
                Editar Perfil
            </ResponsiveNavLink>
            <ResponsiveNavLink @click.prevent="closeSession()">
                Desconectar
            </ResponsiveNavLink>
        </div>
    </div>
</template>
<script setup>
import ResponsiveNavLink from "@/Components/breeze_components/ResponsiveNavLink.vue";
import { closeSession } from "@/Utils/alerts";
import { usePage } from "@inertiajs/vue3";

//Constantes para obtener el nombre de la ruta POST y usarlo para mostrar activo su enlace
const page = usePage();
const ruta = page.url;
</script>
