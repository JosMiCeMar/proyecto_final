<template>
    <div class="pt-2 pb-3 space-y-1">
        <ResponsiveNavLink
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            Panel de Usuario
        </ResponsiveNavLink>
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

    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-skyblue-vlight">
        <div class="px-4">
            <div class="font-medium text-base text-gray-300">
                {{ $page.props.auth.user.nombre }}
                {{ $page.props.auth.user.apellidos }}
            </div>
            <div class="font-medium text-sm text-lavender-vlight">
                {{ $page.props.auth.user.email }}
            </div>
        </div>

        <div class="mt-3 space-y-1">
            <ResponsiveNavLink :href="route('home')">
                Volver al Inicio
            </ResponsiveNavLink>
            <ResponsiveNavLink
                :href="route('admin.profileEdit')"
                :active="route().current('admin.profileEdit')"
            >
                Editar Perfil
            </ResponsiveNavLink>
            <ResponsiveNavLink  @click.prevent="closeSession()">
                Desconectar
            </ResponsiveNavLink>
        </div>
    </div>
</template>
<script setup>
import ResponsiveNavLink from "@/Components/breeze_components/ResponsiveNavLink.vue";
import { closeSession } from "@/Utils/alerts";
</script>
